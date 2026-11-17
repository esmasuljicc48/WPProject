# Looply

Looply is a peaceful stitch diary and showcase for knitting, crochet,
embroidery, sewing, and other handmade textile projects. It is a responsive
single-page frontend with a FlightPHP REST backend and MySQL persistence.

## Technology and structure

- Frontend: HTML, CSS, JavaScript, jQuery, Bootstrap 5, hash-based SPA views
- Backend: PHP 8.2, FlightPHP, PDO, OpenAPI 3, Swagger UI
- Database: MySQL
- Local server: XAMPP or the PHP built-in server

The backend follows `route -> service -> DAO -> database`. Routes contain HTTP
transport code only, services contain validation and business rules, and DAOs
contain prepared SQL queries.

```text
frontend/
  css/ js/ views/ assets/
backend/
  config/ dao/ services/ routes/ middleware/ utils/ logs/
  public/v1/docs/
database/
  looply.sql
  seed_fake_data.sql
docs/
  AI_LOG.md
```

## Entities and relationships

- **Users** create projects and reviews. Users have either the `user` or
  `admin` role.
- **Categories** group projects.
- **Projects** belong to one user and one category and can be public or private.
- **Reviews** belong to a project and a user and contain a 1–5 rating plus
  craft notes.
- **Favorites** connect users and projects in a unique many-to-many relation.

The ERD is available at [docs/looply-erd.svg](docs/looply-erd.svg).

## Local setup

1. Import [database/looply.sql](database/looply.sql) into MySQL.
2. Optionally import [database/seed_fake_data.sql](database/seed_fake_data.sql)
   for demo records.
3. Copy `backend/config/config.example.php` to
   `backend/config/config.php` and set the database values. The local
   configuration is ignored by Git and must not contain committed secrets.
4. Install backend dependencies:

   ```text
   cd backend
   composer install
   ```

With XAMPP, open `http://localhost/WPProject/frontend/` and use the API at
`http://localhost/WPProject/backend/`.

For the PHP built-in server, run from the project root:

```text
php -S localhost:8000 server.php
```

The frontend is then at `http://localhost:8000/frontend/` and the API is at
`http://localhost:8000/backend/`.

## REST API

All CRUD endpoints return JSON. Creates return `201`; successful reads,
updates, and deletes return `200`; invalid input returns `400`; missing
resources return `404`; unexpected server failures return `500`.

```text
GET    /categories                 POST   /categories
GET    /categories/{id}            PUT    /categories/{id}
DELETE /categories/{id}

GET    /users                      POST   /users
GET    /users/{id}                 PUT    /users/{id}
DELETE /users/{id}

GET    /projects                   POST   /projects
GET    /projects/{id}              PUT    /projects/{id}
DELETE /projects/{id}
GET    /projects/public
GET    /projects/user/{user_id}

GET    /reviews                    POST   /reviews
GET    /reviews/{id}               PUT    /reviews/{id}
DELETE /reviews/{id}

GET    /favorites                  POST   /favorites
GET    /favorites/{user_id}/{project_id}
PUT    /favorites/{user_id}/{project_id}
DELETE /favorites/{user_id}/{project_id}
```

## External API

`GET /weather/forecast?city=Sarajevo&days=7` calls the Open-Meteo geocoding
and forecast APIs and returns a user-ready daily forecast with descriptions,
icons, and temperatures. The service validates the request, uses connection
and request timeouts, checks HTTP and JSON responses, returns friendly `404`
or `503` errors, and keeps the API URLs and timeout configurable.

## Swagger documentation

Open the interactive Swagger UI at
`http://localhost/WPProject/backend/public/v1/docs/` when using XAMPP, or
`http://localhost:8000/backend/public/v1/docs/` with the built-in server.
The raw OpenAPI document is available at the same path followed by
`swagger.php`.

## Test accounts

Seed data includes these local demonstration users. Their passwords are only
placeholders for local development and must be changed before deployment.

| Role | Email | Password |
|---|---|---|
| User | maya@example.test | `demo-password` |
| User | jonah@example.test | `demo-password` |
| Admin | nora@example.test | `demo-password` |

Authentication and authorization are scheduled for Milestone 4; these accounts
are currently database records, not login accounts.

## Deployment

Deployment and the public application URL are pending Milestone 5.

## AI usage

AI usage for each milestone is documented in [docs/AI_LOG.md](docs/AI_LOG.md).
