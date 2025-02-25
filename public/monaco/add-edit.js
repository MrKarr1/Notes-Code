
require.config({
    paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.52.2/min/vs'
    }
});
const noteCode = document.querySelector('#note-code').textContent;
const noteLanguage = document.querySelector('#note-language').textContent;
const noteid = document.querySelector('#note-id').textContent;

require(['vs/editor/editor.main'], function () { // Cibler l'ID généré dynamiquement par Symfony
    monaco.editor.create(('noteid'), {
        value: noteCode, // Valeur initiale
        language: noteLanguage, // Langage par défaut (tu peux le personnaliser)
        theme: 'vs-dark', // Thème sombre
        readOnly: false // Permet la modification
    });
});