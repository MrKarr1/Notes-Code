require.config({
    paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.52.2/min/vs'
    }
});

require(['vs/editor/editor.main'], function () {
    const noteCode = document.querySelector('#note-code').textContent;
    const noteLanguage = document.querySelector('#note-language').textContent;

    monaco.editor.create(document.querySelector('#editor'), {
        value: noteCode,
        language: noteLanguage,
        theme: 'vs-dark', // Thème sombre
        readOnly: true // Désactive l'édition
    });
});