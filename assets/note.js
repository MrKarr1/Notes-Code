
const div_favori = document.querySelector('#div_favori');
const div_folder = document.querySelector('#div_folder');
const div_note = document.querySelector('#div_note');
const div_langage = document.querySelector('#div-langage');

document.querySelector('#favori').addEventListener('click', () => {
    div_favori.style.display = "flex";
    div_folder.style.display = "none";
    div_note.style.display = "none";
    div_langage.style.display = "none";
});

document.querySelector('#folder').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_folder.style.display = "flex";
    div_note.style.display = "none";
    div_langage.style.display = "none";
});

document.querySelector('#note').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_folder.style.display = "none";
    div_note.style.display = "flex";
    div_langage.style.display = "none";
});
document.querySelector('#langage').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_folder.style.display = "none";
    div_note.style.display = "none";
    div_langage.style.display = "flex";
});