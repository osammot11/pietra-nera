function openMenu() {
    document.getElementById("sideMenu").style.width = "350px";
}

function closeMenu() {
    document.getElementById("sideMenu").style.width = "0";
}

const navbar = document.querySelector(".navbar");

/*
|--------------------------------------------------------------------------
| Scroll threshold dinamica
|--------------------------------------------------------------------------
|
| Se la pagina ha la topbar:
| - aspetta 50px
|
| Se NON ha la topbar:
| - navbar fixed quasi subito
|
*/

const hasTopbar = document.body.classList.contains("has-topbar");

const scrollThreshold = hasTopbar ? 50 : 5;

window.addEventListener("scroll", function () {

    if (window.scrollY > scrollThreshold) {
        navbar.classList.add("navbar-scrolled");
    } else {
        navbar.classList.remove("navbar-scrolled");
    }

});