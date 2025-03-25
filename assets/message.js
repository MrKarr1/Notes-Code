document.addEventListener("DOMContentLoaded", function() {
    const messageContainer = document.querySelector("#message-container");
    const messageContent = document.querySelector("#message-content");
    const closeButton = document.querySelector("#close-message");

    document.querySelectorAll(".btn-message").forEach(button => {
        button.addEventListener("click", function() {
            let message = this.getAttribute("data-message"); // Récupère le message
            messageContent.textContent = message; // Insère le message dans la div
            messageContainer.classList.remove("message"); // Affiche la div
        });
    });

    // Cacher le message quand on clique sur "Fermer"
    closeButton.addEventListener("click", function() {
        messageContainer.classList.add("message");
    });
});