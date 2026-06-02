---
description: "Auth, env secrets, guards"
globs: "app/Http/Controllers/auth/**,app/Traits/guards/**,src/config/**,.env.example"
alwaysApply: false
---

# Security

- Never commit `.env` — document vars in `.env.example`
- JWT via `JwtAuthGuard` + `jwt.strategy.php`
- Role checks via `@Roles()` and `RolesGuard`
- Passwords: bcrypt in `auth.service.php`
- Firebase Admin: env-only credentials
- Do not log access tokens or refresh tokens

