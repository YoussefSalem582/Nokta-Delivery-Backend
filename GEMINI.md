# Gemini Instructions — Shim

> **Canonical conventions live in [`AGENTS.md`](AGENTS.md).** Read it first.
> This file contains **only Gemini-specific runtime guidance** (tool-use rules, response style, approved commands). Architecture, modules, API conventions, Eloquent, security, and the full skill catalog all live in the canonical doc.

## Response Guidelines

- Be concise — lead with the action or answer, skip preamble.
- Reference files with relative paths (e.g., `app/Http/Controllers/auth/auth.service.php`).
- Ask before creating new files that aren't required by the task.
- One task at a time — complete it fully before moving on.
- After every meaningful change: update `CHANGELOG.md`, `tech_readme_files/DOCUMENTATION_UPDATE_SUMMARY.md`, and `tech_readme_files/CURRENT_STATUS.md` (per canonical doc § Mandatory Documentation).

## Environment

- **Platform**: Windows 11 — use PowerShell syntax in Bash commands, not Unix shell.
- **Shell scripts**: Use `.ps1` equivalents (`scripts/sync_ai_ignores.ps1`, `scripts/check_docs_freshness.ps1`).
- **PHP**: 8.3+; run via `php artisan <script>`.
- **Approved commands** (no prompt needed):
  - Build / test: `composer install`, `./vendor/bin/sail up -d`, `php artisan test`, `composer lint`
  - Eloquent/DB: `php artisan migrate`, `php artisan db:seed`
  - Docs: `php artisan l5-swagger:generate`
  - Doc tooling: `.\scripts\sync_ai_ignores.ps1`, `.\scripts\sync_ai_ignores.ps1 -Check`, `.\scripts\check_docs_freshness.ps1`

## Tool-use rules

- **Read before edit**: always read a file before modifying it.
- **Prefer targeted edits** over full rewrites unless warranted.
- **Never hardcode secrets** — use `ConfigService` and `.env.example`.
- **Bash on Windows**: pwsh-native syntax — no `&&` chaining (use `;` or separate calls). Quote paths with spaces.
- **Don't run interactive commands**: no `git rebase -i` or interactive prompts in CI. Pre-fill args.

## Skill catalog

3 project-tuned skills live in [`.agents/skills/`](.agents/skills/). Full catalog in [`AGENTS.md`](AGENTS.md) § Available Skills.

## Where to look

| Need | File |
|------|------|
| Project conventions | [`AGENTS.md`](AGENTS.md) |
| Onboarding & doc-map | [`tech_readme_files/INDEX.md`](tech_readme_files/INDEX.md) |
| Troubleshooting | [`tech_readme_files/TROUBLESHOOTING.md`](tech_readme_files/TROUBLESHOOTING.md) |
| Common pitfalls | [`tech_readme_files/COMMON_PITFALLS.md`](tech_readme_files/COMMON_PITFALLS.md) |
| Architecture decisions | [`tech_readme_files/decisions/`](tech_readme_files/decisions/) |
| Glossary | [`tech_readme_files/GLOSSARY.md`](tech_readme_files/GLOSSARY.md) |
