
const btnMore = document.querySelector('#btn-font-more');
const btnLess = document.querySelector('#btn-font-less');
const btnreset = document.querySelector('#btn-font-reset');


let fontSize = parseInt(localStorage.getItem("fontSize")) || 16;
// Fonction pour modifier la taille
if (localStorage.getItem("fontSize")) {
    document.body.style.fontSize = localStorage.getItem("fontSize") + "px";
    document.querySelectorAll("button").forEach(button => {
        button.style.fontSize = localStorage.getItem("fontSize") + "px";
    });
}
function changeFontSize(change) {
    fontSize += change;
    document.body.style.fontSize = fontSize + "px";
    // augmenter la taille de la police du corps
    document.querySelectorAll("button").forEach(button => {
        button.style.fontSize = fontSize + "px";
        // augmenter la taille de la police des boutons
    });
    localStorage.setItem("fontSize", fontSize);
    // sauvegarder la taille de la police dans le localStorage
}

// Événements des boutons
btnMore.addEventListener('click', () => {
    changeFontSize(1)
});
btnLess.addEventListener('click', () => {
    changeFontSize(-1)
});
btnreset.addEventListener('click', () => {
    changeFontSize(16 - fontSize); // reset
});

