
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
    document.querySelectorAll("button").forEach(button => {
        button.style.fontSize = fontSize + "px";
    });
    localStorage.setItem("fontSize", fontSize);
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

