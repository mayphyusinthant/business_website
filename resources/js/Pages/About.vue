<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AboutUs from '@/Components/AboutUs.vue';
import { ref , onMounted, defineProps } from 'vue';

import { getCookie } from '@/utils'; // Adjust the path based on your project structure

let darkMode = null;
const appTitle = ref(import.meta.env.VITE_APP_NAME);

const props = defineProps(['companySettings', "categories"]);
console.log('Company Settings', props.companySettings);
console.log('Categories', props.categories);

onMounted(() => {
    if(getCookie('darkMode') == 'on'){
        darkMode = true;
    }else{
        darkMode = false;
    }
    console.log(darkMode)
});
</script>

<template>
    <AppLayout title="About">
        <!-- <template #header>
            <h1 class="font-semibold text-xl text-blue-950 leading-tight"  :class="{ 'dark:text-white': darkMode}">
                {{ appTitle }} 
            </h1>
        </template> -->

        <div class="py-12" >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :class="{ 'dark:bg-gray-800': darkMode }">
                <div class=" overflow-hidden shadow-xl sm:rounded-lg" >
                    <AboutUs :appTitle="appTitle" :categories="categories" :companySettings="companySettings" :class="{ 'dark:bg-gray-800': darkMode }" />
                </div>
            </div>
        </div>

         <div class=" px-4 py-4 text-center" :class="{ 'dark:bg-gray-800': darkMode }">
            <h1 class="text-base text-blue-950 leading-tight"  :class="{ 'dark:text-white': darkMode, }">
                © {{ companySettings[0]['company_name'] }}  Co.,Ltd. 2024 - 2025. All right reserved.
            </h1>
        </div>
    </AppLayout>
</template>
