document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".reader-login-required");

    links.forEach(link => {
        link.addEventListener("click", function () {
            sessionStorage.setItem("scrollPosition", window.scrollY);
        });
    });
});