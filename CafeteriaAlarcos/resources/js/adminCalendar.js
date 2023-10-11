import { Calendar } from "@fullcalendar/core";
import bootstrap5Plugin from "@fullcalendar/bootstrap5";
import dayGridPlugin from "@fullcalendar/daygrid";

const today = new Date().toISOString().slice(0, 10);

const calendarEl = document.getElementById("calendar");
const calendar = new Calendar(calendarEl, {
    plugins: [bootstrap5Plugin, dayGridPlugin],
    locale: "es",
    themeSystem: "bootstrap5",
    initialView: "dayGridMonth",
    firstDay: 1,
    headerToolbar: {
        left: "title",
        center: "",
        right: "prev,next",
    },
    now: date,
    events: [
        {
            start: today,
            end: today,
            display: "background",
        },
        ...turns.map(({ name, date, start, end, id }) => ({
            title: name,
            date: date,
            start: `${date}T${start}`,
            end: `${date}T${end}`,
            url: `${baseUrl}?date=${date}&turn=${id}`,
        })),
    ],
    displayEventEnd: true,
    eventDisplay: "list-item",
    eventClick: function (info) {
        if (info.event.url === window.location.href)
            info.jsEvent.preventDefault();
    },
});

calendar.render();
