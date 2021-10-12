<template>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-2 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Event ID {{ $page.props.eventDetail }} Information
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Event Title Details Show Here.
            <!-- <Button label="ปิด" class="p-button-sm p-button-raised" @click="closeMe"/> -->
        </p>
        <!-- <span class="cursor-pointer"><Tag value="ปิด" @click="closeMe"></Tag></span> -->
        </div>
        <div class="border-t border-gray-200">
        <dl>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                ห้องประชุม
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                ประเสริฐ PK1
            </dd>
            </div>
            <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                วันที่ประชุม
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                09/10/2564
            </dd>
            </div>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                เวลาที่ประชุม
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                08:00 - 16:00 นาฬิกา
            </dd>
            </div>
            <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                เวลาเตรียมห้องประชุม
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                0 นาที
            </dd>
            </div>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                จำนวนผู้เข้าร่วมประชุม
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                10
            </dd>
            </div>
            <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                รายละเอียด / ลักษณะการจัด
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                -
            </dd>
            </div>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                ผู้ประสานงาน
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                -
            </dd>
            </div>
            <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                หน่วยงาน
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                -
            </dd>
            </div>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
               เบอร์โทรติดต่อ
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                -
            </dd>
            </div>
            <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                อุปกรณ์ที่ใช้
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                -
            </dd>
            </div>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                อาหาร / เครื่องดิ่ม
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                -
            </dd>
            </div>
            <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                สถานะ
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                อนุมัติ
            </dd>
            </div>
            <div class="bg-green-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                <span class="cursor-pointer"><Tag value="ปิด" @click="closeMe"></Tag></span>
            </dd>
            </div>
        </dl>
        </div>
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

    setup(props) {
        const closeMe = () => {
            window.close()
        }

        return {
            closeMe,
        }
    }
}
</script>

<style>

</style>
