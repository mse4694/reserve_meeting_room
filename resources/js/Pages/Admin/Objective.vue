<template>
<AppLayout>
    <!-- <div>
        1   การประชุม		
        2	การเรียน/การสอนก่อนปริญญา		
        3	การเรียน/การสอนหลังปริญญา		
        4	จัดเลี้ยง/พิธีการ		
        5	บรรยาย/อบรม		
        6	ซ่อมบำรุง		
        7	แนะนำและออกบูชแสดงผลิตภัณฑ์		
        8	อื่นๆ
    </div> -->
    <Card>
        <template #content>
        
            <div class="ml-4 mr-4">
                <Toolbar>
                    <template #left>
                        <div class="mt-2 px-2"><Button label="เพิ่มวัตถุประสงค์" icon="pi pi-plus" class="p-button-success p-button-sm" @click="openNew"/></div>
                    </template>
                </Toolbar>
                <!-- start  -->
                <!-- <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30">
                    <div class="flex p-3 border-l-8 border-yellow-600">
                        <div class="space-y-1 border-r-2 pr-3">
                        <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500"> สร้างเมื่อ #</span> LTC08762304</div>
                        <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500 pr"> แก้ไขเมื่อ #</span> 10937</div>
                        <div class="text-sm leading-5 font-semibold">JUN 14. 9:30 PM</div>
                        </div>
                        <div class="flex-1">
                        <div class="ml-3 space-y-1 border-r-2 pr-3">
                            <div class="text-base leading-6 font-normal">การเรียน/การสอนก่อนปริญญา</div>
                            <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Carrier</span> PAPER TRANSPORT INC.</div>
                            <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Destination</span> WestRock Jacksonville - 9469 Eastport Rd, Jacksonville, FL 32218</div>
                        </div>
                        </div>
                        <div class="border-r-2 pr-3">
                        <div >
                            <div class="ml-3 my-3 border-gray-200 border-2 bg-gray-300 p-1">
                                <div class="uppercase text-xs leading-4 font-medium">Trailer</div>
                                <div class="text-center text-sm leading-4 font-semibold text-gray-800">89732</div>
                            </div>
                        </div>
                        </div>
                        <div>
                        <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Loaded</div>
                        </div>
                        </div>
                        <div>
                        <button class="text-gray-100 rounded-sm my-5 ml-2 focus:outline-none bg-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        </div>
                    </div>
                </div> -->
                <!-- end -->

                <!-- <div class="bg-gray-100 mx-auto border-gray-500 border rounded-md text-gray-700 mb-0.5 mt-0.5 h-19">
                    <div class="flex p-1 border-l-8 border-blue-600 rounded-md">
                        <div class="space-y-1 border-r-2 pr-3">
                            <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500"> สร้างเมื่อ #</span> 1/10/2564 20:20</div>
                            <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500 pr"> แก้ไขเมื่อ #</span> - </div>
                        </div>
                        <div class="flex-1">
                            <div class="ml-3 space-y-1 border-r-2 pr-3 mr-1">
                                <div class="text-base leading-6 font-normal">การเรียน/การสอนก่อนปริญญา</div>
                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> เพื่อใช้สำหรับเรียน หรือ สอน นศพ. ชั้นปี 4-6 หรือนัดสอบต่างๆ</span> </div>
                            </div>
                        </div>
     
                        <div class=" flex flex-col sm:flex-row">
                            <div class="mr-1"><Button icon="pi pi-pencil" class="p-button-sm p-button-rounded p-button-success" /></div>
                            <div class="mr-1"><Button icon="pi pi-trash" class="p-button-sm p-button-rounded p-button-warning" /></div>
                        </div>   
                    </div>
                </div> -->

                <!-- <div v-for="obj in objectives" :key="obj.id" class="bg-gray-100 mx-auto border-gray-500 border rounded-md text-gray-700 mb-0.5 mt-0.5 h-19">
                    <div class="flex p-1 border-l-8 border-blue-600 rounded-md">
                        <div class="space-y-1 border-r-2 pr-3">
                            <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500"> สร้างเมื่อ #</span> {{ obj.create }}</div>
                            <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500 pr"> แก้ไขเมื่อ #</span> {{ obj.update }} </div>
                        </div>
                        <div class="flex-1">
                            <div class="ml-3 space-y-1 border-r-2 pr-3 mr-1">
                                <div class="text-base leading-6 font-normal">{{ obj.objective }}</div>
                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> {{ obj.detail }}</span> </div>
                            </div>
                        </div>
     
                        <div class=" flex flex-col sm:flex-row">
                            <div class="mr-1"><Button icon="pi pi-pencil" class="p-button-sm p-button-rounded p-button-success" /></div>
                            <div class="mr-1"><Button icon="pi pi-trash" class="p-button-sm p-button-rounded p-button-warning" /></div>
                        </div>   
                    </div>
                </div> -->
                <!-- <ObjectiveTable :objectives="$page.props.departments"/> -->
                <div class="mt-2">
                    <ObjectiveTable :objectives="$page.props.objectives" @editObjective="editObjective"/>
                </div>
                
            </div>

            <Dialog v-model:visible="objectiveDialog" :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '50vw'}" header="วัตถุประสงค์การใช้ห้อง" :modal="true" class="p-fluid">
                <div class="mb-4">
                    <label for="room_full_name">วัตถุประสงค์</label>
                    <InputText v-model.trim="oForm.objective_name" required="true" :class="{'p-invalid': submitted }" />
                    <small class="p-error" v-if="submitted">จำเป็นต้องใส่ วัตถุประสงค์</small>
                </div>

                <div class="mb-4">
                    <label for="room_short_name">รายละเอียดเพิ่มเติม</label>
                    <InputText v-model.trim="oForm.objective_detail" required="true" :class="{'p-invalid': submitted }" />
                </div>

                <template #footer>
                    <Button label="ยกเลิก" icon="pi pi-times" class="p-button-sm" @click="hideDialog"/>
                    <Button label="จัดเก็บ" icon="pi pi-check" class="p-button-raised p-button-text p-button-success p-button-sm" @click="saveObjective" />
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
//import { Inertia } from '@inertiajs/inertia'
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
//import { FilterMatchMode } from 'primevue/api';
import { useToast } from "primevue/usetoast";
import ObjectiveTable from "@/Components/Admin/ObjectiveTable.vue"

export default {
    components: {
        Link, ObjectiveTable,
    },

    props: {
        objectives: Array,
    },

    setup() {
        const toast = useToast()
        const objectiveDialog = ref(false)
        const submitted = ref(false)
        const objectives = ref([])

        const oForm = useForm({
            id: null,
            objective_name: null,
            objective_detail: null,
            userin: '10039018',
            user_last_act: '10028111'
            // created_at: '1/10/2564 22:18',
            // updated_at: '2/10/2564 23:00'
        });
        
        const openNew = () => {
            //submitted.value = false
            objectiveDialog.value = true
        };

        const hideDialog = () => {
            oForm.reset();
            objectiveDialog.value = false
            //submitted.value = false
        };

        const saveObjective = () => {
            // objectives.value.push({
            //     id: objectives.value.length + 1,
            //     objective_name: oForm.objective_name, 
            //     objective_detail: oForm.objective_detail,
            //     userin: oForm.userin,
            //     user_last_act: oForm.user_last_act, 
            //     created_at: oForm.created_at, 
            //     updated_at: oForm.updated_at
            // })

            if(oForm.id) {
                console.log("Edit Data");
                // //meetingRooms[findIndexById(meetingRoom.id)] = meetingRoom;
                // oForm.transform(data => ({
                //     ...data,
                //     oldimage1: meetingRoom.value.image1,
                //     oldimage2: meetingRoom.value.image2,
                //     oldimage3: meetingRoom.value.image3
                // })).post(`/mroom/${mRoomForm.id}/update`, {
                //     // replace: true,
                //     // onBefore: () => {
                //     // },
                //     onSuccess: () => {
                //         //console.log(page)
                //         // หลังจากเพิ่มข้อมูลลง DB ให้ get list ห้องมาใหม่เพื่อให้ datatable แสดงผลได้ถูกต้อง
                //         meetingRooms.value = usePage().props.value.mrooms_tranform
                //         deletedMeetingRooms.value = usePage().props.value.dmrooms
                //         toast.add({severity:'success', summary: 'Successful', detail: 'แก้ไขข้อมูลห้องประชุมเรียบร้อย', life: 3000});
                //     },
                //     onError: (errors) => {
                //         console.log(errors)
                //     },
                //     onFinish: () => {
                //         mRoomForm.processing = false 
                //     }
                // });
            } else {
                oForm.post(route('add_objective'), {
                    replace: true,
                    onSuccess: () => {
                        objectiveDialog.value = false
                        oForm.reset()
                        toast.add({severity:'success', summary: 'สำเร็จ', detail: 'จัดเก็บวัตถุประสงค์การใช้ห้องประชุม เรียบร้อย', life: 3000}); 
                    },
                    onError: (errors) => {
                        console.log(errors)
                    },
                    onFinish: () => {
                        oForm.processing = false 
                    }
                });
            }

            //toast.add({severity:'success', summary: 'สำเร็จ', detail: 'จัดเก็บวัตถุประสงค์การใช้ห้องประชุม เรียบร้อย', life: 3000});
            // objectiveDialog.value = false
            // oForm.reset()
            //console.log(objectives)
        }

        const editObjective = (objId) => {
            console.log(objId)
            oForm.objective_name = objId
            openNew()
        }

        return {
            objectiveDialog, submitted, oForm, objectives, toast,
            hideDialog, openNew, saveObjective, editObjective,
        }
    }
}
</script>

<style>

</style>