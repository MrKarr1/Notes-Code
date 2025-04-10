

const body = document.body;
// Récupère le body de la page
const btn_light_mode = document.querySelector("#btn-light-mode");
// Récupère le bouton de changement de thème

if (localStorage.getItem("theme") === "light") {
    // Vérifie si le thème est déjà défini dans le localStorage
    body.classList.add("light")
    // Ajoute la classe light au body
    btn_light_mode.innerHTML = '<i class="fa-solid fa-moon"></i>'
    // Change l'icône du bouton
}

btn_light_mode.addEventListener("click", () => {
    // Ajoute un écouteur d'événement sur le bouton
    // Au clic, on change le thème
    body.classList.toggle("light");
    // On inverse la classe light du body
    localStorage.setItem("theme", body.classList.contains("light") ? "light" : "dark");
    // On sauvegarde le thème dans le localStorage avec opérateur ternaire
    // Si le body a la classe light, on sauvegarde "light" sinon "dark"
    if (btn_light_mode.innerHTML.includes('<i class="fa-solid fa-moon"></i>')) {
        // Si le bouton contient l'icône de la lune, on change l'icône
        // On change l'icône du bouton pour le soleil
        btn_light_mode.innerHTML = '<i class="fa-solid fa-sun"></i>';
    } else {
        btn_light_mode.innerHTML = '<i class="fa-solid fa-moon"></i>';
        // Sinon on change l'icône du bouton pour la lune
    }
    toggleThemeMonaco();
    // on appelle la fonction pour changer le thème de monaco editor
});
