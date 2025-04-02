const admin_user = document.querySelector('#admin_user');
const admin_note = document.querySelector('#admin_note');

document.querySelector('#admin_btn_user').addEventListener('click', () => {
    console.log('favori');

    admin_user.style.display = "flex";
    admin_note.style.display = "none";
});

document.querySelector('#admin_btn_note').addEventListener('click', () => {
    console.log('favori');

    admin_user.style.display = "none";
    admin_note.style.display = "flex";
});




function search(input, table) {
    document.getElementById(input).addEventListener('input', (e) => {
        const researchValue = e.target.value.toLowerCase();
        for (const row of document.getElementById(table).getElementsByTagName('tr')) {
            const name = row.getAttribute('data-name') || '';
            const email = row.getAttribute('data-email') || '';

            if (name.includes(researchValue) || email.includes(researchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

