document.addEventListener("DOMContentLoaded", () => {
  const authCard = document.getElementById("authCard");
  const switchButtons = document.querySelectorAll("[data-mode]");
  const registerForm = document.getElementById("registerForm");
  const loginForm = document.getElementById("loginForm");

  if (!authCard) return;

  function getMode() {
    return authCard.classList.contains("register-mode") ? "register" : "login";
  }

  function getBaseHeight(mode) {
    if (window.innerWidth <= 680) {
      return mode === "register" ? 730 : 690;
    }

    if (window.innerWidth <= 820) {
      return mode === "register" ? 470 : 430;
    }

    return mode === "register" ? 495 : 455;
  }

  function getActiveView(mode = getMode()) {
    return authCard.querySelector(
      mode === "register" ? ".form-register" : ".form-login"
    );
  }

  function getRequiredHeight(view) {
    if (!view) return 0;

    const viewStyle = window.getComputedStyle(view);
    const paddingTop = parseFloat(viewStyle.paddingTop) || 0;
    const paddingBottom = parseFloat(viewStyle.paddingBottom) || 0;

    let maxBottom = 0;

    Array.from(view.children).forEach((child) => {
      const style = window.getComputedStyle(child);

      if (style.display === "none" || style.visibility === "hidden") return;

      const marginTop = parseFloat(style.marginTop) || 0;
      const marginBottom = parseFloat(style.marginBottom) || 0;

      const childBottom =
        child.offsetTop + child.offsetHeight + marginBottom + marginTop;

      if (childBottom > maxBottom) {
        maxBottom = childBottom;
      }
    });

    return Math.ceil(maxBottom + paddingBottom);
  }

  function adjustCardHeight(mode = getMode()) {
    const activeView = getActiveView(mode);
    if (!activeView) return;

    const baseHeight = getBaseHeight(mode);

    authCard.style.height = `${baseHeight}px`;

    requestAnimationFrame(() => {
      const requiredHeight = getRequiredHeight(activeView);
      const finalHeight = Math.max(baseHeight, requiredHeight + 10);
      authCard.style.height = `${finalHeight}px`;
    });
  }

  function setMode(mode, save = true) {
    if (mode === "register") {
      authCard.classList.remove("login-mode");
      authCard.classList.add("register-mode");
      if (save) localStorage.setItem("auth_mode", "register");
    } else {
      authCard.classList.remove("register-mode");
      authCard.classList.add("login-mode");
      if (save) localStorage.setItem("auth_mode", "login");
    }

    adjustCardHeight(mode);
  }

  const forcedMode = authCard.dataset.initialMode;
  const savedMode = localStorage.getItem("auth_mode");

  if (forcedMode === "login" || forcedMode === "register") {
    setMode(forcedMode, false);
  } else if (savedMode === "login" || savedMode === "register") {
    setMode(savedMode, false);
  } else {
    setMode("login", false);
  }

  switchButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const mode = button.getAttribute("data-mode");
      if (mode === "login" || mode === "register") {
        setMode(mode);
      }
    });
  });

  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      const name = document.getElementById("registerName")?.value.trim();
      const email = document.getElementById("registerEmail")?.value.trim();
      const password = document.getElementById("registerPassword")?.value.trim();

      if (!name || !email || !password) {
        e.preventDefault();
        alert("Veuillez remplir tous les champs.");
        return;
      }

      if (password.length < 8) {
        e.preventDefault();
        alert("Le mot de passe doit contenir au moins 8 caractères.");
        return;
      }
    });
  }

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      const email = document.getElementById("loginEmail")?.value.trim();
      const password = document.getElementById("loginPassword")?.value.trim();

      if (!email || !password) {
        e.preventDefault();
        alert("Veuillez remplir tous les champs.");
        return;
      }
    });
  }

  window.addEventListener("resize", () => {
    adjustCardHeight();
  });

  window.addEventListener("load", () => {
    adjustCardHeight();
  });

  setTimeout(() => {
    adjustCardHeight();
  }, 100);

  setTimeout(() => {
    adjustCardHeight();
  }, 300);
});