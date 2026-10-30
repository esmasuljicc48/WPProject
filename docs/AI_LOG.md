# AI Log

## Milestone 1

### Tools and tasks
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Build only the Looply frontend main page/feed for Milestone 1; do not create backend or database.
- **Main prompt:** “Build only the Looply frontend main page/feed for Milestone 1; do not create backend or database.”
- **What was generated:** A standalone responsive Looply feed in
  [frontend/index.html](../frontend/index.html), with styling in
  [frontend/css/main.css](../frontend/css/main.css) and local mock-data,
  search, and favorite interactions in [frontend/js/main.js](../frontend/js/main.js).
- **What was kept, changed, or rejected:** Kept the frontend-only scope, Looply
  palette, typography, responsive feed, public project cards, search, and
  presentational favorites. No backend, database, schema, or weather API was
  created. This is an initial slice of Milestone 1; the milestone is not
  considered complete yet.

### Where the AI was wrong
- No errors were identified in this task. The current implementation is only
  the accepted first slice of Milestone 1, not the full milestone.

### Tools and tasks — palette pass
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Update the Looply frontend palette and hero copy: use `#CBC3B4` as
  the background, include more blue, Soft Butter, and `#FFF4AA`, make the top
  navigation visually distinct, remove the blue circle, and change the
  heading to “A space for making things.”
- **Main prompt:** “I want `#FFF4AA` color to be included somewhere too and I
  don’t want the background to have that blue circle in the right corner side.
  I don’t want ‘A little space for making things.’ but ‘A space for making
  things.’”
- **What was generated:** Updated [frontend/index.html](../frontend/index.html)
  and [frontend/css/main.css](../frontend/css/main.css) with the revised hero
  copy, `#FFF4AA` accents, and a cleaner hero background.
- **What was kept, changed, or rejected:** Kept the existing frontend-only
  feed and previous palette adjustments. Added `#FFF4AA` to the logo, hero
  note, and rating badges; removed the blue hero circle; and changed the hero
  heading. No backend or database work was added.

### Where the AI was wrong — palette pass
- No errors were identified in this task.

### Tools and tasks — project borders
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Use the brown-beige palette shades as borders around the project cards.
- **Main prompt:** “I want the border around the projects to be some of the
  brown beige shades I sent you.”
- **What was generated:** Updated [frontend/css/main.css](../frontend/css/main.css)
  to add a Dune Sand outer card border, Driftwood divider, and explicit rounded
  image/body corners.
- **What was kept, changed, or rejected:** Kept the existing card layout and
  responsive behavior. Added brown-beige card borders and then refined the
  image/card junction after noticing the image container and divider looked
  too square. No backend or database work was added.

### Where the AI was wrong — project borders
- The first border pass did not make the image area and internal divider
  visually rounded enough. This was noticed in the browser preview and
  corrected by adding explicit top rounding to the image area and bottom
  rounding to the card body.

### Tools and tasks — footer and copy
- **Tool/model:** Copilot
- **Task:** Adding the footer and changing some text.
- **Main prompt:** “No separate main prompt provided.”
- **What was generated:** A cozy footer with the requested sign-off,
  responsive bottom line, and smooth Back to top link; updated the welcome
  copy.
- **What was kept, changed, or rejected:** The student kept the footer
  implementation and changed the text.

### Where the AI was wrong — footer and copy
- No errors were identified in this task.

### Tools and tasks — authentication pages
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Implement static Looply login and registration pages and plan the database tables.
- **Main prompt:** “Implement the login and registration pages. They should be the first thing that pops up when I open my app. The login button should take me to the main landing page so the login and registration pages serve no function; they just need to exist for now. Suggest what database tables I should have, their attributes, and relationships.”
- **What was generated:** Static login and registration SPA views, default login routing, a login-to-landing-page transition, and registration-page navigation.
- **What was kept, changed, or rejected:** The student kept the pages as non-functional static views for Milestone 1 and kept the existing landing page as the post-login destination. No backend authentication or database schema was changed.

### Where the AI was wrong — authentication pages
- No errors yet.

### Tools and tasks — optional profile metadata and project privacy
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Make profile location optional and add a Public/Private control to the new-project view.
- **Main prompt:** “Make the profile location optional. Keep the blue sparkle symbol regardless of whether a location or another profile detail is present. Add a button when creating a new project asking whether the project is private or public.”
- **What was generated:** A standalone profile metadata sparkle marker with an optional location value, a Public/Private radio control in the new-project form, styling for the control, and inclusion of the selected privacy value in the temporary project object.
- **What was kept, changed, or rejected:** Kept the existing Looply profile layout and static location text for the current mock profile; changed the sparkle from a CSS location prefix into its own element; added the privacy control without implementing backend persistence.

### Where the AI was wrong — optional profile metadata and project privacy
- No errors yet.

### Tools and tasks — README and AI-error documentation
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Update the Milestone 1 README and document two AI mistakes.
- **Main prompt:** “Update the README.md file also for the AI log log the two mistakes zou made, as you used sections instead of pages for spapp implementation, and second thing you made the location required in draft of the database when i asked you differently.”
- **What was generated:** A README draft covering the project, entities and relationships, roles, planned API, local setup, SPA views, and pending documentation links; an AI-log entry documenting the two mistakes.
- **What was kept, changed, or rejected:** The student kept the README documentation and the two mistake records. The ERD was not created in this task.

### Where the AI was wrong — README and AI-error documentation
- **Mistake 1:** The first SPA implementation used multiple sections inside `index.html` instead of separate HTML view files. This was noticed by comparing the implementation with the project’s view-template requirement. It was fixed by moving the page templates into `frontend/views/` and updating the router to load them.
- **Mistake 2:** The initial database draft did not reflect that profile location should be optional. This was noticed when reviewing the proposed users table against the requested profile behavior. It was corrected by documenting location as optional/nullable in the database plan and README.

### Tools and tasks — draft ERD image
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Create the Looply draft ERD image from the planned database design.
- **Main prompt:** “Create the ERD image as you described me the db before.”
- **What was generated:** An editable SVG ERD in `docs/looply-erd.svg` showing users, categories, projects, reviews, and favorites with their columns, keys, optional profile location, and relationships.
- **What was kept, changed, or rejected:** The student kept the SVG ERD and its README links. No SQL schema was created or changed.

### Where the AI was wrong — draft ERD image
- No errors yet.

### Tools and tasks — ERD field and relationship layout
- **Tool/model:** VS Code Copilot SDK / GPT-5.6 Luna
- **Task:** Revise the Looply draft ERD so every attribute is displayed as a normal field and relationship connectors are clearer.
- **Main prompt:** “Add them as rest of the normal fields like rest of the fields and not like that and also make the conection lines arrows and what kind of relationships they are not this messy.”
- **What was generated:** An updated SVG ERD with all attributes inside the users, categories, projects, reviews, and favorites tables, plus labeled orthogonal arrow connectors.
- **What was kept, changed, or rejected:** The student kept the revised SVG layout and relationship labels. The database design itself was not changed.

### Where the AI was wrong — ERD field and relationship layout
- No errors yet.

## Milestone 2

### Tools and tasks
- **Tool/model:** GitHub Copilot in VS Code
- **Task:** Implement the BaseDao and one DAO for every database table using the uploaded Lab 3/tutorial and the linked GitHub examples; create CRUD only for now.
- **Main prompt:** “Using the github link repository and document i uploaded to you (lab3) create the BaseDao aswell as DAO file for every table. The syntax should follow the examples on git and lab file. Create only CRUD for now and later we might implement custom queires depending on our needs.”
- **What was generated:** [backend/dao/BaseDao.php](../backend/dao/BaseDao.php), the five entity DAOs, database configuration files, a DAO smoke test, and README setup instructions.
- **What was kept, changed, or rejected:** I rejceted everything because he did not follow the syntax we learned in class. 

### Where the AI was wrong
-First mistake is making completely diffrent code from what I asked him.
-Second mistake is that he did not tell me that he could not acess a github repositry until I asked him if he can do that.