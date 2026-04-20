# AgroApp MVP Strategy: TV Distribution Model

**Status:** Product strategy phase (pre-architecture, pre-code)  
**Decision Date:** 2026-04-18  
**Context:** K3 TV weekly farmer features create organic, high-intent user acquisition channel

---

## The Opportunity

**Your actual distribution channel is not app stores—it's K3 TV.**

K3 makes weekly farmer feature videos. Each featured farmer has a **peak interest moment**: viewers see them on TV and want to connect. This creates a unique product dynamic:

- **Time window:** ~10 seconds after airing (peak action moment)
- **Intent:** Viewers want to find this specific farmer (search-driven)
- **Trust:** They just saw the farmer on TV (credibility is pre-established)
- **Call to action:** Natural—TV show tells viewers to download the app and find the farmer

This is **not** a typical app growth problem. This is **peak-moment onboarding**.

---

## MVP Scope: TV-Optimized

### What the MVP Needs (Minimum Viable)

**For TV viewers:**
- Search farmer by name
- View farmer profile (photo, crops, products, contact)
- Call or message farmer directly
- See which products they sell (simple list)

**For featured farmers:**
- Quick profile setup (name, photo, crops, phone)
- Ability to list products/availability
- View who contacted them
- Simple availability toggle ("selling this week")

**For buyers (B2B + direct-to-consumer):**
- Browse or search farmers
- See what they're selling
- Contact them (phone, message, or direct order inquiry)

### What the MVP Does NOT Need

- Parcel management (agro-admin tool)
- Subsidy tracking
- Complex crop planning
- Weather integration
- Livestock records
- Financial dashboards

**Those are Phase 2+** (once you have proven demand through TV validation).

---

## Critical Decisions

### 1. Launch Sequencing

**Option A: App First (Recommended)**
- Launch app with empty/minimal farmer directory (1-2 seed farmers)
- Start TV features immediately
- Each week: new farmer on TV → they onboard via app → appear in directory
- Pro: Validate each step; easy to pivot
- Con: First few weeks, directory is sparse (but TV amplifies this)

**Option B: Pre-populate Before Launch**
- Get 5-10 farmers onboarded before launch
- Launch app + announce TV partnership simultaneously
- Pro: Directory feels mature on day 1
- Con: More upfront coordination; harder to adjust if feedback suggests changes

**Recommendation:** **Option A** — your TV distribution IS your customer acquisition. Use it iteratively. Each week's featured farmer validates the product.

### 2. The Critical Metric

**What proves this works?**

Not: App downloads  
Not: Farmer signups  

**Yes: Inbound contact attempts to featured farmers**

- TV viewer sees Farmer X on Monday  
- By Wednesday, Farmer X gets 3-5 messages/calls through the app  
- Farmer X lists products and sees buyers interested  
- Farmer X wants to stay in the app because buyers are coming

This is your proof of product-market fit for the TV model.

**Track:**
- Downloads (lagging indicator)
- New farmer signups (leading indicator)
- **Messages/calls from viewers to farmers within 3 days of air date (validation indicator)** ← THIS IS THE ONE THAT MATTERS

### 3. Farmer Onboarding Must Be Instant

When K3 tells a farmer "You're on next week, go download the app and set up your profile," they need to do it in <2 minutes.

**Onboarding flow (target: 90 seconds):**
1. Download app (30 sec)
2. Sign up with phone (20 sec — SMS verification)
3. Add name + photo (30 sec)
4. Add 2-3 crops (20 sec — dropdown list, not free text)
5. Add phone + optional Viber/WhatsApp (10 sec)
6. Done — profile is live

No email. No complex registration. Phone = identity (local market standard).

---

## Schema Skeleton (for nativephp-architect)

**Farmer Profile**
- `id`, `phone` (unique), `name`, `avatar_url`, `created_at`
- `crops` (JSON array: `[{name, quantity_unit, notes}]`)
- `is_active` (toggle: "selling this week")
- `contact_methods` (phone, viber, whatsapp, custom_message)

**Product Listing**
- `id`, `farmer_id`, `name`, `quantity`, `unit`, `price` (optional), `available_from`, `notes`

**Contact Request** (from viewers)
- `id`, `from_user_id`, `to_farmer_id`, `message`, `contact_method`, `created_at`, `is_viewed`
- Track: when did the viewer contact; did farmer respond?

**User (Viewer/Buyer)**
- `id`, `phone` (optional), `name` (optional), `created_at`
- Anonymous viewing is fine; login only for messaging

---

## Success Indicators (Week 1-4)

| Metric | Target | Why |
|--------|--------|-----|
| Farmers with complete profiles | 4-8 (cumulative over 4 weeks) | Validation that onboarding works |
| Messages/calls to featured farmer within 3 days | 3-10 per farmer | Proof viewers use the app after seeing TV |
| Return viewers (week 2+) | >50% week-over-week | Stickiness; people come back to find more farmers |
| Average profile setup time | <3 min | Goal: frictionless |
| App store rating (iOS + Android) | 4.5+ | Word of mouth (local farmers tell friends) |

---

## What This Means for Code

**MVP = Farmer directory + search + contact system.**

Not a full agro-management platform. That comes after you prove the TV model works.

**Tech priorities:**
- Photo upload (critical — farmers want to look good on their profile)
- Search by name + crop (essential)
- Simple messaging/contact tracking
- Mobile-first (farmers will onboard on phones)
- Offline-friendly (rural connectivity can be spotty)

**Can skip for MVP:**
- Complex auth roles
- Dashboard analytics
- Admin panels
- API integrations

---

## Next: Product Architect Session

Before `my-app` is scaffolded, run a product-advisor review to finalize:

1. **Onboarding flow** — exactly what fields, in what order
2. **Profile presentation** — what makes a farmer profile compelling to a viewer?
3. **Search** — by name? crop type? location?
4. **Contact method** — phone call, WhatsApp, in-app message, or all three?
5. **Validation timeline** — when does K3 air their first farmer feature?

Then → **nativephp-architect** designs the schema and API.  
Then → **ux-ui-designer** designs the farmer profile and search screens.  
Then → **nativephp-mobile** builds.

---

## Why This Works

You have something **99% of apps don't have: a credible, recurring distribution channel.**

The TV show validates farmers for you. Viewers trust farmers they see on K3. This flips the normal app problem (cold start, user acquisition, trust) on its head.

Your job isn't to convince farmers to use the app. Your job is to make the app **so frictionless** that when K3 tells them to use it, they do it immediately.

That's MVP discipline: farmer sees themselves on TV → downloads app → finds profile → starts getting buyer inquiries within hours. Everything else is Phase 2.
