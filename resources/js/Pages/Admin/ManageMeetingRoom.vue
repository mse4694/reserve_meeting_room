<template>
    <AppLayout>
    <!-- <div class="card"> -->
    <Card>
        <!-- <template #header>
            <div class="text-xl border-double border-b-2 border-opacity-25 border-blue-500 mt-2 mb-4 ml-2">ข้อมูลห้องประชุม</div>
        </template> -->
        <template #content>
            <div class="ml-4 mr-4">
                <Toolbar>
                    <template #left>
                        <div class="mt-2 px-2"><Button label="เพิ่มห้องประชุม" icon="pi pi-plus" class="p-button-success p-button-sm" @click="openNew"/></div>
                        <!-- <div class="mt-2"><Button label="ลบ" icon="pi pi-trash" class="p-button-warning p-button-sm"  @click="confirmDeleteSelected" :disabled="!selectedMeetingRooms || !selectedMeetingRooms.length" /></div> -->
                    </template>
                    <template #right>
                        <!-- <Link :href="route('recycle_bin_meeting_room')"> -->
                        <div class="mt-2"><Button label="ลบห้องประชุมแบบถาวร" icon="pi pi-trash" class="p-button-danger p-button-sm" :badge="countDeletedMeetingRooms.toString()" badgeClass="p-badge-info" :disabled="countDeletedMeetingRooms === 0" @click="gotoRecycleBin"/></div>
                        <!-- </Link> -->
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

                    <!-- <Column selectionMode="multiple" :exportable="false" style="max-width:3rem"/> -->
                    <!-- <Column selectionMode="single" :exportable="false" style="max-width:3rem"/> -->

                    <Column header="รูปห้อง" >
                        <template #body="slotProps">
                            <!-- <Image :src="`/storage/picture/${slotProps.data.image1}`" :alt="slotProps.data.image2" class="meeting_room-image" preview /> -->
                            <img :src="`/storage/picture/${slotProps.data.image1}`" :alt="slotProps.data.image2" class="meeting_room-image" @click="showGallery(slotProps.data)"/>
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
                <!-- <Dialog v-model:visible="meetingRoomDialog" :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '450px'}" header="ข้อมูลห้องประชุม" :modal="true" class="p-fluid"> -->
                <Dialog v-model:visible="meetingRoomDialog" :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '50vw'}" header="ข้อมูลห้องประชุม" :modal="true" class="p-fluid">
                    <div class="mt-4 mb-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 mb-4">
                            <!-- <div>
                                <input
                                    type="file"
                                    @input="mRoomForm.image1 = $event.target.files[0]"
                                    @change="previewImage1"
                                    ref="photo1"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                />
                                <img v-if="url1" :src="url1" class="w-30 mt-4 h-20"/>
                                <div v-if="errors.image1" class="font-bold text-red-600">{{ errors.image1 }}</div>
                            </div> -->
                            <div class="flex flex-col w-full mt-2 mb-4 px-2">
                                <div class="w-full h-10 p-2 bg-grey-lighter">
                                    <label class="flex flex-col items-center px-2 bg-white text-blue-400 rounded-lg shadow-lg tracking-wide uppercase border border-blue-400 cursor-pointer hover:bg-blue-400 hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                        </svg>
                                        <span class="mt-2 text-base leading-normal">เลือกรูปที่ 1</span> 
                                        <input type="file" @input="mRoomForm.image1 = $event.target.files[0]" @change="previewImage1" class="hidden">
                                    </label>
                                </div>
                                <img v-if="url1" :src="url1" class="w-30 h-20 mt-8"/>
                            </div>
                            <div class="flex flex-col w-full mt-2 mb-4 px-2">
                                <div class="w-full h-10 p-2 bg-grey-lighter">
                                    <label class="flex flex-col items-center px-2 bg-white text-blue-400 rounded-lg shadow-lg tracking-wide uppercase border border-blue-400 cursor-pointer hover:bg-blue-400 hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                        </svg>
                                        <span class="mt-2 text-base leading-normal">เลือกรูปที่ 2</span> 
                                        <input type="file" @input="mRoomForm.image2 = $event.target.files[0]" @change="previewImage2" class="hidden">
                                    </label>
                                </div>
                                <img v-if="url2" :src="url2" class="w-30 h-20 mt-8"/>
                            </div>
                            <div class="flex flex-col w-full mt-2 mb-4 px-2">
                                <div class="w-full h-10 p-2 bg-grey-lighter">
                                    <label class="flex flex-col items-center px-2 bg-white text-blue-400 rounded-lg shadow-lg tracking-wide uppercase border border-blue-400 cursor-pointer hover:bg-blue-400 hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                        </svg>
                                        <span class="mt-2 text-base leading-normal">เลือกรูปที่ 3</span> 
                                        <input type="file" @input="mRoomForm.image3 = $event.target.files[0]" @change="previewImage3" class="hidden">
                                    </label>
                                </div>
                                <img v-if="url3" :src="url3" class="w-30 h-20 mt-8"/>
                            </div>
                        </div>
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
                            <InputNumber id="price_half_day" v-model="mRoomForm.price_half_day" mode="currency" currency="THB" locale="th-TH" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.price_half_day}" />
                            <small class="p-error" v-if="submitted && !mRoomForm.price_half_day">จำเป็นต้องใส่</small>
                        </div>
                        <div>
                            <label for="price_full_day">ค่าจองเต็มวัน</label>
                            <InputNumber id="price_full_day" v-model="mRoomForm.price_full_day" mode="currency" currency="THB" locale="th-TH" required="true" integeronly :class="{'p-invalid': submitted && !mRoomForm.price_full_day}" />
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

                <!-- สำหรับลบห้องประชุมทีละหลายๆห้องจากปุ่มลบบน Header -->
                <Dialog v-model:visible="deleteMeetingRoomsDialog" :style="{width: '450px'}" header="ยืนยัน" :modal="true">
                    <div class="flex items-center justify-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem; color: #e65c00" />
                        <span v-if="meetingRooms">คุณต้องการลบห้องประชุม ทั้งหมด ที่เลือกไว้ ?</span>
                    </div>
                    <template #footer>
                        <Button label="ไม่ใช่" icon="pi pi-times" class="p-button-sm" @click="deleteMeetingRoomsDialog = false"/>
                        <Button label="ใช่" icon="pi pi-check" class="p-button-raised p-button-text p-button-danger p-button-sm" @click="deleteSelectedMeetingRooms" />
                    </template>
                </Dialog>

                <!-- สำหรับลบห้องประชุมจากปุ่มลบของ Row ตัวเอง-->
                <Dialog v-model:visible="deleteMeetingRoomDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem; color: #e65c00" />
                        <span v-if="meetingRoom">คุณต้องการลบห้องประชุม <b>{{meetingRoom.fullname}}</b> แบบชั่วคราว ?</span>
                    </div>
                    <template #footer>
                        <Button label="ไม่ใช่" icon="pi pi-times" class="p-button-sm" @click="deleteMeetingRoomDialog = false"/>
                        <Button label="ใช่" icon="pi pi-check" class="p-button-raised p-button-text p-button-danger p-button-sm" @click="deleteMeetingRoom" />
                    </template>
                </Dialog>

                <!-- สำหรับแสดงรูปห้องประชุม -->
                <Dialog v-model:visible="showGalleryDialog" :style="{width: '600px'}" :modal="true">
                    <Galleria :value="images" :showThumbnails="false" :showIndicators="true" :showItemNavigators="true">
                        <template #item="slotProps">
                            <img :src="slotProps.item.itemImageSrc"/>
                        </template>
                    </Galleria>
                </Dialog>

            </div>
        </template>
    <!-- </div> -->
    </Card>
    <Toast position="top-right" />
    </AppLayout>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import { FilterMatchMode } from 'primevue/api';
import { useToast } from "primevue/usetoast";

import MeetingRoomService from '@/Services/MeetingRoomService';

export default {
    props: {
        errors: Object,
        mrooms_tranform: Array,
        dmrooms: Number,
    },

    components: {
        Link,
    },

    setup() {
        onMounted(() => {
            //meetingRoomService.value.getAllRoom().then(data => meetingRooms.value = data);
            //meetingRoomService.value.getAllDeleteRoom().then(data => deletedMeetingRooms.value = data);
            
            //console.log(usePage().props.value.mrooms_tranform);
            meetingRooms.value = usePage().props.value.mrooms_tranform
            deletedMeetingRooms.value = usePage().props.value.dmrooms
        })

        const toast = useToast();
        const dt = ref();
        const meetingRoom = ref({});
        const meetingRooms = ref([]);
        const deletedMeetingRooms = ref([]);
        const showDeletedMeetingRooms = ref(false);
        const meetingRoomService = ref(new MeetingRoomService());
        const selectedMeetingRooms = ref();
        const meetingRoomDialog = ref(false);
        const submitted = ref(false);
        const filters = ref({
            'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
        });
        const deleteMeetingRoomDialog = ref(false);
        const deleteMeetingRoomsDialog = ref(false);
        const showGalleryDialog = ref(false);

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
            image1: 'no_image.jpg',
            image2: 'no_image.jpg',
            image3: 'no_image.jpg'
        });

        const url1 = ref(null);
        const url2 = ref(null);
        const url3 = ref(null);
        const images = ref([]);

        const countDeletedMeetingRooms = computed(() => { return deletedMeetingRooms.value })

        const thaiStatus = (inputStatus) => {
            return statuses.value.find(status=>status.value === inputStatus)
        };

        const getBuildingName = (input_building_id) => {
            return building.value.find(bname=>bname.building_id === input_building_id)
        };

        const gotoRecycleBin = () => {
            Inertia.get( route('recycle_bin_meeting_room') )
        }

        const confirmDeleteSelected = () => {
            deleteMeetingRoomsDialog.value = true;
        };

        const confirmDeleteMeetingRoom = (mRoom) => {
            meetingRoom.value = mRoom;
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
            //meetingRooms.value = meetingRooms.value.filter(val => val.id !== meetingRoom.value.id); 
            Inertia.delete(route('delete_meeting_room_tempolary', meetingRoom.value.id), {
                //onBefore: () => confirm('Are you sure you want to delete this user?'),
                onSuccess: () => {
                    // หลังจากเพิ่มข้อมูลลง DB ให้ get list ห้องมาใหม่เพื่อให้ datatable แสดงผลได้ถูกต้อง
                    meetingRooms.value = usePage().props.value.mrooms_tranform
                    deletedMeetingRooms.value = usePage().props.value.dmrooms
                    toast.add({severity:'success', summary: 'Successful', detail: 'ลบห้องประชุมแบบชั่วคราวเรียบร้อย', life: 3000});
                },
                onError: (errors) => {
                    console.log(errors)
                },
                onFinish: () => {
                    deleteMeetingRoomDialog.value = false;
                    meetingRoom.value = {};
                }
            })
        };

        const editMeetingRoom = (mRoom) => {
            meetingRoom.value = {...mRoom};
            //mRoomForm.reset();
            addMroomDataToForm(meetingRoom)
            url1.value = `${base_url}/storage/picture/${mRoomForm.image1}`
            url2.value = `${base_url}/storage/picture/${mRoomForm.image2}`
            url3.value = `${base_url}/storage/picture/${mRoomForm.image3}`
            //console.log(url1.value)
            meetingRoomDialog.value = true;
        };

        const openNew = () => {
            meetingRoom.value = {};
            url1.value = null;
            url2.value = null;
            url3.value = null;
            submitted.value = false;
            meetingRoomDialog.value = true;
        };

        const hideDialog = () => {
            mRoomForm.reset();
            url1.value = null;
            url2.value = null;
            url3.value = null;
            meetingRoomDialog.value = false;
            submitted.value = false;
        };

        const checkRequireData = () => {
            if( mRoomForm.fullname && mRoomForm.shortname && mRoomForm.building_id && mRoomForm.floor && mRoomForm.status 
                && mRoomForm.capacity_normal && mRoomForm.capacity_min && mRoomForm.capacity_max 
                && mRoomForm.price_half_day && mRoomForm.price_full_day) 
            {
                return true
            } else {
                return false
            }
        };

        const saveMeetingRoom = () => {
            submitted.value = true;
            if(! checkRequireData() ) {
                console.log('ยังระบุรายละเอียดห้องประชุมไม่ครบถ้วน');
                toast.add({severity:'warn', summary: 'Warning', detail: 'ยังระบุรายละเอียดห้องประชุมไม่ครบถ้วน', life: 3000});
            } else {
                if(mRoomForm.id) {
                    console.log("Edit Data");
                    //meetingRooms[findIndexById(meetingRoom.id)] = meetingRoom;
                    mRoomForm.transform(data => ({
                        ...data,
                        oldimage1: meetingRoom.value.image1,
                        oldimage2: meetingRoom.value.image2,
                        oldimage3: meetingRoom.value.image3
                    })).post(`/mroom/${mRoomForm.id}/update`, {
                        // replace: true,
                        // onBefore: () => {
                        // },
                        onSuccess: () => {
                            //console.log(page)
                            // หลังจากเพิ่มข้อมูลลง DB ให้ get list ห้องมาใหม่เพื่อให้ datatable แสดงผลได้ถูกต้อง
                            meetingRooms.value = usePage().props.value.mrooms_tranform
                            deletedMeetingRooms.value = usePage().props.value.dmrooms
                            toast.add({severity:'success', summary: 'Successful', detail: 'แก้ไขข้อมูลห้องประชุมเรียบร้อย', life: 3000});
                        },
                        onError: (errors) => {
                            console.log(errors)
                        },
                        onFinish: () => {
                            mRoomForm.processing = false 
                        }
                    });
                } else {
                    console.log("Add New Data");
                    // ส่งข้อมูลไปที่ controller โดยใช้ form Helper
                    mRoomForm.transform(data => ({
                        ...data,
                        building_id: data.building_id.building_id,
                        status: data.status.value,
                        image1: data.image1,
                        image2: data.image2,
                        image3: data.image3
                    })).post(route('add_meeting_room'), {
                        forceFormData: true,
                        replace: true,
                        onBefore: () => {
                        },
                        onSuccess: (page) => {
                            //console.log(page)
                            // หลังจากเพิ่มข้อมูลลง DB ให้ get list ห้องมาใหม่เพื่อให้ datatable แสดงผลได้ถูกต้อง
                            meetingRooms.value = usePage().props.value.mrooms_tranform
                            deletedMeetingRooms.value = usePage().props.value.dmrooms
                            toast.add({severity:'success', summary: 'Successful', detail: 'เพิ่มข้อมูลห้องประชุมใหม่เรียบร้อย', life: 3000}); 
                        },
                        onError: (errors) => {
                            console.log(errors)
                        },
                        onFinish: () => {
                            mRoomForm.processing = false 
                        }
                    });
                }
                mRoomForm.reset()
                submitted.value = false;
                meetingRoomDialog.value = false;
                meetingRoom.value = {};
            }
        };

        const addMroomDataToForm = (mRoom) => {
            mRoomForm.id = mRoom.value.id ? mRoom.value.id : null
            mRoomForm.fullname = mRoom.value.fullname
            mRoomForm.shortname = mRoom.value.shortname
            mRoomForm.building_id = mRoom.value.building_id
            mRoomForm.floor = mRoom.value.floor
            mRoomForm.capacity_normal = mRoom.value.capacity_normal
            mRoomForm.capacity_min = mRoom.value.capacity_min
            mRoomForm.capacity_max = mRoom.value.capacity_max
            mRoomForm.price_half_day = mRoom.value.price_half_day
            mRoomForm.price_full_day = mRoom.value.price_full_day
            mRoomForm.status = mRoom.value.status
            mRoomForm.description = mRoom.value.description
            mRoomForm.image1 = mRoom.value.image1 ? mRoom.value.image1 : mRoomForm.image1
            mRoomForm.image2 = mRoom.value.image2 ? mRoom.value.image2 : mRoomForm.image2
            mRoomForm.image3 = mRoom.value.image3 ? mRoom.value.image3 : mRoomForm.image3
        };

        const previewImage1 = (e) => {
            const file = e.target.files[0];
            //console.log(file)
            if( file ) {
                url1.value = URL.createObjectURL(file);
            } else {
                url1.value = `${base_url}/storage/picture/no_image.jpg`
            }
        };
        const previewImage2 = (e) => {
            const file = e.target.files[0];
            if( file ) {
                url2.value = URL.createObjectURL(file);
            } else {
                url2.value = `${base_url}/storage/picture/no_image.jpg`
            }
        };
        const previewImage3 = (e) => {
            const file = e.target.files[0];
            if( file ) {
                url3.value = URL.createObjectURL(file);
            } else {
                url3.value = `${base_url}/storage/picture/no_image.jpg`
            }
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

        const showGallery = (mRoom) => {
            images.value = []
            const imagetmp = {...mRoom};
            const image1 = `${base_url}/storage/picture/${imagetmp.image1}`
            const image2 =  `${base_url}/storage/picture/${imagetmp.image2}`
            const image3 =  `${base_url}/storage/picture/${imagetmp.image3}`
            //console.log(imagetmp.image1)
            images.value.push({"itemImageSrc": image1})
            images.value.push({"itemImageSrc": image2})
            images.value.push({"itemImageSrc": image3})

            //console.log(images.value)
            showGalleryDialog.value = true
        }

        return { 
            dt, meetingRooms, meetingRoom, mRoomForm, url1, url2, url3, images, 
            filters, submitted, deletedMeetingRooms, showDeletedMeetingRooms,
            deleteMeetingRoomsDialog, deleteMeetingRoomDialog, building, selectedMeetingRooms,
            meetingRoomDialog, showGalleryDialog, statuses,
            openNew, hideDialog, confirmDeleteSelected, deleteSelectedMeetingRooms, confirmDeleteMeetingRoom,    //Method
            saveMeetingRoom, editMeetingRoom, thaiStatus, getBuildingName, findIndexById, deleteMeetingRoom, gotoRecycleBin, //Method
            addMroomDataToForm, previewImage1, previewImage2, previewImage3, showGallery, countDeletedMeetingRooms, checkRequireData  //Method
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