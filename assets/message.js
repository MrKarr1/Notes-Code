document.addEventListener("DOMContentLoaded", function () {
    const messageContainer = document.querySelector("#message-container");
    const messageContent = document.querySelector("#message-content");


    document.querySelectorAll(".btn-message").forEach(button => {
        // Ajoute un écouteur d'événement sur chaque bouton
        button.addEventListener("click", function () {
            if (messageContainer.classList.contains("message-hidden")) {
                // si la div est cachée on l'affiche avec le message
                let message = this.getAttribute("data-message"); // Récupère le message
                messageContent.textContent = message; // Insère le message dans la div
                messageContainer.classList.remove("message-hidden"); // Affiche la div
                this.innerText = 'Fermer';
                this.classList.add("btnremove")
            } else {
                //sinon on la cache
                messageContainer.classList.add("message-hidden");
                this.innerText = 'Voir le message';
                this.classList.toggle("btnremove");
            }
        });
    });

    // Cacher le message quand on clique sur "Fermer"
    document.querySelector('#close-message').addEventListener('click', () => {
        messageContainer.classList.add("message-hidden");
        document.querySelector(".btnremove").innerText = 'Voir le message';
        document.querySelector(".btnremove").classList.toggle("btnremove");

    });
});