<template>
    <div class="mt-2 mb-2">
        Hello Event display {{ $page.props.eventDetail }}  
    </div>
</template>

<script>
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
export default {
    props: {
        eventDetail: {
            type: String,
            required: true
        },
    },
}
</script>

<style>

</style>
