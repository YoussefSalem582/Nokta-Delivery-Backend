# 03 — How to Add a New Module

1. Create `app/Http/Controllers/<domain>/` with module, controller, service, `dto/`, and `*.service.spec.php`.
2. Import `DatabaseModule` (or other modules) in `<domain>.module.php`.
3. Register `<Domain>Module` in `routes/web.php`.
4. Add `@ApiTags` when exposing routes.
5. Update `CHANGELOG.md` and status docs.

Skill: [`.agents/skills/add-module/SKILL.md`](../.agents/skills/add-module/SKILL.md)

