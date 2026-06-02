# Nokta Backend — Agent Instructions

<!-- canonical-banner:start -->
> **Canonical source of truth for AI agents.**
> This file is the single authoritative guide for every agent (Cursor, Claude Code, Codex CLI, GitHub Copilot, Gemini, Aider, Windsurf, generic). The per-tool instruction files below are **thin shims** that pull in tool-specific runtime conventions and reference this document for everything else — do **not** duplicate content from this file into them.
>
> | Tool | Shim file | What lives only in the shim |
> |------|-----------|------------------------------|
> | All / generic | [.agents/AGENTS.md](.agents/AGENTS.md) | Skill folder location |
> | Claude Code | [CLAUDE.md](CLAUDE.md) | Tool-use rules, response style, slash-commands (`.claude/commands/`) |
> | OpenAI Codex CLI | [.codex/AGENTS.md](.codex/AGENTS.md) | Approval-mode mapping, `apply_patch` preference |
> | GitHub Copilot | [.github/copilot-instructions.md](.github/copilot-instructions.md) | Inline-completion + Copilot-Chat conventions |
> | Cursor | [CURSOR.md](CURSOR.md) + [.cursor/rules/](.cursor/rules/) `*.mdc` | Auto-attached rule scopes |
> | Gemini | [GEMINI.md](GEMINI.md) | Tool-use rules, response style, approved commands |
> | Antigravity | [ANTIGRAVITY.md](ANTIGRAVITY.md) | Tool-use rules, response style, approved commands |
>
> **If you edit project conventions, edit this file.** Shims should never grow back into full mirrors.
<!-- canonical-banner:end -->

> **Scope**: Only modify files inside `nokta_delivery_backend/` (this repo). Flutter client lives in `nokta_delivery_app/`.

## Table of Contents

- [Project Overview](#project-overview)
- [Key Entry Points](#key-entry-points)
- [Architecture](#architecture)
- [API Conventions](#api-conventions)
- [Flutter Compatibility](#flutter-compatibility)
- [Database & Eloquent](#database--eloquent)
- [Real-time & Jobs](#real-time--jobs)
- [Security](#security)
- [Testing](#testing)
- [Naming Conventions](#naming-conventions)
- [Mandatory Documentation (after every change)](#mandatory-documentation-after-every-change)
- [Approved Commands (no user prompt required)](#approved-commands-no-user-prompt-required)

## Project Overview

Production Laravel API for **Nokta** — Egypt-focused ride-hailing and delivery. Current version: **`1.0.0`**.

- **Framework**: Laravel 12 + PHP 8.3+
- **Database**: PostgreSQL via Eloquent
- **Cache / live state**: Redis
- **Real-time**: Laravel Reverb
- **Queues**: Laravel Queues (database or redis)
- **Auth**: Laravel Sanctum (Token-based); roles `RIDER`, `DRIVER`, `COURIER`, `ADMIN`
- **Validation**: FormRequests
- **Docs**: Swagger via `l5-swagger`
- **Client**: Flutter app in `../nokta_delivery_app` — paths and trip JSON shapes must stay compatible
- **Platform**: Windows 11 development (PowerShell-first scripts), using Laravel Sail (Docker)

## Key Entry Points

| File | Purpose |
|------|---------|
| `routes/api.php` | All API routes |
| `routes/web.php` | Admin dashboard routes |
| `routes/channels.php` | Reverb WebSocket authorization channels |
| `app/Services/` | Core business logic (RideService, DeliveryService) |
| `app/Traits/ApiResponse.php` | Standard success/error envelopes |
| `app/Http/Middleware/IdempotencyMiddleware.php` | Offline `Idempotency-Key` handling |
| `docs/API.md` | Human-readable API reference |

## Architecture

Controllers are thin and delegate logic to Services. Standard response formatting is handled by the `ApiResponse` trait to ensure Flutter compatibility.

**Dependency rule**: Controllers → Services → Models. Keep business logic out of controllers.

## API Conventions

### Response envelopes

Mutations return standard formats:

```json
{
  "success": true,
  "messageKey": "auth.login.success",
  "data": {}
}
```

## Flutter Compatibility

When adding or changing trip/driver/delivery endpoints, verify against:

- `nokta_delivery_app/lib/core/network/api_endpoints.dart`
- `docs/API.md`

## Database & Eloquent

- Migrations: `php artisan migrate`
- Models are located in `app/Models/` and use UUIDs.
- Seed: `php artisan db:seed`

## Real-time & Jobs

- Laravel Reverb for real-time WebSocket communication. Events are in `app/Events/`.
- Notifications and long running tasks are in `app/Jobs/`.

## Security

- JWT/Token secrets via Laravel Sanctum.
- Protect routes using standard `auth:sanctum` middleware.

## Testing

- Unit/Feature: Pest testing in `tests/Feature/`.
- Run `php artisan test` after substantive service changes.

## Naming Conventions

| Item | Convention |
|------|------------|
| Controllers/Models | `PascalCase` |
| Methods/vars | `camelCase` |
| DB Tables | `snake_case` (Laravel default) |

## Mandatory Documentation (after every change)

1. `CHANGELOG.md` — add entry under `[Unreleased]` (Keep a Changelog format)
2. `tech_readme_files/DOCUMENTATION_UPDATE_SUMMARY.md` — dated entry at top
3. `tech_readme_files/CURRENT_STATUS.md` — update feature status and metrics

## Approved Commands (no user prompt required)

| Category | Command |
|----------|---------|
| Laravel | `php artisan migrate`, `php artisan test`, `php artisan route:list`, `./vendor/bin/sail up -d` |
| Swagger | `php artisan l5-swagger:generate` |
