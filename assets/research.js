
function search(input, table) {
    document.getElementById(input).addEventListener('input', (e) => {
        const researchValue = e.target.value.toLowerCase();
        for (const row of document.getElementById(table).getElementsByTagName('tr')) {
            const name = row.getAttribute('data-name') || '';
            const description = row.getAttribute('data-description') || '';
            const tag = row.getAttribute('data-tag') || '';
            const folder = row.getAttribute('data-folder') || '';
            const langage = row.getAttribute('data-langage') || '';

            if (name.includes(researchValue) || tag.includes(researchValue) || folder.includes(researchValue) || description.includes(researchValue) || langage.includes(researchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

