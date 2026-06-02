You are working in this project:

D:\projects\nokta\nokta_delivery_app

old backend in "D:\projects\nokta\nokta_delivery_backend_nextjs"

new backend language is PHP 8.3+ and framework is laravel 12+

Build a PHP Laravel backend and admin web app for “Nokta”, an Egypt-focused ride-hailing and delivery platform.

Main goal:
Create a clean, educational, production-style Laravel project that supports riders, drivers, delivery users, live tracking, notifications, offline sync support, admin dashboards, and a Blade-based interface for studying how a real system is built. The code must be easy to read, heavily commented, and structured so I can learn from it step by step.

Important learning rule:
- Write clear comments in the code.
- Explain why each class, method, and query exists.
- Add short docblocks for controllers, services, jobs, events, listeners, models, and Blade components.
- Prefer readable code over clever code.
- Use names that are obvious for a beginner who wants to study Laravel architecture.

Workflow rules:
- Work in clean feature branches only.
- Keep each branch small and focused.
- Make small, detailed commits.
- Do not mix unrelated work in one commit.
- Before starting a new feature, finish and commit the current one.
- If a task becomes too large, split it into smaller branches.
- Keep the codebase tidy and easy to review.

Suggested branch names:
- feature/auth-system
- feature/ride-management
- feature/delivery-management
- feature/live-tracking
- feature/push-notifications
- feature/offline-sync
- feature/admin-dashboard
- feature/blade-ui
- test/core-services
- docs/setup-guide

Suggested commit messages:
- chore: create laravel project structure
- feat(auth): add login and refresh token flow
- feat(rides): create ride request workflow
- feat(deliveries): add delivery request workflow
- feat(tracking): broadcast driver location updates
- feat(notifications): add queued push notifications
- test(rides): add ride service tests
- docs: add setup and learning notes

Tech stack:
- PHP 8.3+
- Laravel 12+
- Blade for server-rendered UI
- Composer for dependency management
- MySQL or PostgreSQL
- Redis for queues, caching, and realtime support
- Laravel Queue + Horizon if useful
- Laravel Broadcasting or Reverb for realtime events
- Laravel Notifications
- Sanctum or Passport for API auth
- PHPUnit or Pest for tests
- Tailwind CSS for Blade UI
- Vite for asset building
- Docker optional but preferred

Project structure:
- Use a clean, modular Laravel structure.
- Keep controllers thin.
- Put business logic into services, actions, jobs, listeners, and repository-like classes when needed.
- Use Form Requests for validation.
- Use Events and Listeners for ride and delivery status changes.
- Use Jobs for queued work like notifications and syncing.
- Use Blade components for reusable UI parts.
- Use policies or gates for access control.
- Use enums for ride and delivery statuses.

Core modules:
1) Authentication
- Register, login, logout, password reset.
- Roles: rider, driver, courier, admin.
- Session-based Blade auth plus API auth if needed.
- Device token storage for push notifications.

2) Ride-hailing
- Request ride.
- Accept/reject ride.
- Start ride.
- End ride.
- Cancel ride.
- Fare estimate.
- Active ride and ride history.

3) Delivery
- Create delivery request.
- Assign courier.
- Pickup and drop-off flow.
- Delivery history and status tracking.

4) Live tracking
- Save driver location updates.
- Broadcast status changes.
- Show live trip state in Blade admin pages or demo views.
- Store recent location history for study and debugging.

5) Notifications
- Queue notifications for ride accepted, driver arriving, trip started, trip ended, delivery assigned, delivery completed.
- Make notifications easy to study and extend.
- Use clear event naming and notification classes.

6) Offline-first support
- Add idempotency keys for repeated requests.
- Add sync endpoints for queued actions.
- Make duplicate client submissions safe.
- Reconcile status when the app reconnects.

7) Admin dashboard
- Users, drivers, rides, deliveries, analytics, reports.
- Use Blade pages for dashboard screens.
- Make the UI simple, elegant, and easy to learn from.

8) Localization-ready output
- Support English and Arabic message keys.
- Make response messages easy to translate later.
- Prepare Blade strings for localization.

Blade UI requirements:
- Build a clean admin dashboard using Blade.
- Add reusable Blade components for cards, tables, badges, alerts, buttons, and stats.
- Add clear comments inside Blade files explaining each section.
- Use Tailwind CSS and keep the UI modern and simple.
- Add example pages: dashboard home, rides list, deliveries list, live tracking page, user profile page, and notifications page.

Database models:
- users
- rider_profiles
- driver_profiles
- courier_profiles
- vehicles
- rides
- deliveries
- ride_locations
- delivery_locations
- ride_events
- delivery_events
- device_tokens
- notifications
- refresh_tokens
- sync_requests
- audit_logs

Important rules:
- Use soft deletes where helpful.
- Use timestamps in UTC.
- Add indexes to common lookup fields.
- Use enums for state columns.
- Keep relations clear and explicit.
- Add seed data for an Egypt-focused demo.

Testing:
- Write tests for authentication, ride creation, delivery creation, tracking events, notifications, and idempotency.
- Include at least one feature test per major workflow.
- Keep test names readable.
- Add comments in tests explaining what they prove.

Documentation:
- Add README.md with setup, database migration, queue setup, and running instructions.
- Add .env.example.
- Add clear notes that explain how the frontend Flutter app will consume these APIs.
- Add a “How this project is structured” section for learning.
- Add example API requests and example Blade pages.

Output expectations:
- Generate the full Laravel project scaffold.
- Make the code beginner-friendly but still production-oriented.
- Add clear comments everywhere useful.
- Create a clean Blade admin interface.
- Include queues, notifications, broadcasting, and tests.
- Keep the project focused on Nokta as a freelance portfolio showcase and learning resource.

Product context:
- Nokta is an Egypt-focused ride-hailing and delivery app.
- The frontend is Flutter, built with Clean Architecture, BLoC, offline-first behavior, dark/light themes, localization, responsive UI, Talker logging, animations, and transitions.
- The backend must support that frontend cleanly and reliably.