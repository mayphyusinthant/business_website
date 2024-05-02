<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SectionBorder from '@/Components/SectionBorder.vue';
    import {Link, Head} from '@inertiajs/vue3';
    import { defineProps, ref , onMounted} from 'vue';
    import { router } from '@inertiajs/vue3'  
    import JetLabel from "@/Components/InputLabel.vue";
    import JetInputError from "@/Components/InputError.vue";
    import TextInput from "@/Components/TextInput.vue";
    import JetActionMessage from "@/Components/ActionMessage.vue";
    import { useForm } from '@inertiajs/vue3';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';

    const props = defineProps([ 'companySettings']);
    console.log('Company Settings:', props.companySettings);
    
    const components = {
    JetLabel,
  };

    import { getCookie } from '@/utils'; // Adjust the path based on your project structure

    let darkMode = null;

    onMounted(() => {
      if(getCookie('darkMode') == 'on'){
        darkMode = true;
      }else{
        darkMode = false;
      }

      console.log(darkMode)
    });



</script>

<template #header>
    <AppLayout title="Admin Panel" :class="{ 'dark-mode-class': darkMode }">
        <template #header >
            <div class="grid grid-cols-6 md:grid-cols-12 items-center">
                <h2 class="col-span-4 md:col-span-2  mb-2 font-semibold custom-text-xl text-pink-800 leading-tight w-full md:w-1/2" :class="{ 'dark:text-white': darkMode }">
                    Company Settings
                </h2>
                <button class="col-span-4 md:col-span-2 mb-2 bg-pink-900 text-white py-2 px-4 md:mx-4 mx-1 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none" :class="{ 'dark:bg-gray-700': darkMode }">
                    <Link :href="route('company_setting.edit')" :class="{ 'dark:bg-white': darkMode }">Edit Settings</Link>
                </button>

                <button class="col-span-4 md:col-span-2 mb-2 bg-pink-900 text-white py-2 px-4 md:mx-4 mx-1 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none" :class="{ 'dark:bg-gray-700': darkMode }">
                    <Link :href="route('company_setting.photos.edit')" :class="{ 'dark:bg-white': darkMode }" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0m-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0"/>
                        </svg> 
                        <p class="">&nbsp;&nbsp; Photos for Home Page</p>
                    </Link>               
                </button>
                
            </div>
            
           
        </template>

            <div class="grid items-center mx-0" :class="{ 'dark:bg-gray-800': darkMode }">
                <p class="col-span-1" :class="{ 'dark:text-gray-800': darkMode }">
                    <div class="p-5 lg:p-8  border-b border-gray-200 flex flex-wrap items-start justify-center sm:justify-center"
                    :class="{ 'dark:bg-gray-800': darkMode }">
                        <ApplicationLogo class="block h-60 w-auto mr-4 mx-5 mt-10 pt-10" />
                        
                        <div class="mx-2 sm:mx-5 mt-10 w-full sm:w-6/12">

                            <h1 class="text-2xl font-semibold text-blue-900 " :class="{ 'dark:text-white': darkMode }">
                                {{ companySettings[0]['company_name'] }}
                            </h1>
                    
                            <p class="mt-2  text-gray-500 leading-relaxed text-base text-justify" style="white-space: pre-line;">
                                {{ companySettings[0]['company_info'] }}
                            </p>

                            <p class="mt-2  text-gray-500 leading-relaxed text-base text-justify" style="white-space: pre-line;">
                                {{ companySettings[0]['company_info_mm'] }}
                            </p>
                        
                            <div class="text-right">
                                <p class="mt-2 text-gray-500 leading-relaxed text-base">
                                    Open Daily: {{ companySettings[0]['open_hour'] }} - {{ companySettings[0]['close_hour'] }}</p>
                                <p class="mt-2 text-gray-500 leading-relaxed text-base">Close on Every {{ companySettings[0]['close_day'] }}</p>
                                <p class="mt-2 text-gray-500 leading-relaxed text-base">{{ companySettings[0]['phone_number'] }} </p>
                                <p class="mt-2 text-gray-500 leading-relaxed text-base ">{{ companySettings[0]['email'] }} </p>
                                <p class="mt-2 text-gray-500 leading-relaxed text-base ">{{ companySettings[0]['address'] }} </p><br/>
                                <p class="mt-2 text-gray-500 leading-relaxed text-base ">Facebook Page : {{ companySettings[0]['facebook_page'] }} </p><br/>

                                
                            </div>
                            <h3 class="mt-2 text-gray-500 text-bold leading-relaxed " :class="{ 'dark:text-white': darkMode }">Our Services </h3>
                            <p class="mt-2 text-gray-500 leading-relaxed text-base" style="white-space: pre-line;">
                                {{ companySettings[0]['service_info'] }}</p>
                            <p class="mt-2 text-gray-500 leading-relaxed text-base" style="white-space: pre-line;">
                                {{ companySettings[0]['service_info_mm'] }}</p>
                        </div>
                        </div>
                </p>
            </div>

            <div class="px-4 py-4 text-center" :class="{ 'dark:bg-gray-800': darkMode }">
                <h1 class="text-base text-blue-950 leading-tight"  :class="{ 'dark:text-white': darkMode}">
                    ©{{companySettings[0]['company_name']}} Co.,Ltd. 2024 - 2025. All right reserved.
                </h1>
            </div>
    </AppLayout>

</template>