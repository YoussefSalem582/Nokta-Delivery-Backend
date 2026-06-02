---
description: "HTTP endpoints — FormRequests, Swagger, Flutter-compatible responses"
globs: "app/Http/Controllers/**/*.controller.php,app/Http/Controllers/**/dto/**"
alwaysApply: false
---

# API Endpoints

## Flow

1. Define `FormRequests` DTO in `dto/`
2. Implement service method (Eloquent + business rules)
3. Add controller route with guards and `@Api*` decorators
4. For mutations with standard envelope: use `message-keys.php` + `api-response.php`
5. For trip/delivery reads: map status via `status.mapper.php`

## Flutter paths

Preserve existing path prefixes (`/trips`, `/v1/driver/*`, `/orders`, etc.). See `docs/API.md`.

## Idempotency

Mutating routes that support offline retry should work with `IdempotencyInterceptor` (header `Idempotency-Key`).

## OpenAPI

After DTO/controller changes: `php artisan l5-swagger:generate`

