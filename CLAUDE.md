# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

---

# SeljakRS — Farmer Marketplace

Digital marketplace connecting farmers with customers across Republic of Srpska. Brand name in the UI is **SeljakRS** (top-bar logo); the repo folder is `agroApp`. Farmers list fresh products; customers browse and contact farmers directly via phone/WhatsApp/Viber. No in-app checkout — contact only.

**Distribution:** Web + Android TWA (Railway → PWABuilder → Play Store)  
**App root:** `my-app/` (all Laravel commands run from there)

---

## MVP Scope

**In scope:** Farmer directory, product catalog, search (name/category/city), guest reviews on farmer profiles, direct contact (phone/Viber/WhatsApp), admin moderation panel.

**Out of scope (Phase 2+):** Payments, order management, delivery logistics, farm cost tracking.

---

## Stack

```
Laravel 13 / PHP 8.4  (don't upgrade PHP)
SQLite (local dev) / PostgreSQL (Railway production)
Tailwind CSS v4 with @theme tokens in resources/css/app.css
Vite 8
Pest v4.6
FrankenPHP (dunglas/frankenphp) as production server via Caddy
```

---

## Development Commands

All commands run from `my-app/`:

```bash
# First-time setup
composer run setup

# Dev server — artisan + queue + pail + vite in parallel
composer run dev

# Run all tests
composer run test

# Run single test file
php artisan test tests/Feature/ReviewTest.php

# Lint PHP
./vendor/bin/pint

# Fresh DB with seed data
php artisan migrate:fresh --seed

# Seed demo farmers only (production-realistic data)
php artisan db:seed --class=DemoSeeder

# Seed admin account only
php artisan db:seed --class=AdminSeeder

# Build frontend assets
npm run build
```

---

## Production Deployment (Railway)

Deployed via **Dockerfile** builder (not Railpack/Nixpacks). The `Dockerfile` and `Caddyfile` are in `my-app/`.

**Required Railway env vars:**
```
APP_KEY=base64:...
APP_ENV=production
APP_DEBUG=false
APP_URL=https://<your-railway-domain>
SESSION_DRIVER=database
DB_CONNECTION=pgsql
DB_URL=postgresql://...         # use DATABASE_PUBLIC_URL from Railway Postgres plugin (not internal URL)
FILESYSTEM_DISK=s3              # for Cloudflare R2 photo storage
AWS_ACCESS_KEY_ID=...
AWS_SECRET_ACCESS_KEY=...
AWS_DEFAULT_REGION=auto
AWS_BUCKET=...
AWS_ENDPOINT=https://<accountid>.r2.cloudflarestorage.com
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_URL=https://pub-<hash>.r2.dev  # R2 public bucket URL — used by Storage::url() to generate public photo URLs
```

**Important:** Laravel reads `DB_URL`, not `DATABASE_URL`. Railway's internal hostname (`postgres.railway.internal`) can fail DNS resolution — use the public proxy URL instead.

**Railway target port:** Set to `8080` in Railway Networking settings. Caddyfile listens on `$PORT` which Railway sets to match.

**Start command** (set as Custom Start Command in Railway Settings):
```
sh -c "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan storage:link --force && frankenphp run --config /Caddyfile"
```

**Build-time vs runtime:** Artisan cache commands (`config:cache`, `route:cache`, `view:cache`) run at **container startup** (in `CMD`), not during Docker build — so they pick up real env vars. Only `mkdir`/`chmod` for storage dirs happen at build time.

**HTTPS proxy:** `AppServiceProvider::boot()` calls `URL::forceScheme('https')` in production because Railway terminates SSL at its load balancer (app sees HTTP internally without this).

**Seeding on Railway:** The seeders download images from `loremflickr.com` — this takes 5–8 minutes for a full seed. Running `migrate:fresh --seed` synchronously blocks FrankenPHP from starting and causes Railway's health check to fail. The correct approach is to run the seeder **in the background** so FrankenPHP starts immediately:

```
sh -c "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate:fresh --force && php artisan storage:link --force && (php artisan db:seed --force > /tmp/seed.log 2>&1 &) && frankenphp run --config /Caddyfile"
```

App is live in ~5 seconds; demo data populates over the next 5–8 minutes. **After confirming data is present, immediately revert to the normal start command** (with `migrate --force`, not `migrate:fresh`) to prevent the database being wiped on the next deploy.

---

## Architecture

### SPA Frontend

The entire frontend lives in one file: `resources/views/welcome.blade.php`. It is a vanilla-JS SPA with no framework. Key patterns:

- **`state` object** — single source of truth for auth, farmers list, selectedFarmer, selectedProduct, homeCity, searchCity, etc.
- **`showScreen(name)`** — switches active screen, manages bottom nav visibility, pushes screen history, and removes any open contact-sheet overlay.
- **`api(method, url, body)`** — fetch wrapper; reads CSRF token dynamically from `<meta name="csrf-token">` on every call; throws `{ status, message, errors }` on non-2xx.
- **Screen render functions** — `renderFarmerProfile(f)`, `renderProductDetail(p)` inject HTML strings into content divs. Dynamic content is always sanitised through `esc()`.
- **`showChatWithFarmer(farmerId)`** — contact bottom sheet (phone/Viber/WhatsApp); not a chat feature.

**CSRF token rotation:** `Auth::login()` and `session()->regenerate()` rotate the CSRF token. After any auth action (register, login, logout), the server returns `csrf_token` in the JSON response and the SPA calls `updateCsrf(token)` to patch the meta tag before the next request.

### Backend

**Models and relationships:**
- `User` → `hasOne FarmerProfile`, `hasMany Product`. Role: `farmer` or `customer`.
- `FarmerProfile` → `morphMany Photo`, `hasMany Review`, `hasMany Product` (via User).
- `Product` → `morphMany Photo`, `belongsTo User` (farmer). Has `fresh_until` (nullable datetime) — products with `fresh_until > now()` are "fresh today".
- `Review` → `belongsTo FarmerProfile`. Guest-submitted (no user_id). Rate-limited 1 per farmer per IP per 24h. IP stored as `sha256` hash (rate limit key also uses `sha256`).
- `Photo` — polymorphic: owned by FarmerProfile or Product. `toApiArray()` returns only `id`, `url`, `position` — the raw `path` is never exposed to the client.

**API shape convention:** Models expose `toApiArray()` (full detail) and `toCardArray()` (list view). Both now include `reviewCount` and `avgRating` (eager-loaded via `withCount('reviews')->withAvg('reviews', 'rating')`). Use these methods in controllers rather than inline array construction.

**Middleware:**
- `farmer` (`EnsureFarmer`) — user must be authenticated + role = farmer + **onboarding complete** (`onboarding_step === null`).
- `farmer.onboarding` (`EnsureFarmerOnboarding`) — user must be authenticated + role = farmer; **does not require onboarding to be complete, but blocks users where onboarding is already done** (`onboarding_step === null`). Applied only to the four onboarding step routes.
- `admin` (`EnsureAdmin`) — user must be authenticated + role = admin.

**Rate limiting:** `POST /api/auth/register` → `throttle:5,1`; `POST /api/auth/login` → `throttle:10,1`; `GET /api/search` → `throttle:60,1`.

**Enums:** `App\Enums\ProductCategory` and `App\Enums\City` — both have a static `all()` returning `[key => label]`. Add new categories/cities here, not in the frontend JS. City labels in JS come from `state.cities` (populated from `/api/state`).

**Seeders:**
- `DemoSeeder` — 14 farmers across 9 cities (Banja Luka, Bijeljina, Brčko, Derventa, Doboj, Gradiška, Kotor Varoš, Prijedor, Trebinje); use for production/demo.
- `FarmerSeeder` — 3 Prnjavor farmers; runs before DemoSeeder (both called from `DatabaseSeeder`). Together: **17 farmers, 10 cities, ~80 products**.
- `AdminSeeder` — creates the admin account.

Both seeders download profile photos and product photos from `loremflickr.com` at seed time using `Http::get()`. Photos are stored in `Storage::disk()` (`FILESYSTEM_DISK` drives local vs R2). If the network is unavailable, photos are silently skipped and the emoji fallback is shown in the UI.

### Security Patterns

**XSS in inline JS:** `esc()` HTML-encodes entities, but HTML entities inside `onclick="..."` string literals are decoded by the browser before JS executes — so `esc()` alone does not protect inline JS attribute strings. Rules:
- **Never interpolate user strings into `onclick` attributes.** Pass only numeric IDs (e.g., `onclick="fn(${f.id})"`) and look up names/labels from `state` inside the function.
- **Phone/Viber/WhatsApp contact links use `<a href="tel:...">` / `<a href="viber://...">` — never `onclick="window.location=..."`.**
- Phone numbers are validated server-side to `regex:/^[+\d\s\-().]+$/` in `OnboardingController::step2`.

**Photo storage:** Always use `Storage::disk()` with no argument. Never use `Storage::disk('public')` — that hardcodes the local disk and breaks production (R2).

### Design System

**Earth palette** — all tokens live in `resources/css/app.css` `@theme` block and are mirrored as CSS custom properties in the inline `<style>` fallback inside `welcome.blade.php` (for when Vite build isn't available):

```
Primary (olive):   #3d5a3a
Accent (terra):    #c06643
Gold:              #b8902a
Bg (cream):        #faf6ef
Surface (white):   #ffffff
Surface alt:       #f2ece0
Ink (near-black):  #2a2218
Border:            #e4ddd0
Divider:           #ece5d6
Text muted:        #a89a85
```

**Typography:** Fraunces (serif, display/headings) + Inter (sans, UI) + JetBrains Mono (prices/chips). Loaded from Google Fonts. Use `var(--font-serif)` / `var(--font-sans)` in inline styles.

**Screen layout:** `#app` is `max-width:480px`, centered. Each `.screen` is `position:absolute; bottom:64px` (or `bottom:0` for fullscreen screens like admin/login). Bottom nav is 64px fixed.

### Screens (implemented)

| Screen | HTML id | Notes |
|---|---|---|
| Customer Home | `screen-home` | Farmer cards row + product list, category/city chips, farmer CTA banner |
| Search | `screen-search` | Full-text + category + city + fresh toggle |
| Farmer Profile | `screen-farmer-profile` | Dynamic via `renderFarmerProfile()`. 3 tabs: Proizvodi / Priča / Recenzije |
| Product Detail | `screen-product-detail` | Dynamic via `renderProductDetail()`. Story-first farmer card |
| Farmer Signup | `screen-farmer-signup` | 4-step onboarding flow |
| Login | `screen-login` | — |
| Farmer Dashboard | `screen-farmer-dashboard` | Own profile + product management |
| Product Edit | `screen-product-edit` | Create/edit product with image upload |
| Farmer Profile Edit | `screen-farmer-profile-edit` | Edit farm info + photos |
| Admin | `screen-admin` | Farmers / Products / Recenzije tabs |

### Onboarding State Machine

`User.onboarding_step` drives the 4-step signup flow:

| Value | Meaning | What was saved |
|---|---|---|
| `1` | Just registered | name, email only |
| `2` | Contacts saved | phone, viber, whatsapp |
| `3` | Farm info saved | FarmerProfile created (is_active=false) |
| `4` | Photos uploaded | farm photos attached |
| `null` | Complete | `is_active=true`, farmer is live |

`EnsureFarmer` middleware blocks requests when `onboarding_step !== null`. `EnsureFarmerOnboarding` middleware allows requests only when `onboarding_step !== null` (i.e., onboarding is still in progress). The SPA checks `state.auth.onboardingStep` on every login to resume at the correct step.

### SPA Bootstrap

`GET /api/state` is the first call the SPA makes on load. Returns `{ auth, farmers (limit 20), categories, cities }` in one round-trip. All category and city labels in the UI come from this response — never hardcoded in JS.

### Deep Links

`GET /farmer/{id}` renders `welcome.blade.php` with `$openFarmerId` injected. The JS reads `window.openFarmerId` (set in a Blade `<script>` block) and immediately opens that farmer's profile. Used for sharing links.

### Photo Storage

Photos stored via `Storage::disk()` (no argument — disk is driven by `FILESYSTEM_DISK` env var) at path `farmers/{userId}/{filename}`. `Photo::toApiArray()` returns a full URL via `Storage::url()` but **never exposes the raw path**. Production uses Cloudflare R2 — `league/flysystem-aws-s3-v3` is installed. `AWS_URL` must be set to the R2 public bucket URL (`pub-xxx.r2.dev`) so `Storage::url()` generates correct public URLs rather than the S3 API endpoint.

**Product image fallback:** All product image tags use a "layered" pattern — the category emoji sits in the background div and the `<img>` overlays it absolutely. `onerror="this.style.display='none'"` reveals the emoji when the image fails to load. This is implemented in `productCardHtml()`, `productGridCard()`, `renderProductDetail()`, `myProductRowHtml()`, and the admin panel product list. Apply the same pattern for any new product image context.

### Analytics

Two tracking scripts are loaded in the `<head>` of `welcome.blade.php`, before the Google Fonts `<link>`:

- **Google Analytics 4** — measurement ID `G-NTTVHSWED5`
- **Microsoft Clarity** — project ID `wgll2gxmr3` (session recordings + heatmaps)

Both load asynchronously and do not block rendering. The privacy policy at `/privacy` discloses data collection as required by the Play Store.

### Reviews

Guest reviews: `POST /api/farmers/{id}/reviews` (no auth, rate-limited 1/IP/farmer/24h via `RateLimiter`). IP is stored as `sha256` hash, never raw. The rate limiter key also uses `sha256` — keep these consistent. Admin delete: `DELETE /api/admin/reviews/{id}` (admin middleware). The reviews tab lazy-loads on first tab switch via `fpLoadReviews(farmerId)` and is cached per profile open (`_fpReviewsLoaded` flag) — it does not re-fetch on subsequent tab switches.

---

## Key Files

| File | Purpose |
|---|---|
| `routes/web.php` | All routes — public API, auth, farmer CRUD, admin |
| `resources/views/welcome.blade.php` | Entire SPA (screens, state, render functions) |
| `resources/css/app.css` | Tailwind v4 @theme tokens (earth palette) |
| `app/Models/` | User, FarmerProfile, Product, Photo, Review |
| `app/Enums/` | ProductCategory, City — canonical label maps |
| `app/Http/Controllers/Api/` | One controller per domain area |
| `app/Http/Middleware/` | EnsureFarmer, EnsureFarmerOnboarding, EnsureAdmin |
| `app/Providers/AppServiceProvider.php` | Forces HTTPS scheme in production |
| `database/seeders/` | DemoSeeder (production), FarmerSeeder (dev), AdminSeeder |
| `tests/Feature/` | Pest tests: Auth, Farmer, Product, Search, State |
| `Dockerfile` | Production build — FrankenPHP on PHP 8.4 bookworm |
| `Caddyfile` | FrankenPHP server config — listens on `$PORT` (Railway sets this to target port, configured as 8080) |
| `public/manifest.json` | PWA manifest — name, icons, theme colour |
| `public/.well-known/assetlinks.json` | Play Store TWA domain verification |
| `resources/views/privacy.blade.php` | Privacy policy at `/privacy` (required by Play Store) |
| `resources/views/delete-account.blade.php` | Account deletion instructions at `/delete-account` (required by Play Store) |

---

## Test Conventions

Tests use `RefreshDatabase` — no persistent state between tests. **No factories** — create models directly with `User::create([...])`. Test structure uses Pest `describe()` blocks with `beforeEach()` for shared setup.

```php
uses(RefreshDatabase::class);

describe('feature name', function () {
    beforeEach(function () {
        $this->user = User::create([...]);
    });

    it('does the thing', function () {
        $this->actingAs($this->user)->postJson('/api/...', [...])
            ->assertStatus(200);
    });
});
```

Mutating API routes require `X-CSRF-TOKEN` in real browser calls, but test HTTP client bypasses CSRF automatically.

---

## Agent Team Workflow

Pick the shortest pipeline that fits the task. Each agent starts cold — pass explicit context when handing off between agents.

### Pipelines

```
# New screen or new domain model (new DB table, new API shape)
nativephp-architect → nativephp-mobile → test-writer → code-reviewer → commit

# New feature on existing models/routes
nativephp-mobile → test-writer → code-reviewer → commit

# UI / visual work (layout, spacing, color, component design)
ux-ui-designer → ui-implementer → code-reviewer → commit

# Bug fix
nativephp-mobile → test-writer → commit

# Quick UI tweak (one element, obvious change)
nativephp-mobile → commit

# Play Store prep / release
qa → playstore-publisher
```

### When to use supporting agents

- **product-advisor** — only when genuinely uncertain whether/how to build something conceptually ("should reviews have photos?"). Not for implementation work.
- **nativephp-architect** — only for new domain models or new API shapes. Skip if models/routes already exist.
- **Explore** — use before any agent touches `welcome.blade.php` or other large files; orientation before editing.
- **qa** — before Play Store submissions or after large feature additions.

### Context handoff rule

When chaining agents, pass the previous agent's key decisions explicitly in the next agent prompt. Don't assume the next agent will re-derive them — each starts from zero.

Claude Code has full autonomy to run Bash, edit files, and spawn subagents. Destructive operations (force push, hard reset, `rm -rf`) still pause for confirmation.

---

## Locale

- Language: Bosnian/Serbian, Latin script (`sr-Latn`), `lang="sr-Latn"` on `<html>`
- Currency: KM (Konvertibilna Marka), formatted as `18,00 KM` (comma decimal)
- UI copy: Serbian throughout. `formatPrice(price, unit)` in JS handles formatting.
- Key UI terms: Farmeri, Pretraga, Proizvodi, Profil, Poruka, Recenzije, Svježe
