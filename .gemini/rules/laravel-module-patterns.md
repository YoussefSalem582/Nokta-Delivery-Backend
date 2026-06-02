---
description: "Laravel module layout — controller, service, FormRequests"
globs: "app/Http/Controllers/**"
alwaysApply: false
---

# Laravel Module Patterns

## Layout

```
app/Http/Controllers/<domain>/
├── <domain>.module.php
├── <domain>.controller.php
├── <domain>.service.php
├── dto/
└── *.spec.php
```

## Rules

- Controllers: routing, guards, Swagger decorators only — delegate to services.
- Services: business logic, Eloquent calls, Redis, enqueue jobs.
- Register new modules in `routes/web.php`.
- Use `@CurrentUser()` decorator for authenticated user id.
- Use `@Roles()` for role-gated routes.

## Testing

Co-locate `*.spec.php` with services; mock `EloquentService` and external deps.

