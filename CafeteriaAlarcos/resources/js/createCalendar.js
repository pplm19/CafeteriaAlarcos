import { Calendar } from "@fullcalendar/core";
import bootstrap5Plugin from "@fullcalendar/bootstrap5";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

let modal, dateInput;

const calendarEl = document.getElementById("calendar");
const calendar = new Calendar(calendarEl, {
    plugins: [bootstrap5Plugin, dayGridPlugin, interactionPlugin],
    locale: "es",
    themeSystem: "bootstrap5",
    initialView: "dayGridMonth",
    firstDay: 1,
    headerToolbar: {
        left: "title",
        center: "",
        right: "prev,next",
    },
    events: turns.map(({ name, date, start, end }) => ({
        title: name,
        date: date,
        start: `${date}T${start}`,
        end: `${date}T${end}`,
    })),
    displayEventEnd: true,
    eventDisplay: "list-item",
    dateClick: function (info) {
        dateInput.value = info.dateStr;
        modal.show();
    },
});

window.addEventListener("DOMContentLoaded", () => {
    const modalElement = document.querySelector("#createTurnModal");
    dateInput = modalElement.querySelector("#date");
    modal = new window.bootstrap.Modal(modalElement);

    calendar.render();
});
