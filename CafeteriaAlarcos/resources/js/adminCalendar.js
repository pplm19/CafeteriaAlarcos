import { Calendar } from "@fullcalendar/core";
import bootstrap5Plugin from "@fullcalendar/bootstrap5";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

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
    events: [
        {
            start: date,
            end: date,
            display: "background",
        },
        ...turns.map(({ name, date, start, end }) => ({
            title: name,
            start: `${date}T${start}`,
            end: `${date}T${end}`,
            url: `${baseUrl}?date=${date}`,
        })),
    ],
    displayEventEnd: true,
    eventDisplay: "list-item",
    dateClick: function (info) {
        if (info.dateStr === date) return;

        window.location.href = `${baseUrl}?date=${info.dateStr}`;
    },
});

calendar.render();
