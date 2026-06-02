---
name: add-module
description: Scaffold a new Laravel feature module with controller, service, DTO folder, and unit test stub. Use when adding a new domain area to the API.
---

# Add Laravel Module

Reference `tech_readme_files/03_how_to_add_new_module.md`.

## Step 1 — Module folder

Create `app/Http/Controllers/<domain>/` with:

- `<domain>.module.php` — imports `DatabaseModule` or peer modules as needed
- `<domain>.controller.php` — empty or health-style stub
- `<domain>.service.php` — inject `EloquentService`
- `dto/` — placeholder or first DTO
- `<domain>.service.spec.php` — basic test with mocked Eloquent

## Step 2 — Register

Add `<Domain>Module` to `imports` in `routes/web.php`.

## Step 3 — Swagger (optional)

Add `@ApiTags('<domain>')` on controller when routes are added.

## Step 4 — Docs

Update `CHANGELOG.md`, `DOCUMENTATION_UPDATE_SUMMARY.md`, `CURRENT_STATUS.md`.

