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