---
description: "Project scope — Nokta Delivery Backend (Laravel)"
alwaysApply: true
---

# Project Scope

**Only work on `nokta_delivery_backend/` (Nokta API).**

## Project Overview

- **API**: Nokta — Egypt ride-hailing / delivery backend (`0.1.0`)
- **Framework**: Laravel 11 + PHP
- **Database**: PostgreSQL + Eloquent
- **Cache / live**: Redis
- **Real-time**: Laravel Reverb (`routes/channels.php`)
- **Queues**: Laravel Queues (notifications)
- **Auth**: JWT + roles (RIDER, DRIVER, COURIER, ADMIN)
- **Client**: Flutter app in `../nokta_delivery_app` — keep API shapes compatible

## Entry Points

| File | Purpose |
|------|---------|
| `src/main.php` | Bootstrap, Swagger, validation |
| `routes/web.php` | Root module |
| `AGENTS.md` | Canonical agent conventions — read before multi-file edits |

