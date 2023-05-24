

function Nologout(event) {
    const modal = document.querySelector("#modal-logout");
    modal.classList.add("hidden");
    document.body.classList.remove("no-scroll");
}

function Logout(event) {
    window.location = "logout.php";
}

function logoutQuestion(event) {
    event.stopPropagation();
    event.preventDefault();
    document.body.classList.add("no-scroll");
    const modal = document.querySelector("#modal-logout");
    modal.style.top = window.pageYOffset + "px";
    document.querySelector("#No").addEventListener('click', Nologout);
    document.querySelector("#Yep").addEventListener('click', Logout);
    modal.classList.remove("hidden");
}

function openLateralbar(){
    const searchbar = document.querySelector("#lateral_bar");
    searchbar.classList.toggle("hidden");
    menu.textContent=menu.textContent==="menu"?"close":"menu";
}

const menu = document.querySelector("#menu");
menu.addEventListener("click", openLateralbar);

const logout = document.querySelectorAll(".logout");
for(l of logout){
    l.addEventListener('click', logoutQuestion);
}