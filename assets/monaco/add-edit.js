
require.config({
    paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.52.2/min/vs'
    }
});
const note_Code = document.querySelector('#note-code').textContent;
const note_Language = document.querySelector('#note-language').textContent;
// const note_id = document.querySelector('#monaco-editor').textContent;

require(['vs/editor/editor.main'], function () {
    monaco.editor.create(('note_id'), {
        value: note_Code,
        language: note_Language,
        theme: 'vs-dark',
        readOnly: false,
    });
});