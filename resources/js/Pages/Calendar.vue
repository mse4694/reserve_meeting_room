<template>
    <AppLayout>
        <div>
            <div class="mb-2">
                isAdmin:
                <ToggleButton v-model="isAdmin" onIcon="pi pi-check" offIcon="pi pi-times" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                {{showEvent}}
            </div>
            <FullCalendar ref="fullCalendar" :events="events" :options="calendarOptions">
                <!-- <template v-slot:eventContent='arg' v-tooltip='arg.event.title' >
                    <b>{{ arg.timeText }}</b>
                    <i>{{ arg.event.title }}</i>
                </template> -->
            </FullCalendar>
        </div>
    </AppLayout>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue';
import '@fullcalendar/core/vdom' // solves problem with Vite
import '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'
import resourceTimeGridPlugin from '@fullcalendar/resource-timegrid';
import thLocale from '@fullcalendar/core/locales/th'
import EventService from '@/Services/EventService'

export default {
    components: {
        AppLayout,
    },
    setup() {
          onMounted(() => {
        // //     eventService.value.getEvents().then(data => {
        // //         events.value = data;
        // //         // console.log(data);
        // //         // console.log(eventService.value.getEvents());
        // //         // console.log(events.value);
        // //     });

            axios.get(route('event_all')).then(res => {
                    //console.log(res.data.events)
                    // if( ! isAdmin.value )
                    //     events.value = res.data.events.value.filter(val => {
                    //         //console.log(attendees.value)
                    //         return val.status === 1 
                    //     });
                    // else{
                    //     events.value =  res.data.events
                    // }
                    masterEvents.value =  res.data.events
                    events.value =  res.data.events
                    //console.log(masterEvents.value)
            });
        })

        const fullCalendar = ref(null)
        const calendarOptions =  ref({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            plugins:[dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin, resourceTimeGridPlugin],
            locale: thLocale,
            //initialDate : '2021-08-01',
            // resources: [
            //     {'id':1, 'title':'วีกิจ'},
            //     {'id':2, 'title':'จงจินต์'},
            //     {'id':3, 'title':'ตั้งภรณ์พรรณ'}
            // ],
            resourceOrder: '-title, id',
            //filterResourcesWithEvents: true, // แสดงเฉพาะห้องที่มี event ในวันนั้นๆ เท่านั้น
            resources: function(fetchInfo, successCallback, failureCallback) {
                axios.get(route('get_calendar_resources')).then(res => {
                    successCallback(res.data.resources) 
                });
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay resourceTimeGridDay listWeek' // การใส่เครื่องหมาย , (comma) มีผลต่อการแสดงผลบนหน้าจอ จะหมายความว่าจะเป็น element ที่ติดกัน
                //right: 'dayGridMonth,listMonth timeGridWeek,listWeek resourceTimeGridDay,listDay' // การใส่เครื่องหมาย , (comma) มีผลต่อการแสดงผลบนหน้าจอ จะหมายความว่าจะเป็น element ที่ติดกัน
                //right: 'dayGridMonth,listMonth timeGridWeek,listWeek timeGridDay,listDay' // การใส่เครื่องหมาย , (comma) มีผลต่อการแสดงผลบนหน้าจอ จะหมายความว่าจะเป็น element ที่ติดกัน
            },
            navLinks: true,
            businessHours: true,
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Thursday
                startTime: '08:30', // a start time (10am in this example)
                endTime: '16:30', // an end time (6pm in this example)
            },
            //editable: true,
            selectable:true, 
            //selectMirror: true,
            dayMaxEvents: 2,
            customButtons: {
                prev: {
                    text: 'ก่อนหน้า',
                    icons: 'left-single-arrow',
                    click: function() {
                        //console.log(fullCalendar.value)
                        fullCalendar.value.calendar.prev();
                        console.log(fullCalendar.value.calendar.currentData.currentDate.getMonth()+1)
                        //console.log(resources.value)
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
                },

                resourceTimeGridDay: {
                    text: 'ห้องประชุมรายวัน',
                    click: function() {
                        //console.log(fullCalendar.value)
                        fullCalendar.value.calendar.changeView('resourceTimeGridDay');
                    //     fullCalendar.value.options.resources();
                    //     //fullCalendar.value.calendar.today();
                    }
                },

                listWeek: {
                    text: 'กำหนดการรายสัปดาห์',
                    click: function() {
                        fullCalendar.value.calendar.changeView('listWeek');
                    }
                }


            },
            nowIndicator: true,  // แสดง เส้นกำกับว่าเวลาปัจจุบันตอนนี้อยู่ที่เวลาไหน บน TimeGrid view ต่างๆ
            showNonCurrentDates: false,   // ไม่ให้เห็น วันอื่นๆที่ไม่ได้อยู่ในเดือนนั้นๆ จากหน้าของ dayGridMonth 
            eventDisplay: 'block',
            displayEventTime: false,
            //defaultAllDay: false,
            //displayEventEnd: true,  // บังคับแสดง เวลาที่จบ event นั้นๆ
            eventTimeFormat: { // like '14:30' or '7:00'
                //hour: '2-digit',
                hour: 'numeric',
                minute: '2-digit',
                //second: '2-digit',
                hour12: false
            },
            //eventOrder: ["title","duration", "start", "end"], // ใน 1 วันจะเรียง event ให้ดูตาม order ที่เราตั้งเอาไว้ ถ้ามีหลาย event defaut คือ "start,-duration,allDay,title"
            dateClick: function(info) {
                handleDateClick(info)
            },
            eventClick: function(info) {
                handleEventClick(info)
            },
            eventDidMount: function(info) {
                //console.log(info.el)
                //console.log(info.event.extendedProps);
                //console.log(info.event.title);
                // var tooltip = new Tooltip(info.el, {
                //     title: info.event.title,
                //     placement: 'top',
                //     trigger: 'hover',
                //     container: 'body'
                // });
            },
        });

        // const events =  ref([
        //         {"id": 1,"title": "All Day Event","start": "2021-10-01", "resourceId": 1},
        //         {"id": 2,"title": "Long Event","start": "2021-10-07","end": "2021-10-10", "resourceId": 1},
        //         {"id": 3,"title": "Repeating Event","start": "2021-10-09T16:00:00", "resourceId": 2},
        //         {"id": 4,"title": "Repeating Event","start": "2021-10-16T16:00:00","end": "2021-10-16T17:00:00", "color": "green", "resourceId": 1},
        //         {"id": 5,"title": "Conference","start": "2021-10-11","end": "2021-10-13", "resourceId": 3},
        //         {"id": 6,"title": "Meeting","start": "2021-10-12T10:30:00","end": "2021-10-12T12:37:00", "resourceId": 3},
        //         {"id": 7,"title": "Lunch","start": "2021-10-12T12:00:00", "resourceId": 2},
        //         {"id": 8,"title": "Meeting","start": "2021-10-12T14:30:00", "resourceId": 1},
        //         {"id": 9,"title": "Happy Hour","start": "2021-10-12T17:30:00", "resourceId": 3},
        //         {"id": 10,"title": "Dinner","start": "2021-10-12T20:00:00", "resourceId": 2},
        //         {"id": 11,"title": "Birthday Party","start": "2021-10-13T07:00:00", "resourceId": 1},
        //         {"id": 12,"title": "Click for Google","url": "https://www.google.com/","start": "2021-10-28", "resourceId": 1},
        //         {"id": 13,"title": "ประชุมหน่วย IT ประจำเดือน เพื่อปรับปรุงขั้นตอนการทำงาน","start": "2021-10-28T13:00:00","end": "2021-10-28T16:30:00", "color": "black", "resourceId": 2}
        // ]);
        const masterEvents = ref([])
        const events = ref([])

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
            //window.open(route('event_display', info.event.id), "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
            window.open(route('event_show', info.event.id), "_blank", "location=no,toolbar=no,scrollbars=yes,resizable=yes,top=200,left=200,width=700,height=600");
            
            //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            //alert('View: ' + info.view.type);

            // change the border color just for fun
            //info.el.style.borderColor = 'red';
        }

        const eventService = ref(new EventService());

        const isAdmin = ref(true)

        const showEvent = computed(() => {
            if( ! isAdmin.value ) {
                events.value = masterEvents.value.filter(val => {
                    //console.log(attendees.value)
                    return val.status === 1 
                });
            } else{
                events.value =  masterEvents.value
            }
        })
        
        return { 
            calendarOptions, events, eventService, fullCalendar, isAdmin, masterEvents,
            handleDateClick, handleEventClick, showEvent    // Method
        }
    },
}
</script>

<style scoped>
/* @import '@fullcalendar/core/main.css'; */
@import '@fullcalendar/daygrid/main.css';
@import '@fullcalendar/timegrid/main.css';
@import '@fullcalendar/list/main.css';
@media screen and (max-width: 960px) {
    ::v-deep(.fc-header-toolbar) {
        display: flex;
        flex-wrap: wrap;
    }
}
</style>