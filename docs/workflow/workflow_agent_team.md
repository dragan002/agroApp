---
name: Agent Team Workflow
description: Reusable multi-agent team structure for building NativePHP Android apps
type: reference
---

# Agent Team Workflow

---

## The Team

| Role | Agent | Model | Responsibility |
|---|---|---|---|
| Product Manager | `product-advisor` | opus | Requirements, scope, feature decisions, risk flags |
| Architect | `nativephp-architect` | sonnet | Schema, API design, state shape, file structure — NativePHP-aware |
| Designer | `ux-ui-designer` | sonnet | Screens, flows, UX decisions — produces design specs, not code |
| Developer | `nativephp-mobile` | sonnet | Full stack implementation (PHP, Blade, JS, migrations) |
| Test Writer | `test-writer` | sonnet | Pest v4 tests after every feature during development |
| Tech Lead | `code-reviewer` | opus | Code quality, security, edge cases — scoped to changed files |
| QA | `qa` | sonnet | Full pre-release sweep: regression + layout + Play Store readiness |
| Refactor Architect | `code-architect` | sonnet | Refactoring strategy when a file/module has grown too large |
| CSS Implementer | `ui-implementer` | sonnet | Translates design specs into CSS (optional — use for complex UI work) |
| Publisher | `playstore-publisher` | sonnet | Play Store submission, signing, compliance |

**Opus is reserved for `product-advisor` and `code-reviewer` only.** These are the two highest-stakes decisions in the pipeline — what to build, and whether it's safe to ship. Everything else runs on sonnet.

---

## Pipelines by Task Type

Match the task to the right pipeline. Don't run the full pipeline for everything.

### Major new feature
```
product-advisor (opus)
  → nativephp-architect (sonnet)
  → ux-ui-designer (sonnet)        ← can run parallel with architect
  → nativephp-mobile (sonnet)
  → test-writer (sonnet)
  → code-reviewer (opus, scoped to changed files)
  → commit
```

### Small feature (1 screen + 1 endpoint)
```
nativephp-architect (sonnet, design the schema and screen together)
  → nativephp-mobile (sonnet)
  → test-writer (sonnet)
  → code-reviewer (opus, scoped)
  → commit
```

### Bug fix
```
nativephp-mobile (sonnet)
  → test-writer (sonnet)
  → code-reviewer (opus, scoped to the changed file only)
  → commit
```

### UI / style change
```
ux-ui-designer (sonnet)
  → nativephp-mobile (sonnet)
  → code-reviewer (opus, scoped)
  → commit
```

### Refactor
```
code-architect (sonnet)
  → nativephp-mobile (sonnet)
  → test-writer (sonnet)
  → code-reviewer (opus, scoped)
  → commit
```

### Pre-release
```
qa (sonnet) → fix issues → code-reviewer (opus, scoped) → commit
```

### Publish
```
qa (sonnet) → playstore-publisher (sonnet)
```

---

## Task-Type Shortcuts

Don't run the full pipeline for every task. Match the task to the right entry point:

| Task type | Pipeline |
|---|---|
| **New feature** | `product-advisor → nativephp-architect → ux-ui-designer → nativephp-mobile → test-writer → code-reviewer → commit` |
| **Bug fix** | `nativephp-mobile → test-writer → code-reviewer → commit` |
| **UI/style change** | `ux-ui-designer → nativephp-mobile → code-reviewer → commit` |
| **Backend-only change** | `nativephp-mobile → test-writer → code-reviewer → commit` |
| **Refactor** | `code-architect → nativephp-mobile → test-writer → code-reviewer → commit` |
| **Pre-release** | `qa → (fix issues) → code-reviewer → commit` |
| **Play Store submission** | `qa → playstore-publisher` |

---

## Feedback Loops

The pipeline is not strictly one-way. These loops are expected and normal:

```
test-writer finds a bug
  → back to nativephp-mobile to fix
  → test-writer re-runs to confirm
  → code-reviewer → commit

code-reviewer flags an issue
  → back to nativephp-mobile to fix
  → code-reviewer re-reviews the changed files only
  → commit

qa finds layout issues
  → ux-ui-designer for design spec (if unclear)
  → nativephp-mobile to implement fix
  → qa re-validates the specific screens

qa finds failing tests
  → test-writer to add missing coverage
  → nativephp-mobile to fix the underlying bug
  → qa re-runs suite
```

---

## Handoff Format

When passing context between agents, always include:

```
## Context from [previous-agent]

### What was decided
[Paste the key output — schema, brief, design spec, etc.]

### Your task
[What this agent specifically needs to do]

### Stack reminder
Laravel 12, NativePHP Mobile v3, SQLite, Blade SPA (single welcome.blade.php),
vanilla JS ES6, Pest v4, Tailwind CSS v4
```

Keep it short. Agents read CLAUDE.md for project context — you only need to pass what's new from the previous step.

---

## Supporting Agents

These sit outside the core pipeline and are triggered by need:

| Agent | Trigger |
|---|---|
| `code-architect` | A file exceeds ~500 lines, or complexity is making changes risky |
| `ui-implementer` | Design spec is complex and needs CSS worked out before the developer touches it |
| `playstore-publisher` | Ready to submit to Google Play Store |

---

## Rules

- **Never skip `product-advisor`** for new features — no code before requirements are clear
- **Use `nativephp-architect` not `Plan`** — the generic Plan agent doesn't know NativePHP conventions
- **You approve each handoff** — review agent output before moving to the next step
- **`test-writer` runs after every feature** — not at the end of the project
- **`code-reviewer` runs before every commit** — not just at the end
- **`qa` runs before every release** — not after every feature
- **`nativephp-architect` before `ux-ui-designer`** — database shape informs UI decisions

---

## CLAUDE.md Block (copy into new projects)

```markdown
## Agent Team Workflow

**Core pipeline (new feature):**
product-advisor → nativephp-architect → ux-ui-designer → nativephp-mobile → test-writer → code-reviewer → commit

**Task shortcuts:**
- Bug fix: nativephp-mobile → test-writer → code-reviewer → commit
- UI change: ux-ui-designer → nativephp-mobile → code-reviewer → commit
- Refactor: code-architect → nativephp-mobile → test-writer → code-reviewer → commit
- Pre-release: qa → (fixes) → commit
- Publish: qa → playstore-publisher

**Rules:**
- product-advisor shapes every new feature before any code
- nativephp-architect (not Plan) designs the schema and API
- test-writer runs after every feature
- code-reviewer runs before every commit
- qa runs before every release
- You approve each handoff before proceeding
```
