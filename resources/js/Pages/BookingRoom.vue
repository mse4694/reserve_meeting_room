<template>
    <AppLayout>
        <!-- <div class="m-1 bg-gradient-to-r from-green-100 to-blue-200 rounded-md shadow-md border-opacity-50">
            xxx
        </div> -->
        <div class="mt-5 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <!-- <form action="#" method="POST"> -->
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div v-if="isAdmin" class="col-span-6 sm:col-span-2">
                                <label for="workunit_type" class="block text-sm font-medium text-gray-700">ประเภทหน่วยงาน</label>
                                <select @change="getWorkunitNameFromType(workunit_type)" v-model="workunit_type" id="workunit_type" name="workunit_type" autocomplete="workunit_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option v-for="(item) in workunit_types" :key="item.index" :value="item.title_en">{{item.title_th}}</option>
                                </select>
                            </div>

                            <div v-if="isAdmin" class="col-span-6 sm:col-span-4">
                                <label for="workunit_name" class="block text-sm font-medium text-gray-700">ชื่อหน่วยงาน</label>
                                <select v-model="workunit_name" id="workunit_name" name="workunit_name" autocomplete="workunit_name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option v-for="(item) in workunits" :key="item.id" :value="item.id">{{item.workunit_name}}</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_start" class="block text-sm font-medium text-gray-700">วันที่จอง</label>
                                <Calendar v-if="isAdmin" id="date_start" dateFormat="dd-mm-yy" v-model="date_start"
                                    :show-button-bar="true" 
                                    :month-navigator="true" 
                                    :year-navigator="true"
                                    year-range="2010:2050" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </Calendar>
                                <Calendar v-else id="date_start" dateFormat="dd-mm-yy" v-model="date_start" 
                                    :disabledDays="[0,6]"
                                    :show-button-bar="true" 
                                    :month-navigator="true" 
                                    :year-navigator="true"
                                    year-range="2010:2050" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </Calendar>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_end" class="block text-sm font-medium text-gray-700">ถึง</label>
                                <Calendar v-if="isAdmin" id="date_end" dateFormat="dd-mm-yy" v-model="date_end"
                                    :show-button-bar="true" 
                                    :month-navigator="true" 
                                    :year-navigator="true"
                                    year-range="2010:2050"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </Calendar>
                                <Calendar v-else id="date_end" dateFormat="dd-mm-yy" v-model="date_end" 
                                    :disabledDays="[0,6]"
                                    :show-button-bar="true" 
                                    :month-navigator="true" 
                                    :year-navigator="true"
                                    year-range="2010:2050"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </Calendar>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_end" class="block text-sm font-medium text-gray-700">จำนวนวันจอง</label>
                                <div class="w-full h-10 items-end text-sm text-red-500">{{showDateCount}}</div>
                            </div>

                            <div v-if="isLongEvent" class="col-span-6 sm:col-span-6">
                                <label for="date_start" class="block text-sm font-medium text-gray-700">เลือกเฉพาะวัน (กรณีเลือกจองยาวตั้งแต่ 3 วันขึ้นไป)</label>
                                <div class="flex flex-row mt-10 mb-10 items-start sm:mt-5 sm:mb-2">
                                    <div class="flex items-center h-5 py-5">
                                        <SelectButton v-if="isAdmin" v-model="individualDaySelected" :options="individualDayOptionAdmin" optionLabel="name" multiple />
                                        <SelectButton v-else v-model="individualDaySelected" :options="individualDayOptionUser" optionLabel="name" multiple />           
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_start" class="block text-sm font-medium text-gray-700">เวลาที่จอง</label>
                                <Calendar id="time_start" :timeOnly="true" :showTime="true" :showSeconds="false" :stepMinute="30" v-model="time_start" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                <!-- v-calendar -->
                                <Datepicker uid="first" v-model="vdate" dark/>
                                <div><Datepicker uid="second" v-model="vtime" timePicker dark :autoPosition="false"/></div>
                                <!-- <DatePicker
                                    v-model="vdate"
                                    mode="time" 
                                    :is24hr="true"
                                    color="red"
                                    is-dark
                                /> -->
                                <!-- <DatePicker mode="time" :is24hr="true" v-model="vdate" locale="th" color="Indigo" is-dark>
                                    <template v-slot="{ inputValue, inputEvents }">
                                        <input
                                        class="bg-white border px-2 py-2 focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        :value="inputValue"
                                        v-on="inputEvents"
                                        />
                                    </template>
                                </DatePicker> -->
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_end" class="block text-sm font-medium text-gray-700">ถึง</label>
                                <Calendar id="time_end" :timeOnly="true" :showTime="true" :showSeconds="false" :stepMinute="30" v-model="time_end" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_end" class="block text-sm font-medium text-gray-700">จำนวนเวลาจอง</label>
                                <div class="w-full h-10 items-end text-sm text-red-500">{{showTimeCount}}</div>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-4 ">
                                <label for="prepare" class="block text-sm font-medium text-gray-700">เวลาเตรียมห้อง</label>
                                <div class="flex flex-row justify-items-start space-x-2">
                                    <div>
                                        <ToggleButton v-model="check_prepare" onIcon="pi pi-check" offIcon="pi pi-times" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                    </div>
                                    <div v-if="check_prepare" class="w-full">
                                        <!-- <SelectButton v-model="prepare" :options="prepare_time" optionLabel="name" optionValue="value" /> -->
                                        <!-- <select v-model="prepare" :disabled="!check_prepare" id="prepare" name="prepare" autocomplete="prepare" class="w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option v-for="(item) in prepare_time" :key="item.value" :value="item.value">{{item.name}}</option>
                                        </select> -->
                                        <select v-model="prepare" id="prepare" name="prepare" autocomplete="prepare" class="w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option v-for="(item) in prepare_time" :key="item.value" :value="item.value">{{item.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_end" class="block text-sm font-medium text-gray-700">จำนวนเวลาเตรียม</label>
                                <div v-if="check_prepare" class="w-full h-10 items-end text-sm text-red-500">{{prepare}} นาที</div>
                                <div v-else class="w-full h-10 items-end text-sm text-red-500">ไม่ใช้เวลาเตรียมห้อง</div>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="objective" class="block text-sm font-medium text-gray-700">วัตถุประสงค์</label>
                                <select v-model="objective" id="objective" name="objective" autocomplete="objective" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option v-for="(item) in objectives" :key="item.id" :value="item.id">{{item.objective_name}}</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="attendees" class="block text-sm font-medium text-gray-700">จำนวนผู้เข้าร่วม</label>
                                <input type="text" v-model="attendees" name="attendees" id="attendees" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                {{filterMeetingRooms}}
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="selectedMroom" class="block text-sm font-medium text-gray-700">เลือกห้องประชุม</label>
                                <select v-model="selectedMroom" id="selectedMroom" name="selectedMroom" autocomplete="selectedMroom" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0" selected>กรุณาเลือกห้องประชุม</option>                                   
                                    <option v-for="(item) in filterMrooms" :key="item.id" :value="item.id">{{item.label}}</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="date_end" class="block text-sm font-medium text-gray-700">ผลการตรวจสอบ</label>
                                <div v-if="check_prepare" class="w-full h-10 items-end text-sm text-red-500">{{prepare}} นาที</div>
                                <div v-else class="w-full h-10 items-end text-sm text-blue-500">ยังไม่ได้ตรวจสอบ</div>
                            </div>
                        </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <div class="mb-2">
                                isAdmin:
                                <ToggleButton v-model="isAdmin" onIcon="pi pi-check" offIcon="pi pi-times" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                            </div>
                            <div>
                                <button type="submit" 
                                    :disabled="!canCheckEvent" 
                                    :class="canCheckEvent ? 'text-white bg-indigo-600 hover:bg-indigo-700' : 'text-black bg-gray-500 cursor-default'" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    ตรวจสอบ
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mt-4 md:mt-0">จองห้องประชุม</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        กรุณาระบุรายละเอียดส่วนแรกเพื่อคัดกรองข้อมูลเบื้องต้น.
                    </p>
                    <div class="mt-2">
                        <img src="/storage/picture/no_image.jpg" alt="">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
            <div class="border-t border-gray-200" />
            </div>
        </div>

        <div v-if="canBooking">
            <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                            Website
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            http://
                            </span>
                            <input type="text" name="company-website" id="company-website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="www.example.com" />
                        </div>
                        </div>
                    </div>

                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700">
                        About
                        </label>
                        <div class="mt-1">
                        <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                        Brief description for your profile. URLs are hyperlinked.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                        Photo
                        </label>
                        <div class="mt-1 flex items-center">
                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Change
                        </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                        Cover photo
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload a file</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                            </label>
                            <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                            PNG, JPG, GIF up to 10MB
                            </p>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
            <div class="border-t border-gray-200" />
            </div>
        </div>

        <div v-if="canBooking" class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Use a permanent address where you can receive mail.
                </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                        <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                        <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country / Region</label>
                        <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option>United States</option>
                            <option>Canada</option>
                            <option>Mexico</option>
                        </select>
                        </div>

                        <div class="col-span-6">
                        <label for="street-address" class="block text-sm font-medium text-gray-700">Street address</label>
                        <input type="text" name="street-address" id="street-address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" id="city" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                        <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                        <input type="text" name="state" id="state" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                        <label for="postal-code" class="block text-sm font-medium text-gray-700">ZIP / Postal</label>
                        <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                    </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
            <div class="border-t border-gray-200" />
            </div>
        </div>

        <div v-if="canBooking" class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Notifications</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Decide which communications you'd like to receive and how.
                </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <fieldset>
                        <legend class="text-base font-medium text-gray-900">By Email</legend>
                        <div class="mt-4 space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                            <input id="comments" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            </div>
                            <div class="ml-3 text-sm">
                            <label for="comments" class="font-medium text-gray-700">Comments</label>
                            <p class="text-gray-500">Get notified when someones posts a comment on a posting.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                            <input id="candidates" name="candidates" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            </div>
                            <div class="ml-3 text-sm">
                            <label for="candidates" class="font-medium text-gray-700">Candidates</label>
                            <p class="text-gray-500">Get notified when a candidate applies for a job.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                            <input id="offers" name="offers" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            </div>
                            <div class="ml-3 text-sm">
                            <label for="offers" class="font-medium text-gray-700">Offers</label>
                            <p class="text-gray-500">Get notified when a candidate accepts or rejects an offer.</p>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div>
                        <legend class="text-base font-medium text-gray-900">Push Notifications</legend>
                        <p class="text-sm text-gray-500">These are delivered via SMS to your mobile phone.</p>
                        </div>
                        <div class="mt-4 space-y-4">
                        <div class="flex items-center">
                            <input id="push-everything" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                            <label for="push-everything" class="ml-3 block text-sm font-medium text-gray-700">
                            Everything
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="push-email" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                            <label for="push-email" class="ml-3 block text-sm font-medium text-gray-700">
                            Same as email
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="push-nothing" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                            <label for="push-nothing" class="ml-3 block text-sm font-medium text-gray-700">
                            No push notifications
                            </label>
                        </div>
                        </div>
                    </fieldset>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>
        <Toast position="top-right" />
    </AppLayout>
</template>

<script>
import moment from 'moment'
import { ref, onMounted, computed } from 'vue'
import { useToast } from "primevue/usetoast"
import Datepicker from 'vue3-date-time-picker'
//import 'vue3-date-time-picker/dist/main.css'
export default {
    components: {
        Datepicker,
    },
    setup() {
        onMounted(() => {
            axios.get(route('get_workunit_type')).then(res => {
                    //console.log(res.data.workunit_type)
                    workunit_types.value = res.data.workunit_types
                    workunit_type.value = workunit_types.value[0].title_en
                    //console.log(workunit_types.value[0].title_en)
            });

            axios.get(route('get_workunit_name_from_type', 'internal')).then(res => {
                    //console.log(res.data)
                    workunits.value = res.data.workunits
                    workunit_name.value = workunits.value[0].id
                    //console.log(events.value)
            });

            axios.get(route('get_objective')).then(res => {
                    //console.log(res.data.objectives)
                    objectives.value = res.data.objectives
                    objective.value = objectives.value[0].id
                    //console.log(events.value)
            });

            axios.get(route('get_meeting_room')).then(res => {
                    //console.log(res.data.mrooms)
                    meetingRooms.value = res.data.mrooms
            });
        })

        const toast = useToast();
        const workunits = ref([])
        const workunit_name = ref()
        const workunit_types = ref([])
        const workunit_type = ref()
        const objectives = ref([])
        const objective = ref()
        const date_start = ref(moment().startOf('day').toDate())
        const date_end = ref(moment().startOf('day').toDate())
        // const time_start = ref(null)
        // const time_end = ref(null)
        const time_start = ref(moment().add(1, 'hours').minutes(0).second(0).toDate())
        const time_end = ref(moment().add(1, 'hours').minutes(0).second(0).toDate())
        const canBooking = ref(false)
        const check_prepare = ref(false)
        const prepare_time = ref([
	     	{name: '5 นาที', value: 5},
	     	{name: '10 นาที', value: 10},
            {name: '15 นาที', value: 15},
            {name: '20 นาที', value: 20},
            {name: '25 นาที', value: 25},
            {name: '30 นาที', value: 30}
        ])
        const prepare = ref(prepare_time.value[0].value)
        const meetingRooms = ref([])
        const filterMrooms = ref([])
        const individualDaySelected = ref()
        const individualDayOptionAdmin = ref([
            {name: 'จ.', value: 1},
            {name: 'อ.', value: 2},
            {name: 'พ.', value: 3},
            {name: 'พฤ.', value: 4},
            {name: 'ศ.', value: 5},
            {name: 'ส.', value: 6},
            {name: 'อา.', value: 7}
        ])
        const individualDayOptionUser = ref([
            {name: 'จ.', value: 1},
            {name: 'อ.', value: 2},
            {name: 'พ.', value: 3},
            {name: 'พฤ.', value: 4},
            {name: 'ศ.', value: 5},
        ])
        const attendees = ref()
        const isAdmin = ref(true)
        const selectedMroom = ref(0)
        const isLongEvent = ref(false)
        const checkDate = ref(false)
        const checkTime = ref(false)
        const checkAttendees = ref(false)
        const canCheckEvent = ref(false)
        const vtime = ref({ 
            hours: moment().hour(6).toDate(),
            minutes: moment().minute(0).toDate()
        });
        const vdate = ref(new Date())
        const vlocale = ref('th-TH')
        const timezone = ref('')

        const getWorkunitNameFromType = (param) => {
            //console.log(param)
            axios.get(route('get_workunit_name_from_type', param)).then(res => {
                    //console.log(res.data)
                    workunits.value = res.data.workunits
                    workunit_name.value = workunits.value[0].id
                    //console.log(events.value)
            });
        }

        const filterMeetingRooms = computed(() => {
            if( ! isAdmin.value )
                filterMrooms.value = meetingRooms.value.filter(val => {
                    //console.log(attendees.value)
                    return val.capacity_max >= attendees.value 
                });
            else{
                filterMrooms.value = meetingRooms.value
            }
            //console.log(filterMrooms.value)
        })

        // const resetDefaultDate = () => {
        //     date_start.value = moment().startOf('day').toDate()
        //     date_end.value = moment().startOf('day').toDate()
        // }

        const showDateCount = computed(() => {
            // console.log(date_start.value)
            // console.log(date_end.value)
            // console.log(moment(date_end.value).diff(moment(date_start.value), 'days', true) + 1)

            if( !date_start.value || !date_end.value) {
                checkDate.value = false
                return `วันที่จองไม่ถูกต้อง`
            }

            if( moment(date_start.value).isBefore(moment().startOf('day')) || moment(date_end.value).isBefore(moment().startOf('day'))) {
                toast.add({severity:'warn', summary: 'คำเตือน', detail: 'ไม่สามารถจองห้อง ย้อนหลังจากวันที่ปัจจุบันได้', life: 5000});
                checkDate.value = false
                return `วันจองไม่ถูกต้อง`
            }

            if( moment(date_start.value).isAfter(date_end.value, 'day') ) {   
                toast.add({severity:'warn', summary: 'คำเตือน', detail: 'วันสิ้นสุดการจอง ไม่สามารถ ย้อนหลังจากวันที่เริ่มจองได้', life: 5000});
                //resetDefaultDate()
                checkDate.value = false
                return `วันจองไม่ถูกต้อง`
            }

            // คำนวนความต่างของวัน
            let diff = moment(date_end.value).diff(moment(date_start.value), 'days', true) + 1  // ที่ต้อง +1 เพราะต้องนับวันที่เริ่มจองด้วย ไม่งั้นจะได้แค่ค่าความต่างของวัน

            // ตรวจสอบว่าเป็นการจองยาวเกิน 3 วัน หรือไม่ ถ้าเกิน 3 วันให้แสดง วันเสริม ให้เลือก
            if( diff >= 3 ) {
                isLongEvent.value = true
            } else {
                isLongEvent.value = false
            }

            if( diff === 1 ) { // case วันเริ่มจอง กับ วันสิ้นสุดการจอง เป็นวันเดียวกันให้แสดง เป็นชื่อวัน
                checkDate.value = true
                return moment(date_end.value).locale('th').format("ตรงกับวัน dddd")
            } else if ( diff > 1 && diff <= 365 ) {  // case จองได้ตามปกติ แสดงผลวันเป็นจำนวนวันจอง
                checkDate.value = true
                return `${diff} วัน`
            } else if(diff > 365) {  // case จองไม่ได้เพราะจองเกิน 365 วัน
                toast.add({severity:'warn', summary: 'คำเตือน', detail: 'ไม่สามารถจองได้เกิน 365 วัน', life: 5000});
                checkDate.value = false
                return `วันจองไม่ถูกต้อง`
                //resetDefaultDate()
            } 
        })

        const showTimeCount = computed(() => {
            if( !time_start.value || !time_end.value) {
                return `เวลาจองไม่ถูกต้อง`
            }
            let start = moment(time_start.value, 'HH:mm')
            let end = moment(time_end.value, 'HH:mm')
            //let diff = end.diff(start, 'hours', true)
            let diffTime = end.diff(start, 'hours', true)
            //console.log(diffTime)
            console.log(`${diffTime} ชั่วโมง`)
            //console.log(moment().add(1, 'hours').minute(0).toDate())
            return `${diffTime} ชั่วโมง`
        })

        return {
            workunits, workunit_name, workunit_types, workunit_type, date_start, date_end, time_start, time_end, 
            objectives, objective, prepare_time, prepare, filterMrooms, meetingRooms,
            individualDayOptionAdmin, individualDayOptionUser, individualDaySelected, attendees, selectedMroom, vlocale, timezone, vtime, vdate,
            checkDate, checkTime, checkAttendees, isLongEvent, isAdmin, canBooking, check_prepare, canCheckEvent,  // Boolean
            getWorkunitNameFromType, filterMeetingRooms, showDateCount, showTimeCount,  // Method
        }
    }
}
</script>

<style scoped>
/* @import 'vue3-date-time-picker/src/Vue3DatePicker/styles/main.scss'; */
</style>
