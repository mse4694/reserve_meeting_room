<template>
    <AppLayout>
        <div>
            <FullCalendar ref="fullCalendar" :events="events" :options="calendarOptions">
                <!-- <template v-slot:eventContent='arg'>
                    <b>{{ arg.timeText }}</b>
                    <i>{{ arg.event.title }}</i>
                </template> -->
            </FullCalendar>
        </div>
    </AppLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue';
//import '@fullcalendar/core/vdom' // solves problem with Vite
import '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'
import thLocale from '@fullcalendar/core/locales/th'
import EventService from '@/Services/EventService'

export default {
    components: {
        AppLayout,
    },
    setup() {
        // onMounted(() => {
        //     eventService.value.getEvents().then(data => {
        //         events.value = data;
        //         // console.log(data);
        //         // console.log(eventService.value.getEvents());
        //         // console.log(events.value);
        //     });
        // })

        const fullCalendar = ref(null)
        const calendarOptions =  ref({
            plugins:[dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin],
            locale: thLocale,
            //initialDate : '2021-08-01',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth timeGridWeek,listWeek timeGridDay,listDay' // การใส่เครื่องหมาย , (comma) มีผลต่อการแสดงผลบนหน้าจอ จะหมายความว่าจะเป็น element ที่ติดกัน
            },
            //editable: true,
            selectable:true, 
            //selectMirror: true,
            dayMaxEvents: 3,
            customButtons: {
                prev: {
                text: 'ก่อนหน้า',
                icons: 'left-single-arrow',
                click: function() {
                        //console.log(fullCalendar.value)
                        fullCalendar.value.calendar.prev();
                        console.log(fullCalendar.value.calendar.currentData.currentDate.getMonth()+1)
                    }
                },

                next: {
                text: 'ถัดไป',
                icons: 'right-single-arrow',
                click: function() {
                        //console.log(fullCalendar.value)
                        fullCalendar.value.calendar.next();
                        console.log(fullCalendar.value.calendar.currentData.currentDate.getMonth()+1)
                    }
                },

                today: {
                text: 'วันนี้',
                click: function() {
                        //console.log(fullCalendar.value)
                        fullCalendar.value.calendar.today();
                        console.log(fullCalendar.value.calendar.currentData.currentDate.getMonth()+1)
                    }
                }

            },
            
            showNonCurrentDates: false,   // ไม่ให้เห็น วันอื่นๆที่ไม่ได้อยู่ในเดือนนั้นๆ จากหน้าของ dayGridMonth 
            //eventDisplay: 'block',
            //displayEventTime: false,
            //defaultAllDay: false,
            displayEventEnd: true,  // บังคับแสดง เวลาที่จบ event นั้นๆ
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            },
            dateClick: function(info) {
                handleDateClick(info)
            },
            eventClick: function(info) {
                handleEventClick(info)
            }
        });

        const events =  ref([
                {"id": 1,"title": "All Day Event","start": "2021-10-01"},
                {"id": 2,"title": "Long Event","start": "2021-10-07","end": "2021-10-10"},
                {"id": 3,"title": "Repeating Event","start": "2021-10-09T16:00:00"},
                {"id": 4,"title": "Repeating Event","start": "2021-10-16T16:00:00","end": "2021-10-16T17:00:00", "color": "green"},
                {"id": 5,"title": "Conference","start": "2021-10-11","end": "2021-10-13"},
                {"id": 6,"title": "Meeting","start": "2021-10-12T10:30:00","end": "2021-10-12T12:37:00"},
                {"id": 7,"title": "Lunch","start": "2021-10-12T12:00:00"},
                {"id": 8,"title": "Meeting","start": "2021-10-12T14:30:00"},
                {"id": 9,"title": "Happy Hour","start": "2021-10-12T17:30:00"},
                {"id": 10,"title": "Dinner","start": "2021-10-12T20:00:00"},
                {"id": 11,"title": "Birthday Party","start": "2021-10-13T07:00:00"},
                {"id": 12,"title": "Click for Google","url": "https://www.google.com/","start": "2021-10-28"},
                {"id": 13,"title": "ประชุมหน่วย IT ประจำเดือน เพื่อปรับปรุงขั้นตอนการทำงาน","start": "2021-10-28", "color": "black"}
        ]);

        const handleDateClick = (info) => {
            alert('Clicked on: ' + info.dateStr);
            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // Comment change the day's background color just for fun
            //info.dayEl.style.backgroundColor = 'red';
        }

        const handleEventClick = (info) => {
            //alert('Event: ' + info.event.title);
            //console.log(info.event)
            //let eventObject = ref({'id': info.event.id, 'title': info.event.title})
            //console.log(eventObject.value)
            //window.open("https://www.w3schools.com", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
            window.open(route('event_display', info.event.id), "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
            
            //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            //alert('View: ' + info.view.type);

            // change the border color just for fun
            //info.el.style.borderColor = 'red';
        }

        const eventService = ref(new EventService());
        
        return { 
            calendarOptions, events, eventService, fullCalendar, 
            handleDateClick, handleEventClick,    // Method
        }
    },
}
</script>

<style scoped>
@media screen and (max-width: 960px) {
    ::v-deep(.fc-header-toolbar) {
        display: flex;
        flex-wrap: wrap;
    }
/* @import '@fullcalendar/core/main.css';
@import '@fullcalendar/daygrid/main.css';
@import '@fullcalendar/timegrid/main.css';
@import '@fullcalendar/list/main.css'; */
}
</style>