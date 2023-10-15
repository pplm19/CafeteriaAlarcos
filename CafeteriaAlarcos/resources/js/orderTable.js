window.addEventListener("DOMContentLoaded", () => {
    const orderableTables = document.querySelectorAll("main table .orderable");

    const orderClick = (event) => {
        const classList = Array.from(event.target.classList);
        const move = classList.includes("orderable-up")
            ? "up"
            : classList.includes("orderable-down")
            ? "down"
            : null;
        if (move === null) return;

        const row = event.target?.parentElement?.parentElement;
        if (row?.tagName?.toLowerCase() !== "tr") return;

        const tbody = row?.parentElement;
        if (tbody?.tagName?.toLowerCase() !== "tbody") return;

        const rowIndex = row.rowIndex;
        if (
            (move === "up" && rowIndex === 1) ||
            (move === "down" && rowIndex === tbody.rows.length - 1)
        ) {
            console.log("Denied");
            return;
        }

        if (move === "up") tbody.insertBefore(row, tbody.rows[rowIndex - 1]);
        else tbody.insertBefore(tbody.rows[rowIndex + 1], row);
    };

    const addTableListeners = (table) => {
        const cols = table.querySelectorAll("tr td.orderable-buttons");

        Array.from(cols).forEach((col) => {
            col.addEventListener("click", (event) => {
                orderClick(event);
            });
        });
    };

    Array.from(orderableTables).forEach((table) => {
        table.addEventListener("DOMChanged", () => {
            addTableListeners(table);
        });

        table.addEventListener("DOMRowAdded", ({ detail: col }) => {
            col.addEventListener("click", (event) => {
                orderClick(event);
            });
        });

        addTableListeners(table);
    });
});
