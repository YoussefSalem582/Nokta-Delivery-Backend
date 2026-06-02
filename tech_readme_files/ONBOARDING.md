# Onboarding — Nokta Backend

> [INDEX](INDEX.md) > Onboarding

## Day 1

1. Read [`README.md`](../README.md) and run `composer install`, `docker compose up -d postgres redis`, `npm run Eloquent:migrate`, `./vendor/bin/sail up -d`
2. Read [`AGENTS.md`](../AGENTS.md) — canonical conventions
3. Skim [02_architecture.md](02_architecture.md) — module layout
4. Open Swagger: `http://localhost:3000/api/docs`
5. Try seed login: `rider@nokta.app` / `RiderPass123!` — see [`docs/API.md`](../docs/API.md)

## Key paths

| Need | Location |
|------|----------|
| Bootstrap | `src/main.php`, `routes/web.php` |
| Config | `src/config/`, `.env.example` |
| Eloquent | `Eloquent/schema.Eloquent` |
| Message keys | `app/Traits/messages/message-keys.php` |
| Flutter status mapping | `app/Traits/mappers/status.mapper.php` |
| API reference | `docs/API.md` |
| Flutter client | `../nokta_delivery_app` |

## Doc hygiene scripts

| Command | Purpose |
|---------|---------|
| `.\scripts\sync_ai_ignores.ps1` | Regenerate AI ignore files |
| `.\scripts\check_docs_freshness.ps1` | Version sync check |

## Do not

- Hardcode secrets or JWT keys in source
- Return Eloquent enum names in Flutter trip JSON
- Skip CHANGELOG + status doc updates after meaningful changes

