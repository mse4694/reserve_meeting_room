<template>
    <AppLayout>
        <Card>
            <template #content>
            
                <div class="ml-4 mr-4">
                    <Toolbar>
                        <template #right>
                            <Link :href="route('manage_meeting_room')">
                            <div class="mt-2"><Button label="กลับไปจัดการห้องประชุม" icon="pi pi-trash" class="p-button-primary p-button-sm"/></div>
                            </Link>
                        </template>
                    </Toolbar>

                    <DataTable ref="dt" :value="deletedMeetingRooms" dataKey="id" responsiveLayout="stack" breakpoint="960px"
                        :paginator="true" :rows="5" :filters="filters" :scrollable="true" scrollHeight="flex" stripedRows class="p-datatable-sm"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                        currentPageReportTemplate="แสดง {first} ถึง {last} จากทั้งหมด {totalRecords}">
                        <template #header>
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <h5 class="mb-2">จัดการลบห้องประชุมแบบถาวร</h5>
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters['global'].value" placeholder="Search..." />
                                </span>
                            </div>
                        </template>

                        <Column header="รูปห้อง" >
                            <template #body="slotProps">
                                <Image :src="`/storage/picture/${slotProps.data.image1}`" :alt="slotProps.data.image2" class="meeting_room-image" preview />
                        
                            </template>
                        </Column>

                        <Column field="fullname" header="ชื่อเต็ม" :sortable="true" />
                        <Column field="shortname" header="ชื่อย่อ" :sortable="true"  />

                        <Column field="building_id" header="สถานที่" :sortable="true" >
                            <template #body="slotProps">
                                <span>ตึก {{getBuildingName(slotProps.data.building_id).full_name}} ชั้น {{slotProps.data.floor}}</span>
                            </template>
                        </Column>

                        <Column field="status" header="สถานะ" :sortable="true" >
                            <template #body="slotProps">
                                <span :class="'px-2 border-opacity-50 rounded-sm font-semibold status-' + (slotProps.data.status ? slotProps.data.status.toLowerCase() : '')">{{ thaiStatus(slotProps.data.status).label }}</span>
                            </template>
                        </Column>

                        <Column :exportable="false" >
                            <template #body="slotProps">
                                <div class="mr-1"><Button icon="pi pi-undo" class="p-button-sm p-button-rounded p-button-primary" @click="restoreMeetingRoom(slotProps.data.id)"/></div>
                                <div><Button icon="pi pi-trash" class="p-button-sm p-button-rounded p-button-danger" @click="confirmDeleteMeetingRoom(slotProps.data)"/></div>
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <!-- สำหรับลบห้องประชุมจากปุ่มลบของ Row ตัวเอง-->
                <Dialog v-model:visible="permananceDeleteMeetingRoomDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem; color: #e65c00" />
                        <span v-if="meetingRoom">คุณต้องการลบห้องประชุม <b>{{meetingRoom.fullname}}</b> แบบถาวร ?</span>
                    </div>
                    <template #footer>
                        <Button label="ไม่ใช่" icon="pi pi-times" class="p-button-sm" @click="permananceDeleteMeetingRoomDialog = false"/>
                        <Button label="ใช่" icon="pi pi-check" class="p-button-raised p-button-text p-button-danger p-button-sm" @click="permananceDeleteMeetingRoom" />
                    </template>
                </Dialog>

            </template>
        </Card>
        <Toast position="top-right" />
        <Toast position="center" group="errorkey" />
    </AppLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { FilterMatchMode } from 'primevue/api';
import { useToast } from "primevue/usetoast";

export default {
    props: {
        errors: Object,
        dmrooms_tranform: Array,
    },

    components: {
        Link,
    },

    setup() {
        onMounted(() => {
            deletedMeetingRooms.value = usePage().props.value.dmrooms_tranform
        })

        const toast = useToast();
        const dt = ref();
        const meetingRoom = ref({});
        const deletedMeetingRooms = ref([]);
        const permananceDeleteMeetingRoomDialog = ref(false);
        const filters = ref({
            'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
        });

        const building = ref([
            {id: 1, building_id: 1, full_name: 'อัษฎางค์', short_name: 'อฎ.'},
	     	{id: 2, building_id: 2, full_name: 'นวมินทรบพิตรฯ', short_name: 'นว.'},
            {id: 3, building_id: 3, full_name: 'ธนาคารไทยพาณิชย์', short_name: 'ตึกไทยพาณิชย์'},
        ]);

        const statuses = ref([
	     	{label: 'พร้อมใช้', value: 'READY'},
	     	{label: 'ปรับปรุง', value: 'RENOVATE'},
            {label: 'ซ่อมแซม', value: 'REPAIR'},
        ]);

        const thaiStatus = (inputStatus) => {
            return statuses.value.find(status=>status.value === inputStatus)
        };

        const getBuildingName = (input_building_id) => {
            return building.value.find(bname=>bname.building_id === input_building_id)
        };

        const restoreMeetingRoom = (mRoom) => {
            toast.removeAllGroups()
            Inertia.patch( route('restore_meeting_room', mRoom), { preserveState: true }, {
                onSuccess: () => {
                        deletedMeetingRooms.value = usePage().props.value.dmrooms_tranform
                        toast.add({severity:'success', summary: 'Successful', detail: 'ยกเลิกการลบห้องประชุมเรียบร้อย', life: 3000});
                },
                onError: (errors) => {
                    console.log(errors.msg)
                    console.log(errors.sysmsg)
                    toast.add({severity:'error', summary: 'Failure', detail: `ยกเลิกการลบห้องประชุมไม่สำเร็จ เนื่องจาก ${errors.sysmsg}`, group: 'errorkey'});
                },
                onFinish: () => {
                    console.log('Restore Finish')
                }
            });
        };

        const confirmDeleteMeetingRoom = (mRoom) => {
            toast.removeAllGroups()
            meetingRoom.value = mRoom;
            permananceDeleteMeetingRoomDialog.value = true;
        }

        const permananceDeleteMeetingRoom = () => {
            //console.log(meetingRoom.value.id)
            // ถ้ามีการใช้งาน dialog จะไม่สามารถใช้งาน preserveState: true ได้ เพราะจะทำให้ dialog จะยังคงอยู่
            Inertia.delete(route('delete_meeting_room_permanance', meetingRoom.value.id), {
                onSuccess: () => {
                    // console.log("on success")
                    // console.log(usePage().props.value.dmrooms_tranform)
                    deletedMeetingRooms.value = usePage().props.value.dmrooms_tranform
                    toast.add({severity:'success', summary: 'Successful', detail: 'ลบห้องประชุมแบบถาวรเรียบร้อย', life: 3000});
                },
                onError: (errors) => {
                    console.log(errors.msg)
                    console.log(errors.sysmsg)
                    toast.add({severity:'error', summary: 'Failure', detail: `ยกเลิกการลบห้องประชุมแบบถาวรไม่สำเร็จ เนื่องจาก ${errors.sysmsg}`, group: 'errorkey'});
                },
                onFinish: () => {
                    console.log('Permanance Delete Finish')
                    permananceDeleteMeetingRoomDialog.value = false;
                    meetingRoom.value = {};
                }
            });
        };
   
        return { 
            dt, filters, deletedMeetingRooms, permananceDeleteMeetingRoomDialog, meetingRoom,
            building, statuses,
            thaiStatus, getBuildingName, restoreMeetingRoom, permananceDeleteMeetingRoom, confirmDeleteMeetingRoom  //Method
        }
    }
}
</script>

<style scoped>

.meeting_room-image {
    width: 70px;
    height: 40px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.meeting_room-image:hover {
    cursor:pointer; 
}

.status-ready {
    background-color: aquamarine;
}

.status-renovate {
    background-color:bisque;
}

.status-repair {
    background-color:lightpink;
}

</style>