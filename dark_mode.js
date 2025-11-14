// dark mode

const toggleBtn =
  document.querySelector("#themeToggle") ||
  document.querySelector(".theme-toggle");

if (toggleBtn) {
  const html = document.documentElement;
  let theme = localStorage.getItem("theme");
  if (!theme) theme = "light";

  html.setAttribute("data-theme", theme);
  if (theme === "dark") {
    toggleBtn.textContent = "light_mode";
  } else {
    toggleBtn.textContent = "dark_mode";
  }

  toggleBtn.addEventListener("click", () => {
    if (theme === "dark") {
      theme = "light";
      toggleBtn.textContent = "dark_mode";
    } else {
      theme = "dark";
      toggleBtn.textContent = "light_mode";
    }
    html.setAttribute("data-theme", theme);
    localStorage.setItem("theme", theme);
  });
}
