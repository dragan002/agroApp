6 AI agents. 1 Dockerfile. 0 lines of Android code.

No dev team. No agency.

A full-stack farmer marketplace — live on Google Play.

Here's the exact workflow.


The app is SeljakRS. A farmer marketplace for Republic of Srpska. Farmers list fresh products. Customers call or WhatsApp them directly. No payments. No checkout. Just real food, real people.

I built it with Claude Code and a team of specialized AI agents.

Here's how:

STEP 1 — Write your CLAUDE.md first.

This is the workflow file. The single source of truth for every agent.

Stack, conventions, architecture decisions, design system, naming rules, locale. Everything lives here.

Each agent starts cold — it has no memory of the previous session. CLAUDE.md is what keeps 10 different agents producing one coherent codebase.

STEP 2 — Assign agents with specific roles.

Each agent does exactly one thing:

product-advisor — "should we build this?" before anyone touches code
nativephp-architect — DB schema, API shape, file structure. Never writes code.
ux-ui-designer — screens, spacing, colors, flows. Also never writes code.
ui-implementer — turns those designs into exact HTML/CSS
nativephp-mobile — implements features. Laravel backend + vanilla JS frontend.
test-writer — Pest tests for every feature
code-reviewer — security, performance, edge cases. Last gate before commit.
qa — full QA sweep before any release
playstore-publisher — Play Store upload, store listing, compliance

STEP 3 — Pick the right pipeline for the task.

New screen or DB model:
architect → mobile → test-writer → reviewer → commit

UI/visual work:
designer → implementer → reviewer → commit

Play Store release:
qa → publisher

Each agent starts cold. You brief them. They execute. Then you hand the output to the next one.

STEP 4 — Deploy with one Dockerfile.

Railway + FrankenPHP + Caddy. No DevOps team.

One gotcha that cost me 45 minutes: Laravel reads DB_URL, not DATABASE_URL. Railway uses DATABASE_URL. Same database. Different name. Total silence on why it fails.

Photos go to Cloudflare R2. S3-compatible, cheaper than S3.

STEP 5 — Add tracking in 20 minutes.

Google Analytics 4 + Microsoft Clarity. Two script tags. Done.

Session recordings, heatmaps, funnel analysis. Zero backend work.

STEP 6 — Ship to Android with zero native code.

PWABuilder converts your web app to a TWA (Trusted Web Activity). One upload to Google Play Console.

Zero lines of Android code written.


App is live. 12 testers in Google Play closed testing right now.

What part of this would you want me to go deeper on?

#AIAgents #BuildInPublic

---
FIRST COMMENT:
Full agent definitions + CLAUDE.md:
https://github.com/dragan002/agroApp
