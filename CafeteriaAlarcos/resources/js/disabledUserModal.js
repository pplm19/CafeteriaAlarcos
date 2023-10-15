window.addEventListener("DOMContentLoaded", () => {
    const userIdInput = document.querySelector(".modal #user_id");
    const disableButtons = document.querySelectorAll(
        "main table .btn-disable-user"
    );

    Array.from(disableButtons).forEach((button) => {
        button.addEventListener("click", () => {
            const userId = button.getAttribute("data-user-id");

            userIdInput.value = userId;
        });
    });
});
