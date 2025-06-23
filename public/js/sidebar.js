//* MULTIPLE DROPDOWNS IN SIDEBAR
document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll(".dropdown-menu .dropend")
        .forEach(function (element) {
            element.addEventListener("click", function (e) {
                e.stopPropagation();
            });
        });
});
