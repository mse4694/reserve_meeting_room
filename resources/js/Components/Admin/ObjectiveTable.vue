<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <!-- <thead class="bg-green-50"> -->
            <thead class="bg-blue-100">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                  วัตถุประสงค์การใช้ห้อง
                </th>
                <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                  ผู้เพิ่มข้อมูล
                </th>
                <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
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
              <tr v-for="obj in objectives" :key="obj.objective_name">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ obj.objective_name }}</div>
                  <div class="text-xs text-gray-500">{{ obj.objective_detail }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ obj.user_create }}</div>
                  <div class="text-xs text-gray-500">{{ obj.created_at }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-xs">
                  <div class="text-sm text-gray-900">{{ obj.user_update }}</div>
                  <div class="text-xs text-gray-500">{{ obj.updated_at }}</div>
                </td>
                <!-- <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                  {{ getHumanDate(obj.updated_at) }}
                </td> -->
                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900 mx-1 p-2 border rounded-md bg-yellow-100" @click="$emit('editObjective', obj.id)"><i class="pi pi-pencil"></i> แก้ไข</a>
                  <a href="#" class="text-indigo-600 hover:text-indigo-900 mx-1 p-2 border rounded-md bg-red-300"><i class="pi pi-trash"></i> ลบ</a>
                </td>
              </tr>
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
//import moment from 'moment'
// const people = [
//   {
//     name: 'Jane Cooper',
//     title: 'Regional Paradigm Technician',
//     department: 'Optimization',
//     role: 'Admin',
//     email: 'jane.cooper@example.com',
//     image:
//       'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
//   },
//   // More people...
// ]

export default {
  props: {
    objectives: Array,
  },

  emits: ['editObjective'],

  setup() {
    // const getHumanDate = (data) => {
    //             return moment(data).locale('th').fromNow();
    // }
    //console.log(departments)
    return {
        //getHumanDate,
    }
  },
}
</script>