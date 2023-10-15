window.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("main .selectable");
    const invalidChildTags = ["a", "button"];
    const invalidTags = ["input", ...invalidChildTags, "img"];

    Array.from(forms).forEach((row) => {
        row.addEventListener("click", (event) => {
            if (
                invalidTags.includes(event.target.tagName?.toLowerCase()) ||
                Array.from(event.target.childNodes).some((data) => {
                    return invalidChildTags.includes(
                        data.tagName?.toLowerCase()
                    );
                })
            )
                return;

            const checkbox = row.querySelector("input[type=checkbox]");
            if (checkbox == null) return;

            checkbox.checked = !checkbox.checked;
        });
    });
});
