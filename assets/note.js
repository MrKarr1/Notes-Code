
const div_favori = document.querySelector('#div_favori');
const div_dossier = document.querySelector('#div_dossier');
const div_note = document.querySelector('#div_note');
const div_langage = document.querySelector('#div-langage');

document.querySelector('#favori').addEventListener('click', () => {
    div_favori.style.display = "flex";
    div_dossier.style.display = "none";
    div_note.style.display = "none";
    div_langage.style.display = "none";
});

document.querySelector('#dossier').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_dossier.style.display = "flex";
    div_note.style.display = "none";
    div_langage.style.display = "none";
});

document.querySelector('#note').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_dossier.style.display = "none";
    div_note.style.display = "flex";
    div_langage.style.display = "none";
});
document.querySelector('#langage').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_dossier.style.display = "none";
    div_note.style.display = "none";
    div_langage.style.display = "flex";
});