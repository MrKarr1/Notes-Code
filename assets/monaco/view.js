require.config({
    paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.52.2/min/vs'
    }
});
const theme_monaco_light = 'vs';
const theme_monaco_dark = 'vs-dark';
let theme_monaco = theme_monaco_dark;


require(['vs/editor/editor.main'], function () {
    toggleThemeMonaco();
    const noteCode = document.querySelector('#note-code').textContent;
    const noteLanguage = document.querySelector('#note-language').textContent;

    monaco.editor.create(document.querySelector('#monaco-editor'), {
        value: noteCode,
        language: noteLanguage,
        readOnly: true, // Désactive l'édition
        theme: theme_monaco  // Thème sombre
    });
});

function toggleThemeMonaco() {
    if (localStorage.getItem("theme") === "light") {
        theme_monaco = theme_monaco_light;
    } else {
        theme_monaco = theme_monaco_dark;
    }
    monaco.editor.setTheme(theme_monaco);
}