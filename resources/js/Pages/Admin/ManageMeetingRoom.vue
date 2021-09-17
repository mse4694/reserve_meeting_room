<template>
    <AppLayout>
    <div class="card">
        <div class="text-xl border-double border-b-2 border-opacity-25 border-blue-500 mt-2 mb-4 ml-2">ข้อมูลห้องประชุม</div>
        <div class="ml-4 mr-4">
            <Toolbar>
                <template #left>
                    <div class="px-2"><Button label="เพิ่ม" icon="pi pi-plus" class="p-button-success p-button-sm" @click="openNew"/></div>
                    <div><Button label="ลบ" icon="pi pi-trash" class="p-button-danger p-button-sm" @click="confirmDeleteSelected" :disabled="!selectedMeetingRooms || !selectedMeetingRooms.length" /></div>
                </template>
            </Toolbar>
            <!-- <div class="mb-20" style="height: calc(100vh - 200px)"> -->
            <DataTable ref="dt" :value="meetingRooms" v-model:selection="selectedMeetingRooms" dataKey="id" responsiveLayout="stack" breakpoint="960px"
                :paginator="true" :rows="10" :filters="filters" :scrollable="true" scrollHeight="flex" stripedRows class="p-datatable-sm"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="แสดง {first} ถึง {last} จากทั้งหมด {totalRecords}">
                <template #header>
                    <div class="flex flex-col md:flex-row items-center justify-between">
						<h5 class="mb-2">จัดการห้องประชุม</h5>
						<span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Search..." />
                        </span>
					</div>
                </template>

                <Column selectionMode="multiple" :exportable="false" style="max-width:3rem"/>

                <Column header="รูปห้อง" >
                     <template #body="slotProps">
                        <img src="/storage/picture/no_image.jpg" :alt="slotProps.data.image" class="meeting_room-image" />
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
                        <div class="mr-1"><Button icon="pi pi-pencil" class="p-button-sm p-button-rounded p-button-success" @click="editMeetingRoom(slotProps.data)"/></div>
                        <div><Button icon="pi pi-trash" class="p-button-sm p-button-rounded p-button-warning" @click="confirmDeleteMeetingRoom(slotProps.data)"/></div>
                    </template>
                </Column>

            </DataTable>
            <!-- </div> -->

            <!-- สำหรับเพิ่มและแก้ไข ห้องประชุม -->
            <Dialog v-model:visible="meetingRoomDialog" :style="{width: '450px'}" header="ข้อมูลห้องประชุม" :modal="true" class="p-fluid">
                <div class="mt-4 mb-4">
                    <!-- <img src="/storage/picture/no_image.jpg" class="meetingRoom-image"/> -->
                    <img src="/storage/picture/no_image.jpg" :alt="mRoomForm.image" class="meetingRoom-image" v-if="mRoomForm.image"/>
                    <Button label="เพิ่ม/แก้ไขภาพ" icon="pi pi-plus" class="p-button-success p-button-sm" />
                 </div>
                <div class="mb-4">
                    <label for="room_full_name">ชื่อเต็มห้องประชุม</label>
                    <InputText id="room_full_name" v-model.trim="mRoomForm.fullname" required="true" :class="{'p-invalid': submitted && !mRoomForm.fullname}" />
                    <small class="p-error" v-if="submitted && !mRoomForm.fullname">จำเป็นต้องใส่ ชื่อเต็มห้องประชุม</small>
                </div>

                <div class="mb-4">
                    <label for="room_short_name">ชื่อย่อห้องประชุม</label>
                    <InputText id="room_short_name" v-model.trim="mRoomForm.shortname" required="true" :class="{'p-invalid': submitted && !mRoomForm.shortname}" />
                    <small class="p-error" v-if="submitted && !mRoomForm.shortname">จำเป็นต้องใส่ ชื่อย่อห้องประชุม</small>
                </div>

                <div class="grid grid-cols-2 space-x-2 mb-4">
                    <div>
                        <label for="building">ตึก/อาคาร</label>
                        <Dropdown id="building" v-model="mRoomForm.building_id" :options="building" optionLabel="full_name" placeholder="เลือกตึก/อาคาร" :class="{'p-invalid': submitted && !mRoomForm.building_id}">
                            <template #value="slotProps">
                                <div v-if="slotProps.value && slotProps.value.full_name">
                                    <span>{{slotProps.value.full_name}}</span>
                                </div>
                                <div v-else-if="slotProps.value && !slotProps.value.full_name">
                                    <span>{{getBuildingName(mRoomForm.building_id).full_name}}</span>
                                </div>
                                <span v-else>
                                    {{slotProps.placeholder}}
                                </span>
                            </template>
                        </Dropdown>
                        <small class="p-error" v-if="submitted && !mRoomForm.building_id">จำเป็นต้องเลือก ตึก/อาคาร</small>
                    </div>
                    <div>
                        <label for="floor">ชั้น</label>
                        <InputNumber id="floor" v-model="mRoomForm.floor" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.floor}" />
                        <small class="p-error" v-if="submitted && !mRoomForm.floor">จำเป็นต้องใส่ชั้น</small>
                    </div>
                </div>

                <div class="mb-4">
                    <div>
                        <label for="status">สถานะการใช้งาน</label>
                        <Dropdown id="status" v-model="mRoomForm.status" :options="statuses" optionLabel="label" placeholder="เลือกสถานะ" :class="{'p-invalid': submitted && !mRoomForm.status}">
                            <template #value="slotProps">
                                <div v-if="slotProps.value && slotProps.value.value">
                                    <span :class="'px-2 border-opacity-50 rounded-sm font-semibold status-' + slotProps.value.value.toLowerCase()">{{ slotProps.value.label }}</span>
                                </div>
                                <div v-else-if="slotProps.value && !slotProps.value.value">
                                    <span :class="'px-2 border-opacity-50 rounded-sm font-semibold status-' + mRoomForm.status.toLowerCase()">{{ thaiStatus(mRoomForm.status).label }}</span>
                                </div>
                                <span v-else>
                                    {{slotProps.placeholder}}
                                </span>
                            </template>
                        </Dropdown>
                        <small class="p-error" v-if="submitted && !mRoomForm.status">จำเป็นต้องเลือกสถานะการใช้งาน</small>
                    </div>
                </div>

                <div class="grid grid-cols-3 space-x-2 mb-4">
                    <div>
                        <label for="capacity_normal">ความจุปกติ</label>
                        <InputNumber id="capacity_normal" v-model="mRoomForm.capacity_normal" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.capacity_normal}" />
                        <small class="p-error" v-if="submitted && !mRoomForm.capacity_normal">จำเป็นต้องใส่</small>
                    </div>
                    <div>
                        <label for="capacity_min">ความจุน้อยสุด</label>
                        <InputNumber id="capacity_min" v-model="mRoomForm.capacity_min" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.capacity_min}" />
                        <small class="p-error" v-if="submitted && !mRoomForm.capacity_min">จำเป็นต้องใส่</small>
                    </div>
                    <div>
                        <label for="capacity_max">ความจุมากสุด</label>
                        <InputNumber id="capacity_max" v-model="mRoomForm.capacity_max" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.capacity_max}" />
                        <small class="p-error" v-if="submitted && !mRoomForm.capacity_max">จำเป็นต้องใส่</small>
                    </div>
                </div>

                <div class="grid grid-cols-2 space-x-2 mb-4">
                    <div>
                        <label for="price_half_day">ค่าจองครึ่งวัน</label>
                        <InputNumber id="price_half_day" v-model="mRoomForm.price_half_day" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.price_half_day}" />
                        <small class="p-error" v-if="submitted && !mRoomForm.price_half_day">จำเป็นต้องใส่</small>
                    </div>
                    <div>
                        <label for="price_full_day">ค่าจองเต็มวัน</label>
                        <InputNumber id="price_full_day" v-model="mRoomForm.price_full_day" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.price_full_day}" />
                        <small class="p-error" v-if="submitted && !mRoomForm.price_full_day">จำเป็นต้องใส่</small>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description">รายละเอียดเพิ่มเติม</label>
                    <Textarea id="description" v-model="mRoomForm.description" required="true" rows="3" cols="20" />
                </div>

                <template #footer>
                    <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
                    <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveMeetingRoom" />
                </template>
            </Dialog>
        </div>
    </div>
    <Toast position="top-right" />
    </AppLayout>
</template>

<script>
import { ref, onMounted, computed, reactive } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { FilterMatchMode } from 'primevue/api';
import { useToast } from "primevue/usetoast";

import MeetingRoomService from '@/Services/MeetingRoomService';

export default {
    setup() {
        onMounted(() => {
            meetingRoomService.value.getAllRoom().then(data => meetingRooms.value = data);
        })

        const toast = useToast();
        const dt = ref();
        const meetingRoom = ref({});
        const meetingRooms = ref([]);
        const meetingRoomService = ref(new MeetingRoomService());
        const selectedMeetingRooms = ref();
        const meetingRoomDialog = ref(false);
        const submitted = ref(false);
        const filters = ref({
            'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
        });
        const deleteMeetingRoomDialog = ref(false);
        const deleteMeetingRoomsDialog = ref(false);

        const building = ref([
            {id: 1, building_id: 1, full_name: 'อัษฎางค์', short_name: 'อฎ.'},
	     	{id: 2, building_id: 2, full_name: 'นวมินทรบพิตรฯ', short_name: 'นว.'},
        ]);

        const statuses = ref([
	     	{label: 'พร้อมใช้', value: 'READY'},
	     	{label: 'ปรับปรุง', value: 'RENOVATE'},
            {label: 'ซ่อมแซม', value: 'REPAIR'},
        ]);

        const mRoomForm = useForm({
            id: null,
            fullname: null,
            shortname: null,
            building_id: null,
            floor: null,
            status: null,
            capacity_normal: null,
            capacity_min: null,
            capacity_max: null,
            price_half_day: null,
            price_full_day: null,
            description: null,
            image: null
            //image: 'no_image.jpg'
        });

        const thaiStatus = (inputStatus) => {
            return statuses.value.find(status=>status.value === inputStatus)
        };

        const getBuildingName = (input_building_id) => {
            //console.log("Input B id = " + input_building_id)
            return building.value.find(bname=>bname.building_id === input_building_id)
        };

        const confirmDeleteSelected = () => {
            deleteMeetingRoomsDialog.value = true;
        };

        const confirmDeleteMeetingRoom = (mtr) => {
            meetingRoom.value = mtr;
            deleteMeetingRoomDialog.value = true;
        }

        const deleteSelectedMeetingRooms = () => {
            meetingRooms.value = meetingRooms.value.filter(val => !selectedMeetingRooms.value.includes(val));
            deleteMeetingRoomsDialog.value = false;
            selectedMeetingRooms.value = null;
            toast.add({severity:'success', summary: 'สำเร็จ', detail: 'ห้องประชุมที่เลือก ถูกลบแล้ว', life: 3000});
        };

        const deleteMeetingRoom = () => {
            // หาว่าห้องไหนไม่ใช่ห้องที่ลบ ก็จะนำมาแสดง ถ้าใช้กับ DB ก็สั่งลบตรงนี้ แล้วหา ห้องที่มีอยู่มาใหม่ แล้วใส่ตัวแปร ตามเดิม
            meetingRooms.value = meetingRooms.value.filter(val => val.id !== meetingRoom.value.id); 
            deleteMeetingRoomDialog.value = false;
            meetingRoom.value = {};
            toast.add({severity:'success', summary: 'Successful', detail: 'ห้องประชุมถูกลบเรียบร้อย', life: 3000});
        };

        const openNew = () => {
            //meetingRoom.value = {};
            mRoomForm.reset();
            submitted.value = false;
            meetingRoomDialog.value = true;
        };

        const hideDialog = () => {
            meetingRoomDialog.value = false;
            submitted.value = false;
        };

        const saveMeetingRoom = () => {
            submitted.value = true;
            //console.log(meetingRoom.value)
            // ใช้ตรวจสอบตัวแปร ว่ามีข้อมูลกรอกเข้ามาหรือไม่ ซึ่งถ้าไม่มีข้อมูล จะขึ้นเป็น undefine
            // if(!(meetingRoom.value.room_full_name && meetingRoom.value.room_short_name 
            //     && meetingRoom.value.building_id && meetingRoom.value.room_size && meetingRoom.value.status
            //    )) {
            if(! mRoomForm.fullname ) {
                console.log('meetingRoom Object is missing some value');
            } else {
                if(mRoomForm.id) {
                    console.log("Edit Data");
                    addMroomDataToForm(meetingRoom)
                    meetingRoom.value.status = meetingRoom.value.status.value ? meetingRoom.value.status.value : meetingRoom.value.status;
                    meetingRoom.value.building_id = meetingRoom.value.building_id.building_id ? meetingRoom.value.building_id.building_id : meetingRoom.value.building_id;
                    meetingRooms[findIndexById(meetingRoom.id)] = meetingRoom;
                    toast.add({severity:'success', summary: 'Successful', detail: 'แก้ไขข้อมูลห้องประชุมเรียบร้อย', life: 3000});
                    mRoomForm.reset()
                    console.log(meetingRooms);
                } else {
                    console.log("Add New Data");
                    //console.log("Before add to form")
                    //console.log(meetingRoom.value)
                    //addMroomDataToForm(meetingRoom)
                    // meetingRoom.value.building_id = meetingRoom.value.building_id.building_id;
                    // meetingRoom.value.status = meetingRoom.value.status.value ? meetingRoom.value.status.value : 'READY';
                    // meetingRoom.value.image = mRoomForm.image
                    //console.log(mRoomForm)
                    // ส่งข้อมูลไปที่ controller โดยใช้ form Helper
                    mRoomForm.transform(data => ({
                        ...data,
                        building_id: data.building_id.building_id,
                        status: data.status.value
                    })).post(route('add_meeting_room'), {
                        replace: true,
                        onBefore: () => {
                            // console.log("After add to form")
                            // console.log(meetingRoom.value)
                            //meetingRooms.value.push(meetingRoom.value);
                            //console.log(meetingRooms.value)
                        },
                        onSuccess: (page) => {
                            console.log(page)
                            // หลังจากเพิ่มข้อมูลลง DB ให้ get list ห้องมาใหม่เพื่อให้ datatable แสดงผลได้ถูกต้อง
                            meetingRoomService.value.getAllRoom().then(data => meetingRooms.value = data);
                            toast.add({severity:'success', summary: 'Successful', detail: 'เพิ่มข้อมูลห้องประชุมใหม่เรียบร้อย', life: 3000}); 
                            mRoomForm.reset()
                        },
                        onError: (errors) => {
                            console.log(errors)
                        },
                        onFinish: () => {
                            mRoomForm.processing = false 
                        }
                    });
                }
                meetingRoomDialog.value = false;
                meetingRoom.value = {};
            }
        };

        const addMroomDataToForm = (mRoom) => {
            //const tempRoom = {...mRoom}
            //console.log(mRoom.value)
            mRoomForm.id = mRoom.value.id ? mRoom.value.id : null
            mRoomForm.fullname = mRoom.value.fullname
            mRoomForm.shortname = mRoom.value.shortname
            mRoomForm.building_id = mRoom.value.building_id.building_id
            mRoomForm.floor = mRoom.value.floor
            mRoomForm.capacity_normal = mRoom.value.capacity_normal
            mRoomForm.capacity_min = mRoom.value.capacity_min
            mRoomForm.capacity_max = mRoom.value.capacity_max
            mRoomForm.price_half_day = mRoom.value.price_half_day
            mRoomForm.price_full_day = mRoom.value.price_full_day
            mRoomForm.status = mRoom.value.status.value
            mRoomForm.description = mRoom.value.description
            mRoomForm.image = mRoom.value.image ? mRoom.value.image : mRoomForm.image
        };

        const editMeetingRoom = (mRoom) => {
            meetingRoom.value = {...mRoom};
            meetingRoomDialog.value = true;
        };

        const findIndexById = (id) => {
            let index = -1;
            for (let i = 0; i < meetingRooms.value.length; i++) {
                if (meetingRooms.value[i].id === id) {
                    index = i;
                    break;
                }
            }

            return index;
        };

        return { 
            dt, meetingRooms, meetingRoom, mRoomForm, 
            filters, submitted,
            deleteMeetingRoomsDialog, deleteMeetingRoomDialog, building, selectedMeetingRooms,
            meetingRoomDialog, statuses, 
            openNew, hideDialog, confirmDeleteSelected, deleteSelectedMeetingRooms, confirmDeleteMeetingRoom,    //Method
            saveMeetingRoom, editMeetingRoom, thaiStatus, getBuildingName, findIndexById, deleteMeetingRoom,  //Method
            addMroomDataToForm,  //Method
        }
    }
}
</script>

<style scoped>

.meeting_room-image {
    width: 100px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
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