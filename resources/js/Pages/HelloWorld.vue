<template>
   <AppLayout>
       <div>
        <Card>
            <template #title>
                Advanced Card
            </template>
            <template #content>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt
                quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis esse, cupiditate neque quas!
            </template>
            <template #footer>
                <Button icon="pi pi-check" label="Save" />
                <Button icon="pi pi-times" label="Cancel" class="p-button-secondary" style="margin-left: .5em" />
            </template>
        </Card>
      </div>
   </AppLayout>
</template>

<script>
//import { ref } from 'vue'
//import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    // components: {
    //     AppLayout
    // },
    setup() {

    },
}
</script>