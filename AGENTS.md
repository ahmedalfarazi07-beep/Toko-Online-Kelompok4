# Toko-online — AGENTS.md

Laravel 13.x (PHP 8.3+) — online store project. Fresh boilerplate, no custom code yet.

## Commands (run from repo root)

| Command | What it does |
|---------|-------------|
| `composer test` | Runs `php artisan config:clear` then `php artisan test` (PHPUnit) |
| `composer dev` | Starts 4 services concurrently: `php artisan serve`, `queue:listen --tries=1`, `pail --timeout=0`, `npm run dev` |
| `composer setup` | Full fresh setup: install deps → copy `.env` → `key:generate` → `migrate --force` → `npm install --ignore-scripts` → `npm run build` |
| `npm run build` | Vite production build |
| `npm run dev` | Vite dev server |
| `./vendor/bin/pint` | Laravel Pint (PSR-12 linter) |

Run `php artisan make:test NameTest` to create a test file.

## Structure

- `routes/web.php` — web routes (single boilerplate `/` route)
- `routes/console.php` — Artisan commands
- `app/Models/` — Eloquent models
- `app/Http/Controllers/` — controllers
- `app/Providers/AppServiceProvider.php` — app service provider
- `tests/Feature/`, `tests/Unit/` — PHPUnit tests (vanilla PHPUnit, not Pest)
- `resources/views/` — Blade templates
- `resources/css/app.css` — Tailwind entrypoint
- `bootstrap/app.php` — app configuration (routing, middleware, exceptions)
- `database/migrations/` — migrations (users, cache, jobs tables)
- `database/database.sqlite` — default SQLite DB

## Framework quirks

- **DB default**: SQLite (`database/database.sqlite`). MySQL/PostgreSQL available in config but commented out in `.env.example`.
- **Session/Cache/Queue**: All default to `database` driver — requires migrations to be run.
- **Testing**: Uses in-memory SQLite (`:memory:`) — no external DB needed.
- **Tailwind CSS v4**: Configured via CSS (`@import 'tailwindcss'`) with `@tailwindcss/vite` plugin. No `tailwind.config.js` or PostCSS config. No `@tailwind base/components/utilities` directives.
- **`.npmrc`**: `ignore-scripts=true` — postinstall scripts are disabled. Pass `--ignore-scripts` to `npm install`.
- **Font**: Instrument Sans loaded via Bunny CDN (`laravel-vite-plugin/fonts`).
- **`.editorconfig`**: 4-space indent (2-space for yaml).
- **Laravel Boost** available: `composer require laravel/boost --dev && php artisan boost:install` adds AI agent tooling.
