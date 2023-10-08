window.addEventListener("DOMContentLoaded", () => {
    // Global variables
    let selectList = {};

    const formSelectList = document.querySelector(".content form #select_list");

    let checkboxStatus = {};

    const selectModal = document.querySelector(".content #selectModal");
    const modal = new window.bootstrap.Modal(selectModal);
    const modalSelectList = selectModal.querySelector("#modal_select_list");
    const isOrderable = Array.from(modalSelectList.classList).includes(
        "orderable"
    );
    // Global variables

    // Functions
    const checkboxClick = (checkbox, add, modal) => {
        if (checkbox.disabled) return;

        const category = checkbox.getAttribute("data-category");
        const id = checkbox.value;

        const mainCheckbox = add
            ? checkbox
            : selectModal.querySelector(`#category_${category} #select_${id}`);

        if (modal && !checkboxStatus[id])
            checkboxStatus[id] = {
                checkbox: mainCheckbox,
                status: mainCheckbox.disabled,
            };

        if (mainCheckbox) mainCheckbox.disabled = add;

        if (add) {
            const newRow =
                checkbox?.parentElement?.parentElement?.cloneNode(true);

            const newCheckbox = newRow.querySelector("input[type=checkbox]");

            newCheckbox.removeAttribute("id");
            newCheckbox.className = "form-check-input remove-checkbox";
            newCheckbox.checked = true;
            newCheckbox.disabled = false;

            newCheckbox.addEventListener("click", handleRemoveClick);
            newRow.addEventListener("click", handleRowCheckboxClick);

            if (isOrderable) {
                newRow.insertAdjacentHTML(
                    "beforeend",
                    `<td class="text-center w-10 orderable-buttons">
                        <i class="bi bi-chevron-up d-block orderable-up"></i>
                        <i class="bi bi-chevron-down d-block orderable-down"></i>
                    </td>`
                );
            }

            modalSelectList.appendChild(newRow);

            modalSelectList.dispatchEvent(
                new CustomEvent("DOMRowAdded", { detail: newRow })
            );
        } else {
            checkbox?.parentElement?.parentElement?.remove();
        }
    };

    const handleRowCheckboxClick = (event) => {
        if (
            event.target.tagName?.toLowerCase() === "input" ||
            Array.from(event.target.classList).includes("orderable-buttons")
        )
            return;

        const checkbox = event.target.parentElement.querySelector(
            "input[type=checkbox]"
        );
        if (checkbox == null) return;

        checkbox.dispatchEvent(new Event("click"));
    };

    const rowCheckboxListener = (rows) => {
        Array.from(rows).forEach((row) => {
            row.addEventListener("click", handleRowCheckboxClick);
        });
    };

    const handleCheckBoxClick = (event) => {
        event.preventDefault();

        const checkbox = event.target;

        const category = checkbox.getAttribute("data-category");
        const id = checkbox.value;

        let index;
        if (
            selectList[category] &&
            (index = selectList[category].indexOf(id)) > -1
        ) {
            selectList[category].splice(index, 1);
        }

        checkboxClick(checkbox, false, false);
    };

    const tableCheckboxesListener = () => {
        const tableCheckboxesRow =
            formSelectList.querySelectorAll(".selectable");
        const tableCheckboxes = formSelectList.querySelectorAll(
            ".form-check-input.remove-checkbox"
        );

        Array.from(tableCheckboxes).forEach((checkbox) => {
            checkbox.addEventListener("click", handleCheckBoxClick);
        });
        rowCheckboxListener(tableCheckboxesRow);
    };
    // Functions

    // Form
    const addOldSelected = (searched) => {
        let selectedList = {};

        Object.entries(elementsList).forEach(([category, elements]) => {
            const found = elements.filter(({ id }) => {
                return searched.includes(id.toString());
            });

            if (found.length > 0) {
                if (!selectList[category]) selectList[category] = [];

                found.forEach((element) => {
                    selectList[category].push(element.id.toString());
                    selectedList[element.id] = element;
                });
            }
        });

        searched.forEach((elementId) => {
            formSelectList.insertAdjacentHTML(
                "beforeend",
                htmlTemplate(selectedList[elementId])
            );
        });
    };

    const addSelected = (selected) => {
        Object.values(selected).forEach((element) => {
            formSelectList.insertAdjacentHTML(
                "beforeend",
                htmlTemplate(element)
            );

            const elementCategoryId = getElementCategoryId(element);
            if (!selectList[elementCategoryId])
                selectList[elementCategoryId] = [];
            selectList[elementCategoryId].push(element.id.toString());
        });
    };

    const initListeners = () => {
        if (typeof selected !== "undefined") addSelected(selected);
        else if (typeof oldSelected !== "undefined")
            addOldSelected(oldSelected);

        tableCheckboxesListener();

        const selectables = formSelectList.querySelectorAll(".selectable");
        rowCheckboxListener(selectables);

        formSelectList.dispatchEvent(new CustomEvent("DOMChanged"));
    };

    initListeners();
    // Form

    // Modal

    // Modal open
    const selectModalOpen = document.querySelector(
        "button[data-bs-target='#selectModal']"
    );
    selectModalOpen.addEventListener("click", () => {
        modalSelectList.innerHTML = formSelectList.innerHTML;

        Object.entries(selectList).forEach(([category, elements]) => {
            elements.forEach((id) => {
                const checkbox = selectModal.querySelector(
                    `#category_${category} #select_${id}`
                );
                if (checkbox) checkbox.disabled = true;
            });
        });

        modalSelectList.dispatchEvent(new CustomEvent("DOMChanged"));

        removeCheckboxesListener();
    });
    // Modal open

    // Modal cancel
    const selectModalCancel = selectModal.querySelectorAll(
        "button[data-bs-dismiss=modal]"
    );
    Array.from(selectModalCancel).forEach((element) => {
        element.addEventListener("click", () => {
            Object.values(checkboxStatus).forEach(({ checkbox, status }) => {
                checkbox.disabled = status;
            });

            checkboxStatus = {};
        });
    });
    // Modal cancel

    // Modal confirm
    const selectModalConfirm = selectModal.querySelector("#confirm");
    selectModalConfirm.addEventListener("click", () => {
        modal.hide();

        formSelectList.innerHTML = modalSelectList.innerHTML;

        formSelectList.dispatchEvent(new CustomEvent("DOMChanged"));

        tableCheckboxesListener();

        Object.values(checkboxStatus).forEach(({ checkbox, status }) => {
            const category = checkbox.getAttribute("data-category");
            const id = checkbox.value;

            let index;

            if (!status) {
                if (!selectList[category]) selectList[category] = [];

                selectList[category].push(id);
            } else if (
                selectList[category] &&
                (index = selectList[category].indexOf(id)) > -1
            ) {
                selectList[category].splice(index, 1);
            }
        });

        checkboxStatus = {};
    });
    // Modal confirm

    // Modal add
    const addCheckboxes = selectModal.querySelectorAll(
        "#accordionSelect .form-check-input.add-checkbox"
    );
    Array.from(addCheckboxes).forEach((checkbox) => {
        checkbox.addEventListener("click", (event) => {
            event.preventDefault();

            const checkbox = event.target;

            checkboxClick(checkbox, true, true);
        });
    });
    // Modal add

    // Modal remove
    const handleRemoveClick = (event) => {
        event.preventDefault();

        const checkbox = event.target;

        checkboxClick(checkbox, false, true);
    };

    const removeCheckboxesListener = () => {
        const removeCheckboxesRow = selectModal.querySelectorAll(".selectable");
        const removeCheckboxes = selectModal.querySelectorAll(
            ".form-check-input.remove-checkbox"
        );

        Array.from(removeCheckboxes).forEach((checkbox) => {
            checkbox.addEventListener("click", handleRemoveClick);
        });
        rowCheckboxListener(removeCheckboxesRow);
    };
    // Modal remove

    // Modal
});
