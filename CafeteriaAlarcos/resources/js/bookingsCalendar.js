import { Calendar } from "@fullcalendar/core";
import bootstrap5Plugin from "@fullcalendar/bootstrap5";
import dayGridPlugin from "@fullcalendar/daygrid";

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
    events: turns.data.map(({ name, date, start, end, id }) => ({
        title: name,
        start: `${date}T${start}`,
        end: `${date}T${end}`,
        url: `${baseUrl}/${id}`,
    })),
    displayEventEnd: true,
    eventDisplay: "list-item",
});

calendar.render();
