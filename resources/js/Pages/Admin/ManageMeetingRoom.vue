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
            <DataTable ref="dt" :value="meetingRooms" v-model:selection="selectedMeetingRooms" dataKey="id" 
                :paginator="true" :rows="10" :filters="filters" :scrollable="true" scrollHeight="flex" stripedRows class="p-datatable-sm"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="แสดง {first} ถึง {last} จากทั้งหมด {totalRecords}" responsiveLayout="scroll">
                <template #header>
                    <div class="flex flex-col md:flex-row items-center justify-between">
						<h5 class="mb-2">จัดการห้องประชุม</h5>
						<span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Search..." />
                        </span>
					</div>
                </template>

                <Column selectionMode="multiple" :exportable="false" />

                <!-- <Column field="id" header="#" :sortable="true" style="max-width:3rem"></Column> -->

                <Column header="รูปห้อง" >
                     <template #body="slotProps">
                        <img src="/storage/meeting_room.jpg" :alt="slotProps.data.image" class="meeting_room-image" />
                    </template>
                </Column>

                <!-- <Column field="room_full_name" header="ชื่อเต็ม" :sortable="true" style="min-width:10rem"></Column> -->
                <Column field="room_full_name" header="ชื่อเต็ม" :sortable="true" />
                
                <Column field="room_short_name" header="ชื่อย่อ" :sortable="true"  />

                <Column field="building_id" header="สถานที่" :sortable="true" >
                    <template #body="slotProps">
                        <span>ตึก {{getBuildingName(slotProps.data.building_id).full_name}} ชั้น {{slotProps.data.floor}}</span>
                    </template>
                </Column>

                <!-- <Column field="room_size" header="รองรับคนได้" :sortable="true" /> -->

                <Column field="status" header="สถานะ" :sortable="true" >
                    <template #body="slotProps">
                        <span :class="'px-2 border-opacity-50 rounded-sm font-semibold status-' + (slotProps.data.status ? slotProps.data.status.toLowerCase() : '')">{{ thaiStatus(slotProps.data.status).label }}</span>
                    </template>
                </Column>

                <Column :exportable="false" >
                    <template #body="slotProps">
                        <div class="mr-2"><Button icon="pi pi-pencil" class="p-button-sm p-button-rounded p-button-success" @click="editMeetingRoom(slotProps.data)"/></div>
                        <div><Button icon="pi pi-trash" class="p-button-sm p-button-rounded p-button-warning" @click="confirmDeleteMeetingRoom(slotProps.data)"/></div>
                    </template>
                </Column>

            </DataTable>
            <!-- </div> -->
        </div>

        <Dialog v-model:visible="deleteMeetingRoomsDialog" :style="{width: '450px'}" header="ยืนยัน" :modal="true">
            <div class="flex items-center justify-center">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span v-if="meetingRooms">คุณต้องการลบห้องประชุม ทั้งหมด ที่เลือกไว้ ?</span>
            </div>
            <template #footer>
                <Button label="ไม่ใช่" icon="pi pi-times" @click="deleteMeetingRoomsDialog = false"/>
                <Button label="ใช่" icon="pi pi-check" class="p-button-raised p-button-text p-button-danger" @click="deleteSelectedMeetingRooms" />
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteMeetingRoomDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
            <div class="confirmation-content">
                <i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem" />
                <span v-if="meetingRoom">คุณต้องการลบห้องประชุม <b>{{meetingRoom.room_full_name}}</b>?</span>
            </div>
            <template #footer>
                <Button label="ไม่" icon="pi pi-times" class="p-button-text" @click="deleteMeetingRoomDialog = false"/>
                <Button label="ใช่" icon="pi pi-check" class="p-button-text" @click="deleteMeetingRoom" />
            </template>
        </Dialog>

        <Dialog v-model:visible="meetingRoomDialog" :style="{width: '450px'}" header="ข้อมูลห้องประชุม" :modal="true" class="p-fluid">
            <img src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" :alt="meetingRoom.image" class="meetingRoom-image" v-if="meetingRoom.image" />
            <div v-if="!meetingRoom.value">
                <img src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" class="meetingRoom-image"/>
            </div>
            <div class="mb-4">
                <label for="room_full_name">ชื่อเต็มห้องประชุม</label>
                <InputText id="room_full_name" v-model.trim="meetingRoom.room_full_name" required="true" :class="{'p-invalid': submitted && !meetingRoom.room_full_name}" />
                <small class="p-error" v-if="submitted && !meetingRoom.room_full_name">จำเป็นต้องใส่ ชื่อเต็มห้องประชุม</small>
            </div>

            <div class="mb-4">
                <label for="room_short_name">ชื่อย่อห้องประชุม</label>
                <InputText id="room_short_name" v-model.trim="meetingRoom.room_short_name" required="true" :class="{'p-invalid': submitted && !meetingRoom.room_short_name}" />
                <small class="p-error" v-if="submitted && !meetingRoom.room_short_name">จำเป็นต้องใส่ ชื่อย่อห้องประชุม</small>
            </div>

            <div class="grid grid-cols-2 space-x-2 mb-4">
                <div>
                    <label for="building">ตึก/อาคาร</label>
                    <Dropdown id="building" v-model="meetingRoom.building_id" :options="building" optionLabel="full_name" placeholder="เลือกตึก/อาคาร" :class="{'p-invalid': submitted && !meetingRoom.building_id}">
                        <template #value="slotProps">
                            <div v-if="slotProps.value && slotProps.value.full_name">
                                <span>{{slotProps.value.full_name}}</span>
                            </div>
                            <div v-else-if="slotProps.value && !slotProps.value.full_name">
                                <span>{{getBuildingName(meetingRoom.building_id).full_name}}</span>
                            </div>
                            <span v-else>
                                {{slotProps.placeholder}}
                            </span>
                        </template>
				    </Dropdown>
                    <small class="p-error" v-if="submitted && !meetingRoom.building_id">จำเป็นต้องเลือก ตึก/อาคาร</small>
                </div>
                <div>
                    <label for="floor">ชั้น</label>
                    <InputNumber id="floor" v-model="meetingRoom.floor" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.floor}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.floor">จำเป็นต้องใส่ชั้น</small>
                </div>
            </div>

            <div class="mb-4">
                <div>
                    <label for="status">สถานะการใช้งาน</label>
                    <Dropdown id="status" v-model="meetingRoom.status" :options="statuses" optionLabel="label" placeholder="เลือกสถานะ" :class="{'p-invalid': submitted && !meetingRoom.status}">
                        <template #value="slotProps">
                            <div v-if="slotProps.value && slotProps.value.value">
                                <span :class="'px-2 border-opacity-50 rounded-sm font-semibold status-' + slotProps.value.value.toLowerCase()">{{ slotProps.value.label }}</span>
                            </div>
                            <div v-else-if="slotProps.value && !slotProps.value.value">
                                <span :class="'px-2 border-opacity-50 rounded-sm font-semibold status-' + meetingRoom.status.toLowerCase()">{{ thaiStatus(meetingRoom.status).label }}</span>
                            </div>
                            <span v-else>
                                {{slotProps.placeholder}}
                            </span>
                        </template>
				    </Dropdown>
                    <small class="p-error" v-if="submitted && !meetingRoom.status">จำเป็นต้องเลือกสถานะการใช้งาน</small>
                </div>
                <!-- <div>
                    <label for="room_size">รองรับผู้เข้าร่วมประชุม</label>
                    <InputNumber id="room_size" v-model="meetingRoom.room_size" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.room_size}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.room_size">จำเป็นต้องใส่จำนวนคนที่รองรับ</small>
                </div> -->
            </div>

            <div class="grid grid-cols-3 space-x-2 mb-4">
                <div>
                    <label for="capacity_normal">ความจุปกติ</label>
                    <InputNumber id="capacity_normal" v-model="meetingRoom.capacity_normal" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.capacity_normal}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.capacity_normal">จำเป็นต้องใส่</small>
                </div>
                <div>
                    <label for="capacity_min">ความจุน้อยสุด</label>
                    <InputNumber id="capacity_min" v-model="meetingRoom.capacity_min" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.capacity_min}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.capacity_min">จำเป็นต้องใส่</small>
                </div>
                <div>
                    <label for="capacity_max">ความจุมากสุด</label>
                    <InputNumber id="capacity_max" v-model="meetingRoom.capacity_max" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.capacity_max}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.capacity_max">จำเป็นต้องใส่</small>
                </div>
            </div>

            <div class="grid grid-cols-2 space-x-2 mb-4">
                <div>
                    <label for="price_half_day">ค่าจองครึ่งวัน</label>
                    <InputNumber id="price_half_day" v-model="meetingRoom.price_half_day" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.price_half_day}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.price_half_day">จำเป็นต้องใส่</small>
                </div>
                <div>
                    <label for="price_full_day">ค่าจองเต็มวัน</label>
                    <InputNumber id="price_full_day" v-model="meetingRoom.price_full_day" required="true" integeronly :class="{'p-invalid': submitted && !meetingRoom.price_full_day}" />
                    <small class="p-error" v-if="submitted && !meetingRoom.price_full_day">จำเป็นต้องใส่</small>
                </div>
            </div>

            <div class="mb-6">
                <label for="description">รายละเอียดเพิ่มเติม</label>
                <Textarea id="description" v-model="meetingRoom.description" required="true" rows="3" cols="20" />
            </div>

            <template #footer>
                <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
                <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveMeetingRoom" />
            </template>
        </Dialog>

	</div>

    <Toast position="top-right" />
    </AppLayout>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from "primevue/usetoast";

//import MeetingRoomService from '@/Services/MeetingRoomService';

export default {
    // components: {
    //     Toolbar, InputText, DataTable, Column, Dialog, useToast, Toast, Textarea, Dropdown, RadioButton, InputNumber  
    // },

    setup() {
        // onMounted(() => {
        //     meetingRoomService.value.getAllRoom().then(data => meetingRooms.value = data);
        // })

        const toast = useToast();
        const dt = ref();
        const meetingRoom = ref({});
        const meetingRooms = ref([]);
        //const meetingRoomService = ref(new MeetingRoomService());
        const selectedMeetingRooms = ref();
        const meetingRoomDialog = ref(false);
        const submitted = ref(false);
        const filters = ref({
            'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
        });
        const deleteMeetingRoomDialog = ref(false);
        const deleteMeetingRoomsDialog = ref(false);

        //const selectedBuilding = ref();
        const building = ref([
            {id: 11, building_id: 1, full_name: 'อัษฎางค์', short_name: 'อฎ.'},
	     	{id: 21, building_id: 2, full_name: 'นวมินทรบพิตรฯ', short_name: 'นว.'},
        ]);

        // const building = ref([
        //     {building_id: 1, full_name: 'อัษฎางค์'},
	    //  	{building_id: 2, full_name: 'นวมินทรบพิตรฯ'},
        // ]);

        //const selectedStatus = ref();
        const statuses = ref([
	     	{label: 'พร้อมใช้', value: 'READY'},
	     	{label: 'ปรับปรุง', value: 'RENOVATE'},
            {label: 'ซ่อมแซม', value: 'REPAIR'},
        ]);

        // const thaiStatus = computed( () => {
            
        // })
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
            meetingRoom.value = {};
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
            if(!(meetingRoom.value.room_full_name && meetingRoom.value.room_short_name 
                && meetingRoom.value.building_id && meetingRoom.value.room_size && meetingRoom.value.status
               )) {
                console.log('meetingRoom Object is missing some value');
            } else {
                if(meetingRoom.value.id) {
                    meetingRoom.value.status = meetingRoom.value.status.value ? meetingRoom.value.status.value : meetingRoom.value.status;
                    meetingRoom.value.building_id = meetingRoom.value.building_id.building_id ? meetingRoom.value.building_id.building_id : meetingRoom.value.building_id;
                    console.log("Edit Data");
                    //console.log(meetingRoom.value.status);
                    // console.log(meetingRoom.value.id);
                    // console.log(findIndexById(meetingRoom.value.id));
                    meetingRooms.value[findIndexById(meetingRoom.value.id)] = meetingRoom.value;
                    //meetingRooms.value.splice(findIndexById(meetingRoom.value.id), 1, meetingRoom.value)
                    toast.add({severity:'success', summary: 'Successful', detail: 'แก้ไขข้อมูลห้องประชุมเรียบร้อย', life: 3000});
                    console.log(meetingRooms.value);
                } else {
                    if(typeof meetingRoom.value.building_id === "object") {
                        console.log("Add New Data");
                        // ใช้ชั่วคราวสำหรับทดสอบ เพื่อเพิ่ม id ให้กับห้องประชุมที่ add เพิ่ม
                        meetingRoom.value.id = parseInt(meetingRooms.value.length) + 1 
                        meetingRoom.value.building_id = meetingRoom.value.building_id.building_id;
                        meetingRoom.value.status = meetingRoom.value.status.value ? meetingRoom.value.status.value : 'READY';
                        //console.log(meetingRoom.value);
                        meetingRooms.value.push(meetingRoom.value);
                        toast.add({severity:'success', summary: 'Successful', detail: 'เพิ่มข้อมูลห้องประชุมใหม่เรียบร้อย', life: 3000});
                    }
                }
                meetingRoomDialog.value = false;
                meetingRoom.value = {};
            }

			// if (meetingRoom.value.room_full_name.trim()) {
            //     if (meetingRoom.value.id) {
            //         meetingRoom.value.inventoryStatus = meetingRoom.value.inventoryStatus.value ? meetingRoom.value.inventoryStatus.value : meetingRoom.value.inventoryStatus;
            //         meetingRooms.value[findIndexById(meetingRoom.value.id)] = meetingRoom.value;
            //         toast.add({severity:'success', summary: 'Successful', detail: 'meetingRoom Updated', life: 3000});
            //     }
            //     else {
            //         meetingRoom.value.id = createId();
            //         meetingRoom.value.code = createId();
            //         meetingRoom.value.image = 'meetingRoom-placeholder.svg';
            //         meetingRoom.value.inventoryStatus = meetingRoom.value.inventoryStatus ? meetingRoom.value.inventoryStatus.value : 'INSTOCK';
            //         meetingRooms.value.push(meetingRoom.value);
            //         toast.add({severity:'success', summary: 'Successful', detail: 'meetingRoom Created', life: 3000});
            //     }

            //     meetingRoomDialog.value = false;
            //     meetingRoom.value = {};
            // }
        };

        const editMeetingRoom = (mRoom) => {
            meetingRoom.value = {...mRoom};
            console.log(meetingRoom.value)
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
            dt, meetingRooms, meetingRoom, 
            filters, submitted,
            deleteMeetingRoomsDialog, deleteMeetingRoomDialog, building, selectedMeetingRooms,
            meetingRoomDialog, statuses, 
            openNew, hideDialog, confirmDeleteSelected, deleteSelectedMeetingRooms, confirmDeleteMeetingRoom,    //Method
            saveMeetingRoom, editMeetingRoom, thaiStatus, getBuildingName, findIndexById, deleteMeetingRoom  //Method
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