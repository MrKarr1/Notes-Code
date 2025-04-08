////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// gere l'affichage de la navigation
const nav_menu = document.querySelector('.nav_menu');
document.querySelector('#btn-nav-block').addEventListener('click', () => {
    // console.log("click");
    nav_menu.style.display = "block";
    
});

document.querySelector('#btn-nav-none').addEventListener('click', () => {
    // console.log("click");
    nav_menu.style.display = "none";
});