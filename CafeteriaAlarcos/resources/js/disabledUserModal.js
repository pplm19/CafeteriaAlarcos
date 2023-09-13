window.addEventListener("DOMContentLoaded", () => {
    const userIdInput = document.querySelectorAll(".modal #user_id")[0];
    const disableButtons = document.querySelectorAll(
        "#content table .btn-disable-user"
    );

    Array.from(disableButtons).forEach((button) => {
        button.addEventListener("click", () => {
            const userId = button.getAttribute("data-user-id");

            userIdInput.value = userId;
        });
    });
});
