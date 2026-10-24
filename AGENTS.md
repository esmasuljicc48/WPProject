# AGENTS.md
 
## Project
[Looply]: [A stitch diary, a cozy single-page web application designed for fiber artists to log, rate, and showcase their knitting, crochet and textile projects in a peaceful, distraction-free space.].
Roles: [admin, user]. Entities: [users, ..., at least 5].

### Product brief
- Looply is a quiet, no-pressure stitch diary and showcase for knitting, crochet,
  embroidery, sewing, and handmade textile projects.
- It is a single-page application: page switches, profile views, and project
  detail modals happen in memory without white-screen reloads, and feed scroll
  position is preserved.
- There are no likes or comments. Users can create, edit, delete, rate their
  own projects from 1 to 5 stars, mark favorites, and set each project Public
  or Private. Public projects appear in the shared main feed; private projects
  remain on the creator's profile. Admins manage categories, public content,
  and users.
- Core entities are users, categories, projects, reviews, and favorites.
  Projects support a title, description, image, category, privacy, and
  timestamp. Reviews support rating, pattern source/link, yarn used, hook or
  needle size, notes, and timestamp.

### Product design
- Visual direction: peaceful Coastal Cottage with deep espresso readability.
- Palette: Foam White `#F2EEE5`, Deep Coffee Shell `#4B3621`, Soft Butter
  `#EBD1A7`, Dune Sand `#D2B995`, Driftwood `#766A5E`, Tidal Blue
  `#678D9A`, Sea Glass `#A9C6BC`, and white card surfaces.
- Never use pure black. Espresso backgrounds use Soft Butter text/icons;
  Soft Butter backgrounds use Espresso text/icons; Sea Glass badges use
  Espresso text. Use 12px–16px organic rounded corners.
- Use Fraunces for titles, headers, and card titles, and Plus Jakarta Sans for
  body/UI text. Use Bootstrap 5 responsive layouts and avoid inline styles.
- The top bar contains the Looply wordmark and “A stitch diary” subtitle, a
  title search, “+ New Project”, and the user's photo or fallback avatar.
- The public feed is a simple responsive project-card grid with photo,
  category badge, title, 1–5 rating badge, and favorite control, without filter
  bars or social engagement controls.
- The add-project modal supports required photo URL/upload and title, category,
  yarn, optional pattern link, hook/needle size, interactive rating, notes,
  and Public/Private toggle.
- Project details open in a split modal: image on the left and scrollable
  details on the right, stacking on mobile. Show title, creator avatar/name/
  location, rating, yarn, optional pattern link, and notes.
- Profiles show avatar/initials, full name, location, bio, “Stitches Logged”
  count, and My Projects/Saved Favorites tabs with responsive grids.
- A weather API integration may be considered later as an optional cozy
  feature, but it is not part of the core implementation unless requested.
 
## Technology stack
- Frontend: HTML, CSS, JavaScript, jQuery, Bootstrap 5, single-page application (SPA)
- Backend: PHP with FlightPHP (REST API), PDO, MySQL
- Local server: XAMPP
 
## Folder structure
- frontend/: css/, js/, views/ (one HTML file per view), assets/
- backend/: routes/, services/, dao/, middleware/, config/, logs/
- docs/: AI_LOG.md and other documentation
 
## Frontend rules
- Each view is in its own file in frontend/views/.
- Use Bootstrap 5 classes; avoid inline styles.
- All frontend development must be fully responsive across all screen sizes (mobile, tablet, laptop, and desktop) using modern responsive layout techniques.
 
## Backend rules
- Requests go: route -> service -> DAO -> database.
- Only services call DAO classes. Routes never call DAO classes directly.
- All SQL uses PDO prepared statements.
- Routes return JSON with correct HTTP status codes.
 
## Conventions
- PHP classes: PascalCase (UserService, UserDao). Files are named after the class.
- JavaScript and PHP variables: camelCase. Database tables and columns: snake_case.
 
## Rules for AI assistants
- Do not add new libraries or frameworks without asking me first.
- Do not change the database schema without asking me first.
- Never put passwords, keys or secrets in code; they belong in backend/config/config.php,
  which is not committed. Update config.example.php instead.
- Do not edit files in backend/logs/.
- Make small changes and explain what you changed and why.
