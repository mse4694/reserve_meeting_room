<template>
<AppLayout>
    <div class="flex flex-1 flex-col sm:flex-row items-end ">
        <div class="flex flex-1 flex-col sm:flex-row items-end">
            <!-- <div class="mb-1 px-2"><Dropdown v-model="searchForm.selectedWorkUnit" :options="workunits" optionLabel="name" optionValue="type" placeholder="เลือกหน่วยงาน" @change="checkEvent($event)"/></div> -->
            <div class="mb-1 px-2"><Dropdown v-model="workUnitForm.selectedWorkUnit" :options="workunits" optionLabel="name" optionValue="type" placeholder="เลือกหน่วยงาน" @change="findWorkUnit"/></div>
            <!-- <div class="mb-1 px-2"><Button label="ค้นหา" icon="pi pi-search" class="p-button-info p-button-sm" @click="findWorkUnit"/></div> -->
        </div>
        <div>
            <div class="mb-1 px-2"><Button label="เพิ่มหน่วยงาน" icon="pi pi-plus" class="p-button-primary p-button-sm"/></div>
        </div>
    </div>
    <div class="mt-2">
    <Card>
        <template #content>
            <div class="ml-4 mr-4">
                <div class="mt-2">
                    <WorkUnitTable :workunits="$page.props.workunits" @editEvent="editWorkUnit"/>
                </div>
                <!-- <Toolbar>
                    <template #left>           
                        <i class="pi pi-bars p-toolbar-separator mr-2" />
                    </template>
                </Toolbar> -->
            </div>
        </template>
    </Card>
    </div>
    <Toast position="top-right" />
    <Toast position="center" group="errorkey" />
</AppLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
//import { Inertia } from '@inertiajs/inertia'
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
import WorkUnitTable from "@/Components/Admin/WorkUnitTable.vue"
export default {

    components: {
        WorkUnitTable,
    },

    props: {
        workunits: {
            type: Array,
            required: true
        },
    },

    setup() {
        
        const workunits = ref([
			{name: 'หน่วยงานภายใน', type: 'internal'},
			{name: 'หน่วยงานภายนอก', type: 'external'},
			{name: 'บริษัทต่างๆ', type: 'company'}
		])

        const workUnitForm = useForm({
            selectedWorkUnit: null,
            workunit_id: null,
            workunit_name: null,
            workunit_detail: null
        });

        // const checkEvent = (event) => {
        //     //console.log(event)
        //     //searchForm.selectedWorkUnit = event.value
        //     console.log(searchForm.selectedWorkUnit)
        // }

        const findWorkUnit = () => {
            workUnitForm.get(route('manage_workunit'), {
                preserveState: true, 
                //replace: true,
                // onSuccess: () => {
                //     workUnitForm.reset()
                //     toast.add({severity:'success', summary: 'Successful', detail: 'แก้ไขวัตถุประสงค์การใช้ห้องประชุมเรียบร้อย', life: 3000});
                // },
                // onError: (errors) => {
                //     // console.log(errors.msg)
                //     // console.log(errors.sysmsg)
                //     workUnitForm.reset()
                //     toast.add({severity:'error', summary: 'Failure', detail: `แก้ไขวัตถุประสงค์การใช้ห้องประชุมไม่สำเร็จ เนื่องจาก ${errors.sysmsg}`, group: 'errorkey'});
                // },
                onFinish: () => {
                    //console.log(usePage().props.value.workunits)
                    workUnitForm.reset()
                    workUnitForm.processing = false 
                }
            });
        }

        const editWorkUnit = (objId) => {
            //console.log(objId)
            let indexId = objId - 1
            workUnit.workunit_id = usePage().props.value.workunits[indexId].id
            workUnit.workunit_name = usePage().props.value.workunits[indexId].workunit_name
            workUnit.workunit_detail = usePage().props.value.workunits[indexId].workunit_detail
            //openNew()
        }

        return {
            workunits, workUnitForm,
            findWorkUnit, editWorkUnit
            //checkEvent
        }
    }
}
</script>

<style scoped>
.p-dropdown {
    width: 14rem;
}

.p-ripple.purple .p-ink {
    background: rgba(256,39,176,.3);
}
</style>