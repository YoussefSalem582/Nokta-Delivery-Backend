# 10 — Testing

## Unit tests

```bash
php artisan test
npm run test:cov
```

- Co-locate `*.spec.php` with services under `app/Http/Controllers/`
- Mock `EloquentService` and Redis/queue dependencies

## E2E

```bash
php artisan test
```

Requires test database configuration (see `test/` and `pest-e2e.json`).

## After changes

Run `php artisan test` for touched modules before opening a PR.


