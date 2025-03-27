
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// gere l'affichage des notes dans le menu de navigation
const div_favori = document.querySelector('#div_favori');
const div_note = document.querySelector('#div_note');


document.querySelector('#favori').addEventListener('click', () => {
    div_favori.style.display = "flex";
    div_note.style.display = "none";
});

document.querySelector('#note').addEventListener('click', () => {
    div_favori.style.display = "none";
    div_note.style.display = "flex";
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

            if (name.includes(researchValue) || tag.includes(researchValue) || description.includes(researchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

