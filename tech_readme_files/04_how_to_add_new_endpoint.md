# 04 — How to Add a New Endpoint

1. Add DTO with `FormRequests` in `dto/`.
2. Implement service method (Eloquent / Redis as needed).
3. Add controller route with guards and Swagger decorators.
4. Use `message-keys.php` + `api-response.php` for standard envelopes; `status.mapper.php` for trip/delivery JSON.
5. Extend unit tests in `*.service.spec.php`.
6. Run `php artisan l5-swagger:generate` and update `docs/API.md` if public.
7. Update mandatory docs.

Skill: [`.agents/skills/add-endpoint/SKILL.md`](../.agents/skills/add-endpoint/SKILL.md)

