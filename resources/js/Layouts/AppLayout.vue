<template>
  <div class="leading-normal tracking-normal" id="main-body">
    <div class="flex flex-wrap">

      <Sidebar />

      <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen" :class="sideBarOpen ? 'overlay' : ''" id="main-content">

        <Navbar />

        <div class="p-6 bg-gray-100 mb-20">
            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>

        <!-- <Footer /> -->

      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '@/Layouts/Sidebar.vue'
import Navbar from '@/Layouts/Navbar.vue'
export default {
    components: {
        Sidebar, Navbar,
    },

    setup() {
        
    },
}
</script>