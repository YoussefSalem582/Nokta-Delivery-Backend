---
name: add-endpoint
description: Add an HTTP endpoint end-to-end — DTO, service, controller, Swagger, message keys. Use when exposing a new API route.
---

# Add HTTP Endpoint

Reference `tech_readme_files/04_how_to_add_new_endpoint.md`.

## Step 1 — DTO

`app/Http/Controllers/<domain>/dto/*.dto.php` with `FormRequests` decorators.

## Step 2 — Service

Business logic in `<domain>.service.php`; Eloquent queries here.

## Step 3 — Controller

Route + `@UseGuards(JwtAuthGuard)` + `@Roles()` if needed + `@ApiOperation` / `@ApiResponse`.

## Step 4 — Response shape

- Standard mutation envelope: `message-keys.php` + `api-response.php`
- Trip/delivery resource: Flutter JSON via `status.mapper.php`

## Step 5 — Tests

Extend `<domain>.service.spec.php` for new service methods.

## Step 6 — OpenAPI export

`php artisan l5-swagger:generate` — update `docs/API.md` if public contract changes.

## Step 7 — Docs

CHANGELOG + tech_readme status files.

