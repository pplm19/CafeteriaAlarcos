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
                    const alertsContainer = document.getElementById("alerts");

                    const alertDiv = document.createElement("div");
                    alertDiv.className =
                        "alert alert-danger alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4";
                    alertDiv.role = "alert";

                    const closeButton = document.createElement("button");
                    closeButton.type = "button";
                    closeButton.className = "btn-close";
                    closeButton.setAttribute("data-bs-dismiss", "alert");
                    closeButton.setAttribute("aria-label", "Close");

                    alertDiv.textContent =
                        "Debes seleccionar al menos una opción";

                    alertDiv.appendChild(closeButton);

                    alertsContainer.appendChild(alertDiv);
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
