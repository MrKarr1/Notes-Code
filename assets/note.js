////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// gere l'affichage du menu de navigation
const nav_menu = document.querySelector('.nav_menu');
document.querySelector('#btn-nav-block').addEventListener('click', () => {
    nav_menu.style.display = "block";
});
document.querySelector('#btn-nav-none').addEventListener('click', () => {
    nav_menu.style.display = "none";
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// gere l'affichage des notes dans le menu de navigation
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


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// gere les donnne pour manoco-editor
function search(input, table) {
    document.getElementById(input).addEventListener('input', (e) => {
        const researchValue = e.target.value.toLowerCase();
        for (const row of document.getElementById(table).getElementsByTagName('tr')) {
            const name = row.getAttribute('data-name') || '';
            const description = row.getAttribute('data-description') || '';
            const tag = row.getAttribute('data-tag') || '';
            const folder = row.getAttribute('data-folder') || '';

            if (name.includes(researchValue) || tag.includes(researchValue) || folder.includes(researchValue) || description.includes(researchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

