
if (localStorage.getItem("fontSize")) {
    document.body.style.fontSize = localStorage.getItem("fontSize") + "px";
}


const btnMore = document.querySelector('#btn-font-more');
const btnLess = document.querySelector('#btn-font-less');


let fontSize = parseInt(localStorage.getItem("fontSize")) || 16; // 16px par défaut

// Fonction pour modifier la taille
function changeFontSize(change) {
    fontSize += change;
    document.body.style.fontSize = fontSize + "px";
    localStorage.setItem("fontSize", fontSize); // Sauvegarde dans localStorage
}

// Événements des boutons
btnMore.addEventListener('click', () => changeFontSize(10));
btnLess.addEventListener('click', () => changeFontSize(-10));
