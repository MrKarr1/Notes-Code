

const body = document.body;
const btn_light_mode = document.querySelector("#btn-ligth-mode");

if (localStorage.getItem("theme") === "light") {
    body.classList.add("light")
    btn_light_mode.innerHTML = '<i class="fa-solid fa-moon"></i>'
}

btn_light_mode.addEventListener("click", () => {
    body.classList.toggle("light");
    localStorage.setItem("theme", body.classList.contains("light") ? "light" : "dark");
    if (btn_light_mode.innerHTML.includes('<i class="fa-solid fa-moon"></i>')) {
        btn_light_mode.innerHTML = '<i class="fa-solid fa-sun"></i>';
    } else {
        btn_light_mode.innerHTML = '<i class="fa-solid fa-moon"></i>';
    }
    toggleThemeMonaco();
});
