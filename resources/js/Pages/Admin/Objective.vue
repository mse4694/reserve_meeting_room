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
                        <!-- <Link :href="route('manage_meeting_room')"> -->
                        <Link href="#">
                        <div class="mt-2 px-2"><Button label="เพิ่มวัตถุประสงค์" icon="pi pi-plus" class="p-button-success p-button-sm" /></div>
                        </Link>
                    </template>
                </Toolbar>
            </div>
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
    components: {
        Link,
    },

    setup(props) {
        
    }
}
</script>

<style>

</style>