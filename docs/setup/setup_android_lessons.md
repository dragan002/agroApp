---
name: Android NativePHP Setup Lessons
description: All setup pain points and fixes for NativePHP Android on Windows — apply to every new project from day one
type: reference
---

# Android NativePHP Setup Lessons (Windows)

These are hard-learned fixes accumulated from previous projects. Apply all of them immediately when starting a new project — do NOT discover them again the slow way.

---

## 1. First-Time Project Setup

```bash
composer run setup    # installs deps, creates .env, migrates, builds assets
```

Then immediately fix these two things in `.env`:

```
APP_URL=http://localhost:8000   # starter kit generates broken double-port URL
NATIVEPHP_APP_VERSION=1.0.0    # NEVER use "DEBUG" — causes 97MB ZIP re-extract on every cold start
```

---

## 2. Remove forceHttps Immediately

In `app/Providers/AppServiceProvider.php`, remove any `URL::forceHttps()` call from `boot()`.
**Why:** It crashes NativePHP — the embedded server is HTTP only.

---

## 3. Enable PHP Extensions (php.ini)

File: `C:\php\php.ini` — uncomment these:
```ini
extension=curl
extension=gd
extension=pdo_sqlite
extension=sqlite3
```
Kill all `php.exe` processes after editing.

---

## 4. Android Build: `sdk.dir` Resets Every Time

Every `native:install` wipes `nativephp/android/local.properties`. Always re-set after install:

```bash
echo "sdk.dir=C:/Users/pclogiklabs/AppData/Local/Android/Sdk" > nativephp/android/local.properties
```

Set env var in session to reduce friction:
```bash
export ANDROID_HOME="C:/Users/pclogiklabs/AppData/Local/Android/Sdk"
```

---

## 5. Composer Timeout During Build

`vendor/nativephp/mobile/src/Traits/PreparesBuild.php` line ~247 has a 300s timeout — too short.
Change to `->timeout(900)`. **Resets after `composer update`** — reapply each time.

---

## 6. PHP Binaries Missing (`libphp.a`)

`native:install` downloads PHP binaries from `bin.nativephp.com` but fails silently.
If `nativephp/android/app/src/main/staticLibs/arm64-v8a/` is empty, copy manually:

```bash
cp staticLibs/arm64-v8a/* nativephp/android/app/src/main/staticLibs/arm64-v8a/
```

Note: `cpp/staticLibs/` path is wrong — CMakeLists.txt looks for `cpp/../staticLibs/` = `main/staticLibs/`.

---

## 7. `native:install` Does NOT Replace Placeholders

`REPLACE_COMPILE_SDK`, `REPLACEMECODE`, `REPLACE_APP_ID` etc. are only substituted by `native:run`.
Always run `native:run android` first (even knowing it will fail at Gradle) to get a configured project.

---

## 8. Full Correct Build Sequence

```bash
export ANDROID_HOME="C:/Users/pclogiklabs/AppData/Local/Android/Sdk"

# Step 1: run native:run with device UDID — will fail at Gradle, that's expected
php artisan native:run android <device-udid> --build=debug

# Step 2: fix sdk.dir (gets wiped)
echo "sdk.dir=C:/Users/pclogiklabs/AppData/Local/Android/Sdk" > nativephp/android/local.properties

# Step 3: copy PHP binaries if missing
cp staticLibs/arm64-v8a/* nativephp/android/app/src/main/staticLibs/arm64-v8a/

# Step 4: build APK
cd nativephp/android && ./gradlew.bat assembleDebug

# Step 5: install on device
adb install -r nativephp/android/app/build/outputs/apk/debug/app-debug.apk
```

---

## 9. Get Device UDID Before Building

```bash
adb devices -l
```

Pass it directly to skip interactive prompt:
```bash
php artisan native:run android 192.168.0.16:43663 --build=debug
```

IP-based serial can change — always run `adb devices` before each build.

---

## 10. Wireless ADB (Xiaomi / Unreliable USB)

USB detection is unreliable on Xiaomi. Use wireless:
1. Developer Options → Wireless Debugging → Pair device
2. `adb pair <IP:PORT>`
3. `adb connect <IP:PORT>`

Also: Settings → Additional settings → Developer options → **Install via USB → ON**
Without this, `adb install` fails silently on MIUI.

---

## 11. Cold-Start Retry in init()

On NativePHP Android, the embedded PHP server may not be ready when WebView first renders.
Add a retry to `init()` — fetch `/api/state` once, if it fails wait 800ms and retry.
Without this, the app falls through to onboarding even when user data exists in DB.

---

## 12. Running the App in Browser (Development)

```bash
cd my-app
composer run dev
```

Opens on `http://localhost:8000`. Use this for all development — no need to build APK for every change.
Only build APK when testing device-specific behavior.
