const projects = [
  {
    title: "Sunday Morning Cardigan",
    category: "Knitting",
    rating: "5/5",
    maker: "Mina K.",
    initials: "MK",
    date: "2 hours ago",
    image: "https://images.unsplash.com/photo-1610701596007-11502861dcfa?auto=format&fit=crop&w=900&q=85"
  },
  {
    title: "The Softest Little Beanie",
    category: "Crochet",
    rating: "4/5",
    maker: "Esma S.",
    initials: "AS",
    date: "Yesterday",
    image: "https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=900&q=85"
  },
  {
    title: "Blue Hour Scarf",
    category: "Knitting",
    rating: "5/5",
    maker: "Lea M.",
    initials: "LM",
    date: "2 days ago",
    image: "https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=900&q=85"
  },
  {
    title: "A Basket for Everything",
    category: "Crochet",
    rating: "4/5",
    maker: "Nora P.",
    initials: "NP",
    date: "3 days ago",
    image: "https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=900&q=85"
  },
  {
    title: "Wildflower Table Runner",
    category: "Embroidery",
    rating: "5/5",
    maker: "Sara J.",
    initials: "SJ",
    date: "4 days ago",
    image: "https://images.unsplash.com/photo-1604881988758-f76ad2f7aac1?auto=format&fit=crop&w=900&q=85"
  },
  {
    title: "A Very Good Everyday Tote",
    category: "Sewing",
    rating: "5/5",
    maker: "Ena R.",
    initials: "ER",
    date: "5 days ago",
    image: "https://images.unsplash.com/photo-1594223274512-ad4803739b7c?auto=format&fit=crop&w=900&q=85"
  }
];

const app = $.spapp({ defaultView: "view_login", pageNotFound: "view_login" });
let selectedProject = projects[0];
const savedProjects = new Set();

function setAuthScreen(isAuthScreen) {
  document.body.classList.toggle("auth-screen", isAuthScreen);
}

function renderProjects(items, target = document.querySelector("#projectGrid")) {
  const template = document.querySelector("#projectCardTemplate");
  if (!target || !template) return;
  target.innerHTML = "";
  if (target.id === "projectGrid") {
    const projectCount = document.querySelector("#projectCount");
    const emptyState = document.querySelector("#emptyState");
    projectCount.textContent = items.length;
    emptyState.classList.toggle("d-none", items.length > 0);
    target.classList.toggle("d-none", items.length === 0);
  }

  items.forEach((project) => {
    const card = template.content.cloneNode(true);
    const image = card.querySelector(".project-image");
    image.src = project.image;
    image.alt = `${project.title}, a ${project.category.toLowerCase()} project`;
    card.querySelector(".craft-badge").textContent = project.category;
    card.querySelector(".rating").textContent = project.rating;
    card.querySelector(".project-title").textContent = project.title;
    card.querySelector(".maker-name").textContent = project.maker;
    card.querySelector(".maker-avatar").textContent = project.initials;
    card.querySelector(".project-date").textContent = project.date;
    const favoriteButton = card.querySelector("[data-favorite]");
    favoriteButton.classList.toggle("is-saved", savedProjects.has(project.title));
    favoriteButton.setAttribute("aria-label", savedProjects.has(project.title) ? "Remove project from saved favorites" : "Save project");
    favoriteButton.addEventListener("click", (event) => {
      event.stopPropagation();
      const button = event.currentTarget;
      const saved = button.classList.toggle("is-saved");
      if (saved) {
        savedProjects.add(project.title);
      } else {
        savedProjects.delete(project.title);
      }
      button.setAttribute("aria-label", saved ? "Remove project from saved favorites" : "Save project");
      renderProjects([...savedProjects].map((title) => projects.find((item) => item.title === title)).filter(Boolean), document.querySelector("#favoritesProjectGrid"));
    });
    card.querySelector(".project-card").addEventListener("click", () => {
      selectedProject = project;
      window.location.hash = "view_project_details";
    });
    target.appendChild(card);
  });
}

function bindAuthForms() {
  const loginForm = document.querySelector("#loginForm");
  const registerForm = document.querySelector("#registerForm");
  if (loginForm) loginForm.addEventListener("submit", (event) => {
    event.preventDefault();
    window.location.hash = "view_home";
  });
  if (registerForm) registerForm.addEventListener("submit", (event) => {
    event.preventDefault();
    window.location.hash = "view_login";
  });
}

function bindSharedControls() {
  const backToTop = document.querySelector("[data-back-to-top]");
  if (backToTop) backToTop.addEventListener("click", (event) => {
    event.preventDefault();
    window.location.hash = "view_home";
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
}

app.route({
  view: "view_login",
  onReady: () => {
    setAuthScreen(true);
    bindAuthForms();
  }
});
app.route({
  view: "view_register",
  onReady: () => {
    setAuthScreen(true);
    bindAuthForms();
  }
});
app.route({
  view: "view_home",
  onReady: () => {
    setAuthScreen(false);
    const projectGrid = document.querySelector("#projectGrid");
    const projectCount = document.querySelector("#projectCount");
    const emptyState = document.querySelector("#emptyState");
    const searchInput = document.querySelector("#projectSearch");
    const query = searchInput.value.trim().toLowerCase();
    renderProjects(projects.filter((project) => project.title.toLowerCase().includes(query) || project.maker.toLowerCase().includes(query)), projectGrid);
    searchInput.addEventListener("input", (event) => {
      const searchQuery = event.target.value.trim().toLowerCase();
      renderProjects(projects.filter((project) => project.title.toLowerCase().includes(searchQuery) || project.maker.toLowerCase().includes(searchQuery)), projectGrid);
    });
    bindSharedControls();
  }
});
app.route({
  view: "view_project_details",
  onReady: () => {
    setAuthScreen(false);
    const project = selectedProject;
    document.querySelector("#projectDetails").innerHTML = `
      <a class="back-link" href="#view_home">← Back to all projects</a>
      <div class="detail-card">
        <img src="${project.image}" alt="${project.title}">
        <div class="detail-copy">
          <span class="craft-badge">${project.category}</span>
          <h1>${project.title}</h1>
          <p class="detail-maker">Made by ${project.maker}</p>
          <p class="detail-rating">★ ${project.rating}</p>
          <dl class="detail-list"><dt>Yarn used</dt><dd>Soft merino wool</dd><dt>Hook or needle size</dt><dd>4 mm</dd></dl>
          <p class="detail-note">I started this project on a slow Sunday morning when I wanted to make something warm and useful. The first few rows felt a little awkward, but the rhythm became easier once I stopped trying to make everything perfect. I love how the color is changing as I work, and I am looking forward to seeing how the finished piece feels after it has been washed and worn a few times.</p>
        </div>
      </div>`;
  }
});
app.route({
  view: "view_profile",
  onReady: (params) => {
    setAuthScreen(false);
    renderProjects(projects, document.querySelector("#profileProjectGrid"));
    console.log(`Showing profile for user ${params.get("user_id") || "current user"}`);
  }
});
app.route({
  view: "view_favorites",
  onReady: () => {
    setAuthScreen(false);
    renderProjects([...savedProjects].map((title) => projects.find((item) => item.title === title)).filter(Boolean), document.querySelector("#favoritesProjectGrid"));
  }
});
app.route({
  view: "view_new_project",
  onReady: () => {
    setAuthScreen(false);
    const form = document.querySelector("#newProjectForm");
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const formData = new FormData(form);
      const imageFile = formData.get("image");
      const newProject = {
        title: formData.get("title"),
        category: formData.get("category"),
        rating: `${formData.get("rating")}/5`,
        privacy: formData.get("privacy"),
        maker: "Esma S.",
        initials: "ES",
        date: "Just now",
        image: imageFile instanceof File && imageFile.size > 0 ? URL.createObjectURL(imageFile) : projects[0].image
      };
      projects.unshift(newProject);
      form.reset();
      selectedProject = newProject;
      window.location.hash = "view_project_details";
    });
    document.querySelector("#projectImage").addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (!file) return;
      const preview = document.querySelector("#photoPreview");
      preview.querySelector("span").textContent = "";
      preview.querySelector("img").src = URL.createObjectURL(file);
      preview.classList.add("has-photo");
    });
  }
});
app.run();
