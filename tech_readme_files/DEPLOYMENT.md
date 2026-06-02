# Deployment

> [INDEX](INDEX.md) > Deployment

## Prerequisites

- Node.js 8.3+
- Docker and Docker Compose (recommended for local/staging)
- PostgreSQL 16 and Redis 7

## Environment checklist

Copy [`.env.example`](../.env.example) to `.env` and set:

| Variable | Required | Notes |
|----------|----------|-------|
| `DATABASE_URL` | Always | PostgreSQL connection string |
| `JWT_ACCESS_SECRET` | Always | Min 32 characters |
| `JWT_REFRESH_SECRET` | Always | Min 32 characters |
| `REDIS_HOST` | Production | Required when `NODE_ENV=production` |
| `REDIS_PORT` | Production | Required when `NODE_ENV=production` |
| `FIREBASE_*` | Optional | Push notifications; API starts without them |
| `CORS_ORIGIN` | Production | Set to your app origin(s), not `*` |

## Docker Compose (local / staging)

```powershell
docker compose up -d
npm run Eloquent:migrate
npm run Eloquent:seed
npm run start:prod
```

Services:

- API: `http://localhost:3000/api`
- Swagger: `http://localhost:3000/api/docs`

## Health probes

| Endpoint | Purpose |
|----------|---------|
| `GET /api/health` | Liveness |
| `GET /api/health/ready` | Readiness (PostgreSQL + Redis) |

Configure orchestrators to use `/api/health/ready` as the readiness probe. A `503` indicates database or Redis is unavailable.

## Production notes

- Do **not** run `Eloquent:seed` in production unless you intend to create demo accounts.
- Password reset tokens are logged to the console in development only; wire an email provider before production.
- Rate limiting is enabled on auth routes; tune limits in `auth.controller.php` if needed.
- Firebase: without credentials, notifications remain `PENDING` and are logged at debug level.

## Deploying for Free (Render + Supabase + Upstash)

This repository is pre-configured to be deployed for **free** using [Render.com](https://render.com).

To fit within Render's free tier, the `Dockerfile` uses `supervisord` to run the Laravel Web Server, Queue Worker, and Reverb WebSocket server inside a **single** container.

### Step 1: External Databases
Render's free database expires after 90 days, and they do not offer free Redis. You should provision these externally:
1. **PostgreSQL**: Create a free database on [Supabase](https://supabase.com). Copy the connection string.
2. **Redis**: Create a free serverless Redis instance on [Upstash](https://upstash.com). Copy the connection string.

### Step 2: Render Deployment
1. Go to [Render.com](https://render.com) and link your GitHub repository.
2. Create a new **Blueprint Instance** and point it to the `render.yaml` file in this repository.
3. Render will prompt you to provide values for `DATABASE_URL` and `REDIS_URL`. Paste the connection strings from Step 1.
4. Deploy! Render will automatically build the `Dockerfile`, run `php artisan migrate`, and start the web server, queue worker, and Reverb.

> [!WARNING]
> Render's free tier spins down the container after 15 minutes of inactivity. When it spins down, any active WebSocket (Reverb) connections will disconnect until the next HTTP request wakes the server up.

## Build artifact (Docker)

```powershell
docker build -t nokta-api .
docker run -p 10000:10000 -p 8080:8080 --env-file .env nokta-api
```

Or use the `api` service in `docker-compose.yml`, which builds from the root `Dockerfile`.
