---
description: "Eloquent schema, migrations, Redis"
globs: "Eloquent/**,app/Models/**"
alwaysApply: false
---

# Database

## Eloquent

- Schema: `Eloquent/schema.Eloquent`
- Migrations: `npm run Eloquent:migrate` (dev), deploy in Docker entrypoint for prod
- Seed: `npm run Eloquent:seed`
- Access only via `EloquentService` in services — not controllers

## Redis

- Live driver location and caching via `app/Models/redis.module.php`
- Keys/constants in `app/Models/redis.constants.php`

## Status enums

Eloquent enums may differ from Flutter strings — always map in `app/Traits/mappers/status.mapper.php` for API output.

