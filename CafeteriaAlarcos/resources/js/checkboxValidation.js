window.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("#content .checkbox-validation");

    Array.from(forms).forEach((form) => {
        form.addEventListener("submit", (event) => {
            const checked = form.querySelectorAll(
                "input[type=checkbox]:checked"
            );
            const confirmModalElement = form.querySelector("#confirmModal");

            if (checked.length === 0) {
                event.preventDefault();
                event.stopPropagation();

                let inputError = form.querySelector("#checkbox-error");

                if (!inputError) {
                    const errorModalElement =
                        document.querySelector("#errorModal");

                    if (errorModalElement) {
                        const errorModalBody =
                            errorModalElement.querySelector(".modal-body");

                        errorModalBody.textContent =
                            "Debes seleccionar al menos una opción";

                        new window.bootstrap.Modal(errorModalElement).show();
                    }
                } else {
                    inputError.textContent =
                        "Debes seleccionar al menos una opción";
                }
            } else if (confirmModalElement) {
                event.preventDefault();
                event.stopPropagation();

                const confirmModal = new window.bootstrap.Modal(
                    confirmModalElement
                );
                const confirmButton =
                    confirmModalElement.querySelector("#confirm");
                const cancelButtons = Array.from(
                    confirmModalElement.querySelectorAll(
                        "button[data-bs-dismiss=modal]"
                    )
                );

                const addConfirmEventListener = () => {
                    confirmButton.addEventListener("click", handleConfirmClick);
                };

                const removeConfirmEventListener = () => {
                    confirmButton.removeEventListener(
                        "click",
                        handleConfirmClick
                    );
                };

                const handleConfirmClick = () => {
                    form.submit();
                    removeEventListeners();
                };

                const addCancelEventListeners = () => {
                    cancelButtons.forEach((cancelButton) => {
                        cancelButton.addEventListener(
                            "click",
                            handleCancelClick
                        );
                    });
                };

                const removeCancelEventListeners = () => {
                    cancelButtons.forEach((cancelButton) => {
                        cancelButton.removeEventListener(
                            "click",
                            handleCancelClick
                        );
                    });
                };

                const handleCancelClick = () => {
                    removeEventListeners();
                };

                const removeEventListeners = () => {
                    removeConfirmEventListener();
                    removeCancelEventListeners();
                };

                addConfirmEventListener();
                addCancelEventListeners();
                confirmModal.show();
            }
        });
    });
});
