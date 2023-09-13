window.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("#content .needs-validation");

    Array.from(forms).forEach((form) => {
        form.addEventListener("submit", (event) => {
            if (!form.checkValidity()) {
                form.reportValidity();
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add("was-validated");
        });
    });
});
