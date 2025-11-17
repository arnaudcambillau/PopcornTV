
// DARK MODE - S'exécute immédiatement

(function() {
    const toggleBtn = document.querySelector("#themeToggle") || document.querySelector(".theme-toggle");

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
})();


// TOGGLE MOT DE PASSE - Attend le chargement

window.addEventListener('load', function() {
    
    // Fonction générique pour toggle le mot de passe
    function togglePassword(inputId, labelId, checkboxId) {
        const input = document.getElementById(inputId);
        const label = document.getElementById(labelId);
        const checkbox = document.getElementById(checkboxId);

        if (!input || !label || !checkbox) return;

        input.type = checkbox.checked ? "text" : "password";

        const fillColor = "#8E8E93";

        if (checkbox.checked) {
            // Œil barré
            label.innerHTML =
                '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.6; transition: opacity 0.3s;"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z" fill="' + fillColor + '"/></svg>';
        } else {
            // Œil ouvert
            label.innerHTML =
                '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.6; transition: opacity 0.3s;"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="' + fillColor + '"/></svg>';
        }
    }

    // Fonctions spécifiques accessibles globalement
    window.togglePasswordIcon = function() {
        togglePassword('pwd', 'eyeLabel', 'togglePwd');
    };

    window.toggleConfirmPasswordIcon = function() {
        togglePassword('confirmPwd', 'eyeConfirmLabel', 'toggleConfirmPwd');
    };

    // Configuration des effets pour chaque champ
    function setupPasswordField(inputId, labelId) {
        const label = document.getElementById(labelId);
        const input = document.getElementById(inputId);

        if (!label || !input) return;

        // Effet hover
        label.addEventListener("mouseenter", function () {
            const svg = this.querySelector("svg");
            if (svg) svg.style.opacity = "1";
        });
        label.addEventListener("mouseleave", function () {
            const svg = this.querySelector("svg");
            if (svg) svg.style.opacity = "0.6";
        });

        // Changement de couleur au focus
        input.addEventListener("focus", function () {
            const path = document.querySelector("#" + labelId + " svg path");
            if (path) path.setAttribute("fill", "#E63946");
        });
        input.addEventListener("blur", function () {
            const path = document.querySelector("#" + labelId + " svg path");
            if (path) path.setAttribute("fill", "#8E8E93");
        });
    }

    // Initialiser les champs de mot de passe s'ils existent
    setupPasswordField('pwd', 'eyeLabel');
    setupPasswordField('confirmPwd', 'eyeConfirmLabel');
});