window.addEventListener("DOMContentLoaded", () => {
    const modals = ["#statusModal", "#errorModal"];

    modals.forEach((modal) => {
        const ModalElement = document.querySelector(modal);

        if (ModalElement) {
            const ModalBody = ModalElement.querySelector(".modal-body");

            if (
                ModalBody == null ||
                ModalBody.childNodes.length === 0 ||
                String(ModalBody.childNodes[0].textContent).replace(
                    /\s+/g,
                    ""
                ) === ""
            )
                return;

            new window.bootstrap.Modal(ModalElement).show();
        }
    });

    const alerts = document.querySelectorAll("#alerts .alert");

    if (alerts.length > 1) {
        Array.from(alerts).forEach((alert, index) => {
            setTimeout(() => {
                window.bootstrap.Alert.getOrCreateInstance(alert).close();
            }, 5000 + index * 2500);
        });
    }
});
