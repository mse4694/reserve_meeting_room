<template>
<AppLayout>
    <div class="flex flex-1 flex-col sm:flex-row items-end ">
        <div class="flex flex-1 flex-col sm:flex-row items-end">
            <!-- <div class="mb-1 px-2"><Dropdown v-model="searchForm.selectedWorkUnit" :options="workunits" optionLabel="name" optionValue="type" placeholder="เลือกหน่วยงาน" @change="checkEvent($event)"/></div> -->
            <div class="mb-1 px-2"><Dropdown v-model="searchForm.selectedWorkUnit" :options="workunits" optionLabel="name" optionValue="type" placeholder="เลือกหน่วยงาน"/></div>
            <div class="mb-1 px-2"><Button label="ค้นหา" icon="pi pi-search" class="p-button-info p-button-sm" @click="findWorkUnit"/></div>
        </div>
        <div>
            <div class="mb-1 px-2"><Button label="เพิ่มหน่วยงาน" icon="pi pi-plus" class="p-button-primary p-button-sm"/></div>
        </div>
    </div>
    <div class="mt-2">
    <Card>
        <template #content>
            <div class="ml-4 mr-4">
                <Toolbar>
                    <template #left>           
                        <i class="pi pi-bars p-toolbar-separator mr-2" />
                    </template>
                </Toolbar>
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
export default {
    props: {
        //workunits: Array,
        workunits: {
            type: Array,
            required: true
        },
    },

    setup() {
        
        //const selectedWorkUnit = ref()
        const workunits = ref([
			{name: 'หน่วยงานภายใน', type: 'internal'},
			{name: 'หน่วยงานภายนอก', type: 'external'},
			{name: 'บริษัทต่างๆ', type: 'company'}
		])

        const searchForm = useForm({
            selectedWorkUnit: null,
        });

        // const checkEvent = (event) => {
        //     //console.log(event)
        //     //searchForm.selectedWorkUnit = event.value
        //     console.log(searchForm.selectedWorkUnit)
        // }

        const findWorkUnit = () => {
            searchForm.get(route('manage_workunit'), {
                preserveState: true, 
                //replace: true,
                // onSuccess: () => {
                //     searchForm.reset()
                //     toast.add({severity:'success', summary: 'Successful', detail: 'แก้ไขวัตถุประสงค์การใช้ห้องประชุมเรียบร้อย', life: 3000});
                // },
                // onError: (errors) => {
                //     // console.log(errors.msg)
                //     // console.log(errors.sysmsg)
                //     searchForm.reset()
                //     toast.add({severity:'error', summary: 'Failure', detail: `แก้ไขวัตถุประสงค์การใช้ห้องประชุมไม่สำเร็จ เนื่องจาก ${errors.sysmsg}`, group: 'errorkey'});
                // },
                onFinish: () => {
                    console.log(usePage().props.value.workunits)
                    searchForm.reset()
                    searchForm.processing = false 
                }
            });
        }

        return {
            workunits, searchForm,
            findWorkUnit
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