document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-password").forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            let input = this.closest(".input-wrapper").querySelector("input");
            let icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("la-eye", "la-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("la-eye-slash", "la-eye");
            }
        });
    });
});
