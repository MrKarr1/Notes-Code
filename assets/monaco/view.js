require.config({
    paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.52.2/min/vs'
    }
});
// Configuration de requirejs pour charger le module monaco depuis le CDN
const theme_monaco_light = 'vs';
// constente pour le thème clair de monaco
const theme_monaco_dark = 'vs-dark';
// constente pour le thème sombre de monaco
let theme_monaco = theme_monaco_dark;
// thème par défaut de monaco


require(['vs/editor/editor.main'], function () {
    // requirejs pour charger le module monaco de puis le CDN de façon asynchrone
    toggleThemeMonaco();
    // lance la fonction theme
    const noteCode = document.querySelector('#note-code').textContent;
    //récupaire le code de la note
    const noteLanguage = document.querySelector('#note-language').textContent;
    //récupaire le language de la note

    monaco.editor.create(document.querySelector('#monaco-editor'), {
        value: noteCode,
        language: noteLanguage,
        readOnly: true, // Désactive l'édition
        theme: theme_monaco, // pour le thème
    });
    // créer l'éditeur monaco avec le code(noteCode) et le language(noteLanguage) de la note
});

function toggleThemeMonaco() {
    // Vérifie si le thème est déjà défini dans le localStorage
    if (localStorage.getItem("theme") === "light") {
        theme_monaco = theme_monaco_light;
    } else {
        theme_monaco = theme_monaco_dark;
    }
    monaco.editor.setTheme(theme_monaco);
    // Applique le thème monaco
}