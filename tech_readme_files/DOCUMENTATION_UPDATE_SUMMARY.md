# Documentation Update Summary

> Rolling log of documentation changes. Newest entries first.

---

## 2026-06-01 — Production hardening and Flutter integration

**What changed:** Added CI workflow, Redis readiness probe, auth rate limiting, HTTP logging interceptor, JWT Laravel Reverb auth, driver reviews endpoint, deployment and Flutter integration guides, ride-flow e2e test, OpenAPI refresh.

**Files touched:** `.github/workflows/ci.yml`, `routes/web.php`, `src/config/env.validation.php`, `app/Http/Controllers/health/*`, `app/Http/Controllers/auth/auth.controller.php`, `app/Http/Controllers/drivers/*`, `routes/channels.php*`, `app/Traits/interceptors/logging.interceptor.php`, `app/Traits/filters/global-exception.filter.php`, `app/Traits/messages/message-keys.php`, `test/*`, `tech_readme_files/DEPLOYMENT.md`, `tech_readme_files/FLUTTER_INTEGRATION.md`, `CHANGELOG.md`, `docs/API.md`, `docs/openapi/nokta-api.openapi.json`, `package.json`, `.env.example`

---

## 2026-06-01 — AI agent documentation surface

**What changed:** Added canonical `AGENTS.md`, tool shims (`CLAUDE.md`, `CURSOR.md`, `.codex/`, `.github/copilot-instructions.md`), `.agents/skills/` (add-module, add-endpoint, add-message-keys), `.cursor/rules/`, `.claude/commands/`, `tech_readme_files/` doc map, doc-hygiene scripts, and `.github/workflows/docs.yml`.

**Files touched:** `AGENTS.md`, `CHANGELOG.md`, `CLAUDE.md`, `CURSOR.md`, `.agents/**`, `.cursor/**`, `.codex/**`, `.claude/**`, `.github/**`, `tech_readme_files/**`, `scripts/**`, `.markdownlint-cli2.jsonc`, `README.md`

---

