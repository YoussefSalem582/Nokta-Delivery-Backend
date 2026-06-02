# 01 — Folder Structure

```
nokta_delivery_backend/
├── src/
│   ├── main.php
│   ├── app.module.php
│   ├── common/           # guards, filters, interceptors, mappers, message keys
│   ├── config/
│   ├── database/         # Eloquent + Redis modules
│   ├── modules/          # feature modules (auth, rides, drivers, …)
│   ├── realtime/         # Laravel Reverb gateways
│   └── jobs/             # Laravel Queues processors
├── Eloquent/
│   ├── schema.Eloquent
│   └── seed.php
├── test/                 # e2e tests
├── docs/                 # API.md, OpenAPI, Postman
├── scripts/              # OpenAPI export, doc hygiene
├── tech_readme_files/    # extended technical docs
└── AGENTS.md             # canonical AI agent guide
```

