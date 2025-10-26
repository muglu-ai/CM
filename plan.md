# Laravel Migration & Implementation Plan

This document describes a step-by-step plan to transform this project into a Laravel application using Livewire + Volt, Filament admin, Laravel Sanctum for API auth, Spatie Permission for roles/permissions, and Spatie Query Builder for rich API filtering/sorting. It is written as an actionable checklist you can follow and commit from.

## Goal (concrete)
We will build a conference management application with the following concrete product goals and deliverables:

- Public-facing interactive agenda page where attendees can:
    - View sessions grouped by day/time with readable session cards.
    - Search sessions by title and speaker name.
    - Filter sessions by format, language, level, track, tags, and location.
    - Select dates (day tabs) and paginate long lists.
    - Expand a session card to see description, speakers, location/room, CEU hours, and add-to-calendar (ICS) export.
- Public-facing speakers listing page with speaker profiles and sessions.
- Admin panel (Filament) for managing Events, Sessions (event_sessions), Speakers and pivot data.
- Role-based access control using Spatie Permission with at least these roles: `admin`, `organizer`, `viewer`.
- API endpoints (Sanctum-protected when required) that support filtering/sorting/pagination via Spatie Query Builder (so external clients can consume events and sessions).
- Test coverage: Feature tests for API/auth flows and Livewire component tests for the agenda UI basic behavior.

Acceptance criteria (how we'll know we're done):
- The agenda page loads and returns session data quickly with working search and filters.
- Adding a session to calendar downloads a valid `.ics` file for that session.
- Filament admin can create, edit and delete events, sessions and speakers; access to Filament is limited to users with `admin` role.
- Seeded roles and an `admin` user are present after running the provided seeders.
- API endpoints return results filtered and sorted according to request parameters (Spatie Query Builder setup).
- Automated tests for the main happy paths pass locally (`php artisan test`).


## Development progress (live status)
This section records what has already been implemented in the repo and what remains next. Update this section as work progresses.

Status legend: DONE / IN PROGRESS / TODO

- DONE: Core schema migrations created
    - `database/migrations/2025_10_22_000001_create_events_table.php` (events)
    - `database/migrations/2025_10_22_000002_create_sessions_table.php` (renamed to create `event_sessions`)
    - `database/migrations/2025_10_22_000003_create_speakers_table.php` (speakers)
    - `database/migrations/2025_10_22_000004_create_session_speaker_table.php` (pivot `session_speaker`)
    - `database/migrations/2025_10_22_000005_add_filters_to_event_sessions.php` (adds format/language/level/track/tags/location/room/ceu_hours)

- DONE: Models and factories
    - `app/Models/Event.php` created
    - `app/Models/Session.php` created and uses `protected $table = 'event_sessions'`, casts and search/filter scopes
    - `app/Models/Speaker.php` created
    - Factories for Event/Session/Speaker created in `database/factories`

- DONE: User model updated
    - `app/Models/User.php` updated to include `HasApiTokens` and `HasRoles` (Spatie)

- DONE: Seeders & sample data
    - `database/seeders/RolePermissionSeeder.php` (roles & permissions)
    - `database/seeders/SampleDataSeeder.php` (admin user + sample events/sessions/speakers)
    - `DatabaseSeeder.php` wired to call the seeders

- DONE: Livewire Agenda UI (initial)
    - `app/Http/Livewire/AgendaIndex.php` created with search/filter/date selection and pagination
    - `resources/views/livewire/agenda-index.blade.php` created (Tailwind friendly)
    - `resources/views/agenda.blade.php` and `routes/web.php` updated to expose `/agenda`

- DONE: Calendar export
    - `app/Http/Controllers/CalendarController.php` added to serve session `.ics` downloads
    - Route `calendar/session/{session}` registered

- DONE: Minimal frontend layout + Tailwind/Vite pipeline
    - Installed Breeze (Livewire) scaffolding and built assets
    - `resources/views/layouts/minimal.blade.php` created and `agenda.blade.php` now extends it

- IN PROGRESS: Livewire discovery / component mapping
    - Livewire component registered explicitly in `AppServiceProvider::boot()` to ensure discovery
    - Running autoload & cache clearing commands was performed; verify in your environment that Livewire components are resolved (some environments may require a server restart)

- DONE: API controllers & routes (basic)
    - `app/Http/Controllers/Api/EventController.php` (index + show using Spatie Query Builder)
    - `app/Http/Controllers/Api/SessionController.php` (index + show using Spatie Query Builder)
    - `routes/api.php` created and routes registered (Sanctum-protected endpoints and public fallbacks)

- NEXT: Verify API endpoints locally and add permission checks where needed
    - Run `php artisan route:list` and test `GET /api/events` and `GET /api/sessions` with and without `auth:sanctum` as appropriate.

- TODO: Filament admin resources
    - Create `app/Filament/Resources/EventResource`, `SessionResource`, `SpeakerResource` and relation managers
    - Gate Filament access to `admin` role

- TODO: Authentication & token flows (Sanctum)
    - Add token issuance endpoints or choose SPA cookie-based flow and configure `EnsureFrontendRequestsAreStateful`

- TODO: Tests
    - Add Feature tests for API + Livewire interaction tests for `AgendaIndex`

- TODO: Filament customization, Volt components and visual polish
    - Add Volt components or Tailwind polish for grid, cards, and filters; add responsive behavior

- TODO: CI/CD and docs
    - Add GitHub Actions for test + build
    - Update README with quick start and developer notes


## Next immediate steps (priority)
1. Verify Livewire discovery and make sure `@livewire('agenda-index')` renders in your local dev server. Commands to run locally (cmd.exe):

```bash
composer dump-autoload -o
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan livewire:discover
npm run dev
php artisan serve
```

2. If the Livewire component cannot be found, restart the PHP server and ensure `AppServiceProvider::boot()` contains the explicit `Livewire::component('agenda-index', \App\Http\Livewire\AgendaIndex::class);` registration.

3. Begin Phase 6 (API controllers) and Phase 9 (Filament resources) in parallel:
    - Implement `Api\EventController` using Spatie Query Builder (index + show)
    - Scaffold Filament resources for Event/Session/Speaker with basic forms and tables


## Starter checklist (high-level)
- [ ] Create a branch for the migration (e.g., `feature/laravel-stack`)
- [ ] Install Composer & NPM packages
- [ ] Publish package configs (Sanctum, Spatie Permission, Filament)
- [ ] Add migrations and run `php artisan migrate`
- [ ] Add models, factories and seeders (roles/permissions + sample data)
- [ ] Implement API controllers using Spatie Query Builder
- [ ] Implement Sanctum token-based auth endpoints
- [ ] Add Livewire components and Volt views
- [ ] Add Filament resources and lock admin to `admin` role
- [ ] Add tests (Feature + Livewire)
- [ ] Build frontend assets and update README

## Phased plan (one-by-one development)

Phase 0 — Preparation (one commit)
1. Create branch: `git checkout -b feature/laravel-stack`.
2. Backup current project (copy folder or new branch). Keep the original `plan.md` for reference.
3. Verify environment: PHP >= 8.1 (or project requirement), Composer, Node, npm, sqlite/mysql/postgres setup.
4. Add brief note in `README.md` about migration plan & branch.

1Install NPM packages and dev build toolchains as required by Volt/Filament front-end.

```bash
npm install
```

2Publish vendor configs (Sanctum, Spatie Permission, Filament). Example:

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --tag=filament-config
```

Phase 2 — Configure middleware & env (small commit)
1. In `app/Http/Kernel.php` add `Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class` to `api` middleware group if SPA will call API with Sanctum cookies.
2. Configure `.env` database: set `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (or use the provided `database/database.sqlite`).
3. Configure `config/sanctum.php` `stateful` domains and `config/cors.php` to allow frontend domain.

Phase 3 — Database migrations (1–2 commits)
Create the core tables for the conference domain. Suggested order: events, sessions, speakers, pivot `session_speaker`.

Files to create (suggested names):
- `database/migrations/2025_10_22_000001_create_events_table.php`
- `database/migrations/2025_10_22_000002_create_sessions_table.php`
- `database/migrations/2025_10_22_000003_create_speakers_table.php`
- `database/migrations/2025_10_22_000004_create_session_speaker_table.php`

Run:

```bash
php artisan migrate
```

Phase 4 — Models, factories, relationships (one commit)
1. Create models with relationships and casts:
    - `app/Models/Event.php` (hasMany Sessions)
    - `app/Models/Session.php` (belongsTo Event, belongsToMany Speaker)
    - `app/Models/Speaker.php` (belongsToMany Session)
2. Update `User` model:
    - add `use Laravel\Sanctum\HasApiTokens;` and `use Spatie\Permission\Traits\HasRoles;`
    - add traits `HasApiTokens, HasFactory, Notifiable, HasRoles`.
3. Add factories in `database/factories` for fast test data creation.

Phase 5 — Seeders & initial roles/permissions (one commit)
1. Create `database/seeders/RolePermissionSeeder.php` to seed roles (`admin`, `organizer`, `viewer`) and permissions (`manage events`, `view events`).
2. Create `DatabaseSeeder` entries to call RolePermissionSeeder and seed a few events/sessions/speakers and an admin user.
3. Run:

```bash
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed
```

Phase 6 — API controllers + Spatie Query Builder (one commit)
1. Create API controllers using Spatie Query Builder to allow filtering/sorting/pagination. Example endpoints:
    - `GET /api/events` (filters: name partial, status; sorts: starts_at, name)
    - `GET /api/events/{event}` (eager load sessions & speakers)
2. Protect needed endpoints with `auth:sanctum` in `routes/api.php`.
3. Add policies or controller-level permission checks using Spatie (`->can('view events')`).

Phase 7 — Authentication & Sanctum endpoints (one commit)
1. Ensure `User` has `HasApiTokens` to create API tokens.
2. Add endpoints for token creation (login) and token revocation (logout) or use Sanctum's SPA approach.
3. Test token flow with HTTP client (Postman / curl / httpie).

Phase 8 — Livewire + Volt interface (2 commits)
1. Create Livewire components (e.g., `EventIndex`, `EventShow`) under `app/Http/Livewire`.
2. Create Volt / Blade views in `resources/views/livewire` that use Volt components for layout.
3. Wire web route(s) in `routes/web.php` to render Livewire pages.
4. Verify Livewire interactions (search, pagination) work against the database.

Phase 9 — Filament admin (1–2 commits)
1. Create Filament resources for `Event`, `Session`, `Speaker` in `app/Filament/Resources`.
2. Configure forms and tables, including relation managers for sessions/speakers.
3. Restrict Filament using `Filament\Auth\FilamentUserProvider` or middleware to users with `admin` role.

Phase 10 — Testing & policies (1 commit)
1. Add Feature tests for API endpoints, authentication, and permission checks.
2. Add Livewire component tests for UI behavior.
3. Run `php artisan test` and fix regressions.

Phase 11 — Assets, build, CI/CD (1 commit)
1. Integrate Volt and Filament styling into frontend pipeline.
2. Run `npm run build` and verify asset references in `resources/views`.
3. Add CI: a GitHub Actions workflow to run `composer install`, `npm ci`, `php artisan test`, `npm run build`.

Phase 12 — Cleanup & docs (final commit)
1. Remove obsolete Django/Mongo artifacts (if present) or move them to an `archive/` folder.
2. Update `README.md` with setup instructions and a short developer guide.
3. Merge branch and tag a release.

Detailed commands (copyable) — Windows (cmd.exe compatible)

Composer & publish:

```bash
composer require laravel/sanctum spatie/laravel-permission spatie/laravel-query-builder filament/filament livewire/livewire livewire/volt
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --tag=filament-config
```

Migrate & seed:

```bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
```

NPM build:

```bash
npm install
npm run build
```

Verification checklist (after initial implementation)
- [ ] `php artisan migrate` completes with no errors.
- [ ] `php artisan db:seed --class=RolePermissionSeeder` creates roles and permissions.
- [ ] API `GET /api/events` returns paginated JSON with filters and sorts when authenticated.
- [ ] Livewire pages render and search/paginate correctly.
- [ ] Filament admin is accessible only to `admin` role and supports CRUD for events/sessions/speakers.
- [ ] `npm run build` completes and assets are served correctly.
- [ ] `php artisan test` passes (or has new tests presence and passes locally).

Risks & edge cases
- Sanctum SPA vs token approach: choose one and configure `EnsureFrontendRequestsAreStateful` and `stateful` domains when using cookie-based SPA auth.
- Filament and Volt versions: check compatibility with installed Laravel version.
- Large datasets: ensure API pagination and efficient eager-loading to avoid N+1.

Next steps (what I'll do if you want me to continue)
1. Create the migrations + models + seeders files described above.
2. Add minimal Livewire `EventIndex` and Volt view.
3. Add Spatie Query Builder-based `EventController` and routes.
4. Run `php artisan migrate` and `php artisan db:seed` locally and run the test suite.

If you want me to proceed now, tell me which phase to start (I recommend starting with Phase 1: package installs and vendor:publish).
