# Looply

Looply is a quiet stitch diary and showcase for knitting, crochet, embroidery,
sewing, and other handmade textile projects. Users will be able to record
projects, add ratings and craft notes, save favorites, and choose whether each
project is public or private.

The current Milestone 1 implementation is a static, responsive single-page
frontend. Authentication, database persistence, and the REST API are planned
for later milestones.

## Technology

- Frontend: HTML, CSS, JavaScript, jQuery
- SPA routing: hash-based routing with view templates in `frontend/views/`
- Backend planned: PHP with FlightPHP
- Database planned: MySQL accessed through PDO
- Local development: XAMPP or another local HTTP server

## Database and DAO layer

The MySQL schema is in [database/looply.sql](database/looply.sql). The backend
DAO layer is in [backend/dao/](backend/dao/) and provides prepared-statement
CRUD operations for users, categories, projects, reviews, and favorites.

To configure and test the DAOs locally:

1. Import [database/looply.sql](database/looply.sql) into MySQL.
2. Copy `backend/config/config.example.php` to `backend/config/config.php`
   and edit the database credentials.
   The password must be set in `backend/config/config.php` (or supplied as
   an environment variable); do not add it to the committed example file.
   The values must match DataGrip's host, port, database, user, and password.
3. From the repository root, run:

   ```text
   php backend/tests/dao_inspect.php
   ```

   In PowerShell, you can override the local config for the current terminal
   session without writing the password to a file:

   ```powershell
   $env:DB_HOST = "127.0.0.1"
   $env:DB_PORT = "3306"
   $env:DB_NAME = "looply"
   $env:DB_USER = "root"
   $env:DB_PASSWORD = "the-password-used-by-DataGrip"
   php backend\tests\dao_inspect.php
   ```

   If you are already in `backend`, run `php tests\dao_inspect.php` instead.
   `using password: NO` means that `DB_PASSWORD` was empty or was not set.
   Also compare DataGrip's host and port: MySQL permissions can differ
   between `localhost` and `127.0.0.1`, even for the same username.

The smoke test runs in a transaction and rolls back its test records when it
finishes.

To populate the database with linked demo data, run
[database/seed_fake_data.sql](database/seed_fake_data.sql) against the `looply`
database in DataGrip. It creates demo users, categories, public and private
projects, reviews, and favorites. The demo users use `demo-password` as their
placeholder password; change it before using these accounts for anything other
than local testing. The script can be run again without duplicating the demo
records.

To print the existing records and their relationships without changing
anything, run `php backend/tests/dao_inspect.php` from the repository root.

## Main entities and relationships

### Users

Stores account, profile, and role information. A user can create projects,
write reviews, and save projects as favorites. Profile location is optional.

### Categories

Stores categories such as Knitting, Crochet, Embroidery, and Sewing. One
category can contain many projects.

### Projects

Stores a user's project title, description, image, category, privacy setting,
and timestamps. Each project belongs to one user and one category.

### Reviews

Stores a project's 1–5 rating and craft details such as pattern source, yarn,
hook or needle size, notes, and timestamps. A project can have reviews and a
user can write reviews.

### Favorites

Connects users and projects. A user can save many projects, and a project can
be saved by many users. The pair `(user_id, project_id)` should be unique.

### Relationship summary

```text
users 1 ──── many projects
users 1 ──── many reviews
users many ──── many projects through favorites
categories 1 ──── many projects
projects 1 ──── many reviews
```

Draft ERD: [docs/looply-erd.svg](docs/looply-erd.svg)

## Roles

- `user`: manages their own profile and projects, rates projects, and saves
  favorites.
- `admin`: manages categories, users, and public content.

### Test accounts

Test accounts will be added when authentication is implemented. There are no
working accounts yet because the current Milestone 1 frontend is static.

| Role | Email | Password | Status |
|---|---|---|---|
| User | Pending | Pending | Authentication not implemented |
| Admin | Pending | Pending | Authentication not implemented |

## External API plan

The planned optional external API feature is a quote generator. The API and integration will be selected and implemented in
a later milestone.

No external API is called by the current static frontend.

## SPA views

The shared shell is [frontend/index.html](frontend/index.html). Page templates
are stored in `frontend/views/`:

- `view_login.html`
- `view_register.html`
- `view_home.html`
- `view_new_project.html`
- `view_project_details.html`
- `view_profile.html`
- `view_favorites.html`

Routes use hashes, for example:

```text
#view_home
#view_profile?user_id=4
```

## Documentation links

- Draft ERD: [docs/looply-erd.svg](docs/looply-erd.svg)
- Swagger documentation: Pending until the REST API is implemented.
- Deployed application: Pending deployment.