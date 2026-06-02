# Nokta API Reference

## Authentication

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/refresh`
- `POST /api/v1/auth/logout`

## Profile

- `GET /api/profile`

## Rides & Trips

- `POST /api/rides/estimate-fare`
- `POST /api/trips/request`
- `GET /api/trips`
- `GET /api/trips/active`
- `GET /api/trips/{id}`
- `PATCH /api/trips/{id}/status`

## Drivers

- `GET /api/drivers`
- `GET /api/v1/driver/offers`
- `POST /api/v1/driver/offers/{id}/accept`
- `POST /api/v1/driver/offers/{id}/decline`

## Deliveries

- `POST /api/deliveries`
- `GET /api/deliveries`
- `GET /api/deliveries/active`
- `GET /api/deliveries/{id}`
- `PATCH /api/deliveries/{id}/status`

## Offline Sync

- `POST /api/v1/sync/actions`
- `GET /api/v1/sync/reconcile`

## Location Updates (Real-time)

- `POST /api/trips/{id}/location`
- `POST /api/deliveries/{id}/location`

*Note: All protected endpoints require a Bearer token. Some endpoints require specific roles (`DRIVER`, `COURIER`, `RIDER`). For real-time updates, Laravel Reverb provides WebSocket capabilities at the `/app` route configured in `config/reverb.php`.*
