# New App Boilerplate Guide

A complete "start here" reference for the next Laravel + NativePHP Android app.
Built from hard-learned lessons on the Tipping Pool project. Copy this to every new project.

---

## 1. Choose Your Distribution Strategy First

Before writing a line of code, decide how the app will be distributed. This shapes everything.

| Strategy | When to use | Play Store path |
|---|---|---|
| **Web + TWA** | Multi-user, server needed, Railway deploy | PWABuilder wraps Railway URL |
| **NativePHP native** | Single-device or offline-first, no server | `native:run android` → APK → Play Store |
| **Web only** | No Play Store needed | Just Railway |

**The Tipping Pool uses Web + TWA** — Railway hosts the app, PWABuilder wraps it as a Trusted Web Activity. NativePHP is also installed for single-device use, but it's secondary. For most multi-user apps, Web + TWA is the right call: simpler builds, no APK per update, instant deploys.

---

## 2. Scaffold the Project

```bash
# Create new Laravel project with NativePHP starter kit
composer create-project nativephp/laravel-starter my-app

cd my-app

# Run first-time setup
composer run setup
```

Then immediately fix `.env` before doing anything else:

```env
APP_URL=http://localhost:8000
NATIVEPHP_APP_VERSION=1.0.0
FOOTBALL_DATA_API_KEY=           # or whatever external API you use
```

**Why APP_URL:** the starter kit generates a broken double-port URL like `http://localhost:8000:8000`.
**Why NATIVEPHP_APP_VERSION:** using "DEBUG" causes a 97MB ZIP re-extract on every cold start.

---

## 3. Immediate Fixes (Apply Before Any Feature Work)

### 3a. Remove forceHttps

In `app/Providers/AppServiceProvider.php`, remove any `URL::forceHttps()` call from `boot()`.
NativePHP's embedded server is HTTP — this crashes the app.

### 3b. Enable PHP Extensions

File: `C:\php\php.ini` — uncomment:

```ini
extension=curl
extension=gd
extension=pdo_sqlite
extension=sqlite3
```

Kill all `php.exe` processes after saving.

### 3c. Fix composer.json scripts

Replace the default scripts section with this battle-tested version:

```json
"scripts": {
    "setup": [
        "composer install",
        "@php -r \"file_exists('.env') || copy('.env.example', '.env');\"",
        "@php artisan key:generate",
        "@php artisan migrate --force",
        "npm install --ignore-scripts",
        "npm run build"
    ],
    "dev": [
        "Composer\\Config::disableProcessTimeout",
        "npx concurrently -c \"#93c5fd,#c4b5fd,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1 --timeout=0\" \"npm run dev\" --names=server,queue,vite --kill-others"
    ],
    "test": [
        "@php artisan config:clear --ansi",
        "@php artisan test"
    ]
}
```

This starts the PHP server (8000), queue worker, and Vite (5173) in one command.

---

## 4. Architecture Patterns That Work

### Blade SPA (single-file frontend)

Everything lives in `resources/views/welcome.blade.php`. No React, no Vue, no routing packages.

- Each screen is `<div id="screen-[name]" class="screen">` hidden by default
- `showScreen(id)` toggles visibility — fast, zero dependencies
- One global `state` object holds all app data; `localStorage` is its cache
- `init()` loads from `localStorage` first (instant render), then fetches `/api/state` in background
- All UI mutations are **optimistic**: update `state` + re-render immediately, then API call fires in background

This pattern is fast to build, easy to debug, and works perfectly in NativePHP's WebView.

### Auth without Laravel sessions

Use bearer tokens stored in `localStorage`. The `player_tokens` table maps tokens to players. A `TokenAuth` middleware reads `Authorization: Bearer {token}` and attaches the player to `$request->attributes`.

No cookies. No sessions. Works in NativePHP WebView, works cross-device on Railway.

### API routes in web.php

Put all API routes in `routes/web.php`, not `routes/api.php`. This gives you CSRF protection and avoids the `api` middleware group's session/auth conflicts with bearer tokens. Use middleware aliases registered in `bootstrap/app.php`.

### The `/api/state` master endpoint

One fat endpoint returns everything the frontend needs on startup. Pattern:

```json
{
  "player": { "id", "name", "isAdmin", ... },
  "season": { "id", "status", "jackpot", ... },
  "round":  { "id", "status", "fixtures": [...] },
  "leaderboard": [...],
  "history": [...]
}
```

Call it on login and after every admin action. Simpler than dozens of small endpoints.

### Cold-start retry in init()

NativePHP Android: the embedded PHP server may not be ready when WebView first loads.
Add a retry to `init()`:

```js
async function init() {
    const cached = localStorage.getItem('state');
    if (cached) renderAll(JSON.parse(cached));  // render immediately from cache

    try {
        const res = await fetch('/api/state', { headers: authHeaders() });
        if (!res.ok) throw new Error();
        const data = await res.json();
        setState(data);
    } catch {
        await new Promise(r => setTimeout(r, 800));  // wait 800ms, retry once
        const res = await fetch('/api/state', { headers: authHeaders() });
        const data = await res.json();
        setState(data);
    }
}
```

Without this, the app falls through to the login screen even when the user is already logged in.

---

## 5. Stack

```
Laravel 13 / PHP 8.4
NativePHP Mobile v3
Pest v4 (tests)
Tailwind CSS v4 (CSS-first config via @theme in app.css)
Vite 7
SQLite (local dev) / PostgreSQL (Railway production)
```

**Never change `DB_CONNECTION` locally.** Local = SQLite, production = PostgreSQL. Railway sets its own `DATABASE_URL`.

---

## 6. Railway Deployment

1. Push to GitHub
2. Create new Railway project → Deploy from GitHub repo → select `my-app/` as root
3. Add PostgreSQL service (Railway provides it)
4. Set env vars in Railway dashboard:
   - `APP_KEY` (copy from local `.env`)
   - `APP_URL` = your Railway domain (e.g. `https://myapp.up.railway.app`)
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - Any API keys
5. Railway auto-detects Laravel via Nixpacks — no Dockerfile needed
6. Run migrations: Railway console → `php artisan migrate --force`

**Railway watch:** set `DB_CONNECTION=pgsql` is handled automatically via `DATABASE_URL`. Do not hardcode it.

---

## 7. Play Store via TWA (Web + TWA path)

If distributing via Play Store, use PWABuilder to wrap your Railway URL. No NativePHP APK needed for this.

### PWA requirements (Railway app must have these)

| File | Purpose |
|---|---|
| `public/manifest.json` | PWA manifest — name, icons, theme color |
| `public/sw.js` | Service worker — required for TWA |
| `public/.well-known/assetlinks.json` | Links Railway domain to Play Store app |
| `public/icons/` | App icon 192px + 512px, screenshots |
| `resources/views/privacy.blade.php` | Privacy policy at `/privacy` — Play Store requires it |

### manifest.json minimum

```json
{
  "name": "App Name",
  "short_name": "AppName",
  "start_url": "/",
  "display": "standalone",
  "background_color": "#1a1a2e",
  "theme_color": "#1a1a2e",
  "icons": [
    { "src": "/icons/icon-192.png", "sizes": "192x192", "type": "image/png" },
    { "src": "/icons/icon-512.png", "sizes": "512x512", "type": "image/png" }
  ]
}
```

### sw.js minimum

```js
self.addEventListener('fetch', event => {
    event.respondWith(fetch(event.request));
});
```

### Build & publish flow

1. Go to PWABuilder, enter your Railway URL
2. Download Android package
3. Keep the generated `signing.keystore` forever — you need it for every future update
4. Upload `.aab` to Play Console → Internal Testing → promote to Production

**Keystore rule:** store `signing.keystore` and its password somewhere safe (not the repo). Losing it means you cannot update the app — you'd need a new Play Store listing.

---

## 8. NativePHP Android Build (Windows) — Full Gotcha List

If you're using NativePHP native (not TWA), apply every one of these from day one.

### sdk.dir resets on every native:install

```bash
echo "sdk.dir=C:/Users/pclogiklabs/AppData/Local/Android/Sdk" > nativephp/android/local.properties
export ANDROID_HOME="C:/Users/pclogiklabs/AppData/Local/Android/Sdk"
```

### Composer timeout is too short

In `vendor/nativephp/mobile/src/Traits/PreparesBuild.php` (~line 247), change `->timeout(300)` to `->timeout(900)`.
**This resets after every `composer update` — reapply each time.**

### PHP binaries may not download

If `nativephp/android/app/src/main/staticLibs/arm64-v8a/` is empty after `native:install`:

```bash
cp staticLibs/arm64-v8a/* nativephp/android/app/src/main/staticLibs/arm64-v8a/
```

### native:install does NOT replace placeholders

`REPLACE_COMPILE_SDK`, `REPLACEMECODE`, `REPLACE_APP_ID` etc. are only substituted by `native:run`.
Always run `native:run android` first — it will fail at Gradle, that's expected, but it configures the project.

### Full correct build sequence

```bash
export ANDROID_HOME="C:/Users/pclogiklabs/AppData/Local/Android/Sdk"

# 1. Run native:run — will fail at Gradle, that's fine
php artisan native:run android <device-udid> --build=debug

# 2. Fix sdk.dir (gets wiped every time)
echo "sdk.dir=C:/Users/pclogiklabs/AppData/Local/Android/Sdk" > nativephp/android/local.properties

# 3. Copy PHP binaries if missing
cp staticLibs/arm64-v8a/* nativephp/android/app/src/main/staticLibs/arm64-v8a/

# 4. Build APK
cd nativephp/android && ./gradlew.bat assembleDebug

# 5. Install on device
adb install -r nativephp/android/app/build/outputs/apk/debug/app-debug.apk
```

### Get device UDID

```bash
adb devices -l
# Pass it directly — IP-based serial can change session to session
php artisan native:run android 192.168.0.16:43663 --build=debug
```

### Wireless ADB (Xiaomi)

USB detection is unreliable on Xiaomi. Use wireless ADB:
1. Developer Options → Wireless Debugging → Pair device
2. `adb pair <IP:PORT>`
3. `adb connect <IP:PORT>`
4. Settings → Additional settings → Developer options → **Install via USB → ON** (silent fail without this)

---

## 9. Agent Team — Who to Call When

These are Claude Code subagent roles. Invoke via `Agent` tool (`subagent_type: "general-purpose"`).
Opus only for `product-advisor` and `code-reviewer`. Everything else = sonnet.

| Agent | Model | Job |
|---|---|---|
| `product-advisor` | **opus** | Shape feature into product brief before any code |
| `nativephp-architect` | sonnet | Schema, endpoints, state shape, file structure |
| `ux-ui-designer` | sonnet | Screen designs and UX flows — specs, not code |
| `nativephp-mobile` | sonnet | Full stack implementation |
| `test-writer` | sonnet | Pest v4 tests after each feature |
| `code-reviewer` | **opus** | Quality + security review — scoped to changed files only |
| `qa` | sonnet | Pre-release regression + layout sweep |
| `code-architect` | sonnet | Refactoring plan when a module grows too large |
| `playstore-publisher` | sonnet | Play Store submission and signing |

### Pipelines

| Task | Pipeline |
|---|---|
| Major feature | `product-advisor → nativephp-architect → ux-ui-designer → nativephp-mobile → test-writer → code-reviewer → commit` |
| Small feature | `nativephp-architect → nativephp-mobile → test-writer → code-reviewer → commit` |
| Bug fix | `nativephp-mobile → test-writer → code-reviewer → commit` |
| UI change | `ux-ui-designer → nativephp-mobile → code-reviewer → commit` |
| Refactor | `code-architect → nativephp-mobile → test-writer → code-reviewer → commit` |
| Pre-release | `qa → (fixes) → code-reviewer → commit` |

**Rules:**
- Never skip `product-advisor` for major features
- `code-reviewer` reads only changed files — tell it which files were modified
- `test-writer` runs after every feature, not at the end
- `qa` runs before every release, not after every feature

---

## 10. New Project Checklist

Work through this top to bottom when starting a new project.

### Day 1 — Scaffold

- [ ] `composer create-project nativephp/laravel-starter my-app`
- [ ] `composer run setup`
- [ ] Fix `.env`: `APP_URL`, `NATIVEPHP_APP_VERSION=1.0.0`
- [ ] Remove `URL::forceHttps()` from `AppServiceProvider`
- [ ] Uncomment PHP extensions in `C:\php\php.ini`, kill php.exe
- [ ] Replace composer.json scripts section (see §3c)
- [ ] `composer run dev` — verify app loads at localhost:8000

### Day 1 — Architecture decisions

- [ ] Distribution strategy: TWA / NativePHP native / web only
- [ ] Auth model: sessions (admin tool) vs bearer tokens (multi-device app)
- [ ] Database: SQLite-only or SQLite local + PostgreSQL prod
- [ ] External APIs: what keys are needed, add to `.env.example`

### Before first Railway deploy

- [ ] `public/manifest.json` with correct name and icons
- [ ] `public/sw.js` service worker
- [ ] `public/icons/` — icon-192.png, icon-512.png
- [ ] Privacy policy at `/privacy` (required for Play Store)
- [ ] Set all env vars in Railway dashboard
- [ ] Run `php artisan migrate --force` via Railway console

### Before Play Store submission

- [ ] `public/.well-known/assetlinks.json` with correct package name and SHA-256
- [ ] Screenshots (phone + tablet if possible)
- [ ] Featured graphic (1024×500)
- [ ] Store listing copy (description, short description)
- [ ] Privacy policy URL live and reachable
- [ ] Generate signing keystore — back it up immediately

---

## 11. File/Folder Structure to Create on Day 1

```
my-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/          ← all API controllers go here
│   │   └── Middleware/
│   │       ├── TokenAuth.php
│   │       └── AdminOnly.php
│   ├── Models/
│   └── Services/             ← business logic, not in controllers
├── resources/
│   └── views/
│       └── welcome.blade.php ← entire SPA frontend
├── routes/
│   └── web.php               ← ALL routes, including API routes
├── tests/
│   └── Feature/
└── public/
    ├── manifest.json
    ├── sw.js
    ├── .well-known/
    │   └── assetlinks.json
    └── icons/
```

Register middleware aliases in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'auth.token' => \App\Http\Middleware\TokenAuth::class,
        'admin.only' => \App\Http\Middleware\AdminOnly::class,
    ]);
})
```

---

## 12. Things That Will Bite You If Ignored

| Trap | Consequence | Fix |
|---|---|---|
| `APP_URL` left as starter kit default | Broken double-port URL crashes everything | Set `http://localhost:8000` immediately |
| `NATIVEPHP_APP_VERSION=DEBUG` | 97MB ZIP re-extracted on every cold start | Use `1.0.0` |
| `forceHttps()` left in | NativePHP crashes (embedded server is HTTP) | Remove it |
| Composer timeout at 300s | Build fails mid-download | Change to 900s |
| `sdk.dir` not reset after `native:install` | Gradle can't find Android SDK | Reset every time |
| `native:install` without `native:run` first | Placeholders not substituted → broken Gradle | Always run `native:run` first |
| PHP binaries not downloaded | Empty staticLibs → Gradle link error | Copy manually |
| Keystore lost | Cannot update Play Store app ever again | Back it up day one |
| `assetlinks.json` wrong SHA-256 | TWA falls back to browser (shows URL bar) | Get SHA from Play Console |
| Sessions instead of bearer tokens | Breaks in NativePHP WebView | Use bearer tokens + player_tokens table |
