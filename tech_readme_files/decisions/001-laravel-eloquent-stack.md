# ADR 001 — Laravel + Eloquent + Redis

**Status:** Accepted

## Context

Need a production-ready PHP API with relational data, caching, real-time location, and background jobs.

## Decision

- Laravel for modular HTTP + DI
- Eloquent for PostgreSQL
- Redis for live location and Laravel Queues
- Laravel Reverb for realtime broadcasts

## Consequences

- Single deployable monolith; clear module boundaries under `app/Http/Controllers/`

