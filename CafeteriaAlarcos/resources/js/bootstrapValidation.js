window.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("main .needs-validation");

    Array.from(forms).forEach((form) => {
        form.addEventListener("submit", (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                const formInputs = form.querySelectorAll("input");
                formInputs.forEach((input) => {
                    let inputError = document.getElementById(
                        `${input.id}-error`
                    );

                    if (!inputError) {
                        inputError = document.createElement("div");
                        inputError.id = `${input.id}-error`;
                        inputError.className = "invalid-feedback";
                        input.insertAdjacentElement("afterend", inputError);
                    }

                    inputError.textContent = input.validationMessage;
                });
            }

            form.classList.add("was-validated");
        });
    });
});
