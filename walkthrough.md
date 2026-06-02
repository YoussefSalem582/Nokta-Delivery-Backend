# Nokta Laravel Backend Walkthrough

Welcome to the Nokta Laravel backend! This project is an educational, production-style Laravel implementation of the Nokta ride-hailing and delivery API. It mirrors the exact data contracts and structure expected by the Flutter app.

## Project Structure and Learning Flow

The backend follows a standard monolithic Laravel architecture optimized for readability and separation of concerns.

### 1. The Core API (Controllers)
All API endpoints live in [app/Http/Controllers/Api/V1](file:///D:/projects/nokta/nokta_delivery_backend/app/Http/Controllers/Api/V1).
- **Controllers are thin**: They handle HTTP requests, input validation, and delegate business logic to Services.
- Example: [TripController.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Http/Controllers/Api/V1/TripController.php) orchestrates the ride-hailing endpoints.

### 2. Business Logic (Services)
Complex operations (e.g., matching a driver, estimating fare, updating states) are isolated in Services in [app/Services](file:///D:/projects/nokta/nokta_delivery_backend/app/Services).
- [RideService.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Services/RideService.php): Handles estimating fares dynamically based on distance, and simulating driver acceptance.
- [DeliveryService.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Services/DeliveryService.php): Manages courier matching and package delivery states.
- [SyncService.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Services/SyncService.php): Processes offline queued actions and handles reconnection reconciliation.

### 3. Response Standardization (Traits)
To ensure the Flutter app receives exactly the JSON structure it expects (bilingual messages, standardized data blocks), we use an `ApiResponse` trait.
- [ApiResponse.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Traits/ApiResponse.php): Provides `buildResponse()` and `buildErrorResponse()`. It reads keys directly from `lang/en/messages.php` and `lang/ar/messages.php`.

### 4. Real-time Broadcasting (Laravel Reverb)
Unlike NestJS which used Socket.io, this Laravel app uses its native first-party WebSocket server: **Laravel Reverb**.
- **Events**: Changes in ride or delivery status trigger events in [app/Events](file:///D:/projects/nokta/nokta_delivery_backend/app/Events) (e.g., `RideStatusUpdated.php`).
- **Channels**: The WebSocket channels are authorized in [routes/channels.php](file:///D:/projects/nokta/nokta_delivery_backend/routes/channels.php) to ensure only the assigned rider/driver can listen to the stream.

### 5. Offline Sync & Idempotency
Mobile apps can lose connection. The Flutter app queues requests locally and sends an `Idempotency-Key` header when it reconnects.
- [IdempotencyMiddleware.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Http/Middleware/IdempotencyMiddleware.php): Intercepts this header, caches the initial successful response, and replays it if the same request is fired again. This prevents double-charging or creating duplicate rides.

### 6. Admin Dashboard (Blade UI)
A simple, read-only dashboard built with pure Laravel Blade and TailwindCSS is available for administrative oversight.
- **Views**: [resources/views/admin](file:///D:/projects/nokta/nokta_delivery_backend/resources/views/admin) contains the dashboard, users list, rides list, and deliveries list.
- **Controller**: [DashboardController.php](file:///D:/projects/nokta/nokta_delivery_backend/app/Http/Controllers/Admin/DashboardController.php) aggregates the data for the UI.

## How to Run the Project

1. **Start Sail**: The project uses Laravel Sail (Docker). Start it using `./vendor/bin/sail up -d`.
2. **Migrate and Seed**: Run `./vendor/bin/sail artisan migrate --seed` to generate the tables and the default demo users (`admin@nokta.com` and `rider@nokta.com`).
3. **Run Websockets**: Start Laravel Reverb to handle real-time traffic using `./vendor/bin/sail artisan reverb:start`.
4. **Queue Worker**: To process simulated push notifications, run `./vendor/bin/sail artisan queue:work`.

> [!TIP]
> **Learning Tip:** Start by reading the `routes/api.php` file to understand the entry points. Then follow the request flow into a Controller (like `TripController`), into a Service (`RideService`), and look at how the data is saved in the Model and returned to the user via the `ApiResponse` trait.
