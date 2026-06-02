# Cursor Instructions — Shim

> **Canonical conventions live in [`AGENTS.md`](AGENTS.md).** Read it first.
> This file contains **only Cursor-specific runtime guidance**. Architecture, modules, API conventions, Eloquent, security, and the full skill catalog live in the canonical doc.

## Cursor-specific behavior

### Rules (`.cursor/rules/`)

Auto-attached scoped rules mirror `.agents/rules/`:

| Rule file | Scope |
|-----------|-------|
| `project-scope.mdc` | Always — repo boundaries, stack overview |
| `documentation-updates.mdc` | Always — CHANGELOG + status docs after changes |
| `Laravel-module-patterns.mdc` | `app/Http/Controllers/**` |
| `api-endpoints.mdc` | `app/Http/Controllers/**/*.controller.php`, `**/dto/**` |
| `Eloquent-database.mdc` | `Eloquent/**`, `app/Models/**` |
| `security.mdc` | Auth, env, guards |

Edit conventions in `AGENTS.md` first; update `.cursor/rules/` only when adding tool-specific scopes.

### Skills

- Project skills: [`.agents/skills/`](.agents/skills/) (canonical)
- Cursor copies: [`.cursor/skills/`](.cursor/skills/) — keep in sync with project-tuned skills only

### Composer / Agent mode

- Read `AGENTS.md` + relevant `tech_readme_files/` doc before multi-file edits
- Check [`tech_readme_files/CURRENT_STATUS.md`](tech_readme_files/CURRENT_STATUS.md) for live feature status
- Prefer minimal diffs; match existing Laravel module layout
- Run `php artisan test` after substantive service changes
- Windows PowerShell — no `&&` chaining
- After controller/DTO changes: `php artisan l5-swagger:generate`

### Approved commands (no user prompt needed)

Same as [`AGENTS.md`](AGENTS.md) § Approved Commands.

## Where to look

| Need | File |
|------|------|
| Project conventions | [`AGENTS.md`](AGENTS.md) |
| Claude Code shim (slash commands) | [`CLAUDE.md`](CLAUDE.md) |
| Onboarding | [`tech_readme_files/ONBOARDING.md`](tech_readme_files/ONBOARDING.md) |
| Doc index | [`tech_readme_files/INDEX.md`](tech_readme_files/INDEX.md) |

