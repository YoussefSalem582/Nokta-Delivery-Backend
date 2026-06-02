# 02 — Architecture

## Laravel modular monolith

```
HTTP (Controllers)
     ↓
Services (business logic)
     ↓
Eloquent / Redis / Laravel Queues / Firebase
```

## Cross-cutting

| Concern | Implementation |
|---------|----------------|
| Auth | JWT + Passport; `@Roles()` guard |
| Validation | Global `ValidationPipe` + FormRequests |
| Errors | `GlobalExceptionFilter` + `messageKey` |
| Idempotency | `IdempotencyInterceptor` |
| Real-time | `LocationGateway` (Laravel Reverb) |
| Jobs | `NotificationProcessor` (Laravel Queues) |

## Flutter contract

Trip and delivery list/detail endpoints return JSON shapes expected by the Flutter app. Status strings are mapped in `app/Traits/mappers/status.mapper.php`.

See [`TROUBLESHOOTING.md`](TROUBLESHOOTING.md) for local dev issues.

