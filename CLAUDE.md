# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

---

# AgroApp — Farmer Marketplace

Digital marketplace connecting farmers with customers across Republic of Srpska. Farmers list fresh products; customers browse and contact farmers directly via phone/WhatsApp/Viber. No in-app checkout — contact only.

**Distribution:** Web + Android TWA (Railway → PWABuilder → Play Store)  
**App root:** `my-app/` (all Laravel commands run from there)

---

## MVP Scope

**In scope:** Farmer directory, product catalog, search (name/category/city), guest reviews on farmer profiles, direct contact (phone/Viber/WhatsApp), admin moderation panel.

**Out of scope (Phase 2+):** Payments, order management, delivery logistics, farm cost tracking.

---

## Stack

```
Laravel 13 / PHP 8.4  (NativePHP Mobile binaries only support 8.4 — don't upgrade PHP)
NativePHP Mobile v3.2.3
SQLite (local dev) / PostgreSQL (Railway production)
Tailwind CSS v4 with @theme tokens in resources/css/app.css
Vite 8
Pest v4.6
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

# Build frontend assets
npm run build
```

---

## Architecture

### SPA Frontend

The entire frontend lives in one file: `resources/views/welcome.blade.php`. It is a vanilla-JS SPA with no framework. Key patterns:

- **`state` object** — single source of truth for auth, farmers list, selectedFarmer, selectedProduct, etc.
- **`showScreen(name)`** — switches active screen, manages bottom nav visibility, pushes screen history.
- **`api(method, url, body)`** — fetch wrapper; throws `{ status, message, errors }` on non-2xx.
- **Screen render functions** — `renderFarmerProfile(f)`, `renderProductDetail(p)` inject HTML strings into content divs. Dynamic content is always sanitised through `esc()`.
- **`showChatWithFarmer(farmerId)`** — contact bottom sheet (phone/Viber/WhatsApp); not a chat feature.

CSRF: read-only API routes are exempt (list in `bootstrap/app.php`). All mutating routes (`POST/PATCH/DELETE`) require the `X-CSRF-TOKEN` header, which `api()` sends automatically from the meta tag.

### Backend

**Models and relationships:**
- `User` → `hasOne FarmerProfile`, `hasMany Product`. Role: `farmer` or `customer`.
- `FarmerProfile` → `morphMany Photo`, `hasMany Review`, `hasMany Product` (via User).
- `Product` → `morphMany Photo`, `belongsTo User` (farmer).
- `Review` → `belongsTo FarmerProfile`. Guest-submitted (no user_id). Rate-limited 1 per farmer per IP per 24h.
- `Photo` — polymorphic: owned by FarmerProfile or Product.

**API shape convention:** Models expose `toApiArray()` (full detail) and `toCardArray()` (list view). Use these in controllers rather than inline array construction.

**Middleware:**
- `farmer` (`EnsureFarmer`) — user must be authenticated + role = farmer + onboarding complete.
- `admin` (`EnsureAdmin`) — user must be authenticated + role = admin.

**Enums:** `App\Enums\ProductCategory` and `App\Enums\City` — both have a static `all()` returning `[key => label]`. Add new categories/cities here, not in the frontend JS.

**Seeding:** `FarmerSeeder` creates test farmers with products; `AdminSeeder` creates the admin account.

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
| Customer Home | `screen-home` | Farmer cards row + product list, category/city chips |
| Search | `screen-search` | Full-text + category + fresh toggle |
| Farmer Profile | `screen-farmer-profile` | Dynamic via `renderFarmerProfile()`. 3 tabs: Proizvodi / Priča / Recenzije |
| Product Detail | `screen-product-detail` | Dynamic via `renderProductDetail()`. Story-first farmer card |
| Farmer Signup | `screen-farmer-signup` | 4-step onboarding flow |
| Login | `screen-login` | — |
| Farmer Dashboard | `screen-farmer-dashboard` | Own profile + product management |
| Product Edit | `screen-product-edit` | Create/edit product with image upload |
| Farmer Profile Edit | `screen-farmer-profile-edit` | Edit farm info + photos |
| Admin | `screen-admin` | Farmers / Products / Recenzije tabs |

### Reviews

Guest reviews: `POST /api/farmers/{id}/reviews` (no auth, rate-limited). Admin delete: `DELETE /api/admin/reviews/{id}` (admin middleware). The reviews tab in FarmerProfile lazy-loads on tab switch via `fpLoadReviews(farmerId)`.

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
| `app/Http/Middleware/` | EnsureFarmer, EnsureAdmin |
| `database/seeders/` | FarmerSeeder (test data), AdminSeeder |
| `tests/Feature/` | Pest tests: Auth, Farmer, Product, Search, State, Review |

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
