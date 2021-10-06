<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <!-- <thead class="bg-green-50"> -->
            <thead class="bg-blue-500">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-white uppercase tracking-wider">
                  ชื่อหน่วยงาน
                </th>
                <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-white uppercase tracking-wider">
                  ผู้เพิ่มข้อมูล
                </th>
                <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-white uppercase tracking-wider">
                  ผู้อัพเดทข้อมูล
                </th>
                <!-- <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                  ทำการอัพเดทเมื่อ
                </th> -->
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">การจัดการ</span>
                </th>
              </tr>
            </thead>
            
            <tbody class="bg-white divide-y divide-gray-200">
              <template v-for="wu in workunits" :key="wu.id">
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ wu.workunit_name }}</div>
                    <div v-if="! wu.workunit_detail" class="text-sm text-gray-500">-</div>
                    <div v-else class="text-xs text-gray-500">{{ wu.workunit_detail }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ wu.userin }}</div>
                    <div class="text-xs text-gray-500">{{ getHumanDate(wu.created_at) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-xs">
                    <div v-if="! wu.user_last_act" class="text-sm text-gray-900">-</div>
                    <div v-else class="text-sm text-gray-900">{{ wu.user_last_act }}</div>
                    <div class="text-xs text-gray-500">{{ getHumanDate(wu.updated_at) }}</div>
                  </td>
                  <!-- <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                    {{ getHumanDate(wu.updated_at) }}
                  </td> -->
                  <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mx-1 p-2 border rounded-md bg-yellow-100" @click="$emit('editEvent', wu.id)"><i class="pi pi-pencil"></i> แก้ไข</a>
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mx-1 p-2 border rounded-md bg-red-300"><i class="pi pi-trash"></i> ลบ</a>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- <div>
        {{ $page.props.departments }}
    </div> -->
  </div>
</template>

<script>

import moment from 'moment'
export default {
  props: {
    workunits: Array,
  },

  emits: ['editEvent'],

  setup() {
    const getHumanDate = (data) => {
                return moment(data).locale('th').fromNow();
    }
    return {
        getHumanDate,
    }
  },
}
</script>