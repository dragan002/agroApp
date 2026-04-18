# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

---

# AgroApp — Farmer Marketplace (Prnjavor)

Digital marketplace connecting farmers with customers in Prnjavor, Republic of Srpska. Farmers list fresh products for sale; customers browse, discover farmers, and contact them directly via phone/WhatsApp/Viber.

**Distribution:** Web + Android TWA (Railway host → PWABuilder → Play Store)

---

## MVP Scope (Locked)

**What it is:**
- Farmer directory + product catalog
- Customer discovery (search by farmer name, product category, location)
- Direct contact (phone, WhatsApp, Viber — no in-app checkout)

**What it's NOT (Phase 2+):**
- No payment processing
- No order management
- No reviews/ratings
- No farm management tools (cost tracking, harvest planning)
- No delivery logistics

**Target:** Prnjavor-based MVP, all farmers welcome, both B2C and B2B customers

---

## Stack

```
Laravel 13 / PHP 8.4
NativePHP Mobile v3
SQLite (local dev) / PostgreSQL (Railway production)
Blade SPA (single welcome.blade.php, ~390px mobile viewport)
Tailwind CSS v4 (custom color tokens in @theme)
Vite 7
Pest v4
```

---

## Development Commands

```bash
# First-time setup
composer run setup

# Start dev server (artisan serve + queue:listen + pail + vite in parallel)
composer run dev

# Run all tests
composer run test

# Run single test file
php artisan test tests/Feature/FarmerTest.php

# Lint PHP code
./vendor/bin/pint

# Fresh database (wipe + migrate + seed)
php artisan migrate:fresh --seed

# Create migration
php artisan make:migration create_products_table

# Create model with migration
php artisan make:model Product -m
```

---

## Architecture Decisions

- **Auth model:** Role-based (User.role: 'farmer' or 'customer'). No login required for browsing; farmers register to list products.
- **Contact methods:** Phone + WhatsApp + Viber. Direct URL schemes (tel:, viber://, whatsapp://).
- **Images:** Farmers store up to 30 farm photos + 5 product images per product. Lazy-loaded on mobile.
- **Search:** By farmer name + product category (dropdown) + location (Prnjavor).
- **Distribution channel:** K3 TV show features farmers weekly; viewers download app and find featured farmer by name.
- **Locale:** Bosnian/Serbian (Latin script), sr-Latn. Currency: KM (Konvertibilna Marka).
- **External APIs:** None for MVP.

---

## Data Schema (Planned)

**User**
- id, email, password_hash, phone, viber, whatsapp, role ('farmer'|'customer')
- If farmer: name, location (address), avatar_photo_id, farm_photos (relation)
- created_at, updated_at

**Product**
- id, farmer_id (FK), category (dropdown enum), name, description, price, currency
- photos (max 5), availability_toggle ('fresh_today' or always available)
- created_at, updated_at

**Photo** (polymorphic)
- id, photoable_id, photoable_type, image_path, position
- Belongs to: Farmer (farm photos) or Product (product images)

**Frontend State (Blade SPA)**
- `auth.user` (null | {id, role, ...})
- `farmers` (list for directory view)
- `selectedFarmer` (for profile view)
- `selectedProduct` (for detail view)
- `searchQuery`, `selectedCategory`, `searchResults`

---

## Design System

**Color Palette** (add to `my-app/resources/css/app.css` @theme):
```css
--color-primary: #2D6A4F;        /* forest green */
--color-primary-light: #40916C;  /* active states */
--color-primary-subtle: #D8F3DC; /* backgrounds */
--color-accent: #E9C46A;         /* fresh badge, amber */
--color-accent-deep: #F4A261;    /* prices, burnt orange */
--color-surface: #FAFAF8;        /* screen background */
--color-surface-card: #FFFFFF;   /* cards */
--color-border: #E4E8E0;         /* borders */
--color-text-primary: #1A2E1A;   /* headings */
--color-text-secondary: #5A6B5A; /* secondary */
--color-text-muted: #9AA89A;     /* placeholders */
```

**Bottom Nav (Role-Based):**
- Customer: 3 tabs [Farmeri | Pretraga | Favoriti]
- Farmer: 4 tabs [Profil | Proizvodi | Novo | Statistike]

**Typography:** Instrument Sans (already loaded via Bunny Fonts)

**Spacing:** 8px base grid. Screen padding: 20px fixed. Safe-area padding on fixed bottom elements.

---

## Key Files

| File | Purpose |
|---|---|
| `my-app/routes/web.php` | All routes (auth, farmer CRUD, product CRUD, search, customer browse) |
| `my-app/app/Models/User.php` | User model with role, farmer/customer relationships |
| `my-app/app/Models/Product.php` | Product with category, photos, farmer FK |
| `my-app/resources/views/welcome.blade.php` | Entire SPA frontend (6 screens, state management) |
| `my-app/resources/css/app.css` | Tailwind config + custom @theme colors |
| `my-app/database/migrations/` | Schema: users, products, photos, farmer_profiles |
| `my-app/tests/Feature/` | Pest tests for farmer signup, product creation, search |

---

## Agent Team Workflow

**Core pipeline (new feature):**
product-advisor → nativephp-architect → ux-ui-designer → nativephp-mobile → test-writer → code-reviewer → commit

**Shortcuts:**
- Bug fix: nativephp-mobile → test-writer → code-reviewer → commit
- UI tweak: nativephp-mobile → code-reviewer → commit

**Rules:**
- product-advisor locks scope before any code
- nativephp-architect designs schema, API, state shape
- ux-ui-designer provides wireframes + component specs
- nativephp-mobile builds SPA + API backend
- test-writer adds Pest tests for features
- code-reviewer reviews before commit
- You approve each handoff

---

## Screens (6 Total, Designed)

1. **Customer Home** — Search bar, category chips, farmer cards, product list
2. **Farmer Profile** — Hero gallery (farm photos), contact buttons, products, stats
3. **Product Detail** — Image gallery, price, description, farmer info, contact
4. **Farmer Signup** — 4-step flow (basic info → contact → farm photos → confirm)
5. **Product Edit** — Name, category, price, description, up to 5 images, fresh toggle
6. **Farmer Own Profile** — Profile header, stats, farm photo strip, product management (inline fresh toggle)

All wireframes documented with ASCII layouts in design notes.

---

## Permissions & Autonomy

Claude Code has full autonomy to:
- Run Bash commands (git, php, npm)
- Edit/write files without prompting
- Call subagents (architect, designer, mobile, test-writer, reviewer)

Destructive operations (force push, hard reset, rm -rf) still pause for safety.

---

## Locale & Terminology

- **Bosnian/Serbian:** sr-Latn (Latin script)
- **Currency:** KM (1 product unit = 1 price in KM)
- **Key terms:** Farma (farm), Proizvod (product), Sveže (fresh), Kontakt (contact), Porudžbina (order/inquiry)
- **UI labels:** Farmeri (farmers), Pretraga (search), Proizvodi (products), Profil (profile)

---

## Next Steps

1. Architect designs database schema + API (nativephp-architect agent)
2. Mobile develops all 6 screens + routes (nativephp-mobile agent)
3. Test-writer adds Pest tests
4. Code-reviewer final check
5. Deploy to Railway + wrap with PWABuilder for Play Store
