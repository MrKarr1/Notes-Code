
const div_favori = document.querySelector('#div_favori');
const div_dossier = document.querySelector('#div_dossier');
const div_note = document.querySelector('#div_note');

document.querySelector('#favori').addEventListener('click', () => {
    div_favori.style.display = "block";
    div_dossier.style.display = "none";
    div_note.style.display = "none";
});

document.querySelector('#dossier').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_dossier.style.display = "block";
    div_note.style.display = "none";
});

document.querySelector('#note').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_dossier.style.display = "none";
    div_note.style.display = "block";
});