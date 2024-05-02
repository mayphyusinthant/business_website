<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref , onMounted, defineProps } from 'vue';

import { getCookie } from '@/utils'; // Adjust the path based on your project structure

let darkMode = null;
const appTitle = ref(import.meta.env.VITE_APP_NAME);

const props = defineProps(['companySettings', 'categories']);
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
    <AppLayout title="Dashboard" class="area">
        <!-- <template #header>
            <h1 class="font-semibold text-xl text-blue-950 leading-tight"  :class="{ 'dark:text-white': darkMode}">
                {{ appTitle }} 
            </h1>
        </template> -->
            <div class="py-12" >
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :class="{ 'dark:bg-gray-800': darkMode }">
                    <div class=" overflow-hidden shadow-xl sm:rounded-lg" >
                        <AboutUs :appTitle="appTitle" />
                    </div>
                </div>
            </div>

            <div class="">
                <div class="flex flex-wrap items-center">
                    <div class="w-full sm:w-6/12 px-12 ">
                        <div id="gallery1" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="1000">
                            <div class="carousel-indicators">
                              <button v-for="(imagePath, index) in companySettings[0]['gallery1_photos'].split(',')" :key="index" type="button" :data-bs-target="'#gallery1'" :data-bs-slide-to="index" :class="{ active: index === 0 }" aria-current="true" aria-label="Slide {{ index + 1 }}"></button>
                            </div>
                            <div class="carousel-inner">
                                <div v-for="(imagePath, index) in companySettings[0]['gallery1_photos'].split(',')" :key="index" class="carousel-item" :class="{ active: index === 0 }">
                                    <img :src="imagePath" :alt="'Gallery Image ' + index" class="rounded-xl shadow-xl w-full">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#gallery1" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#gallery1" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                          </div>
                    </div>

                    <div class="w-full sm:w-6/12 px-12 text-center">
                        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="3000">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active bg-blue-500" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p v-for="setting in companySettings" style="white-space: pre-line;" class="mt-2 text-gray-500 leading-relaxed text-base">
                                        {{ setting.company_info }}
                                    </p>
                                </div>
                                <div class="carousel-item">
                                    <p v-for="setting in companySettings" style="white-space: pre-line;" class="mt-2 text-gray-500 leading-relaxed text-base">
                                        {{ setting.company_info_mm }}
                                    </p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
  
  
        <div class="flex flex-wrap items-center">
            <div class="w-full sm:w-6/12 px-20">

                    <div id="carouselExampleIndicators1" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="0" class="active bg-blue-500" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <h2 class="mt-2 text-gray-500 leading-relaxed font-bold text-lg text-center">  Our Services  </h2>
                                <p class="mt-2 text-gray-500 leading-relaxed text-center"> ~~~~~~~~~</p>
                                <p  class="mt-2 text-gray-500 leading-relaxed text-base" style="white-space: pre-line;">
                                    {{ companySettings[0]['service_info'] }}
                                </p>
                            </div>
                            <div class="carousel-item">
                                <h2 class="mt-2 text-gray-500 leading-relaxed font-bold text-lg text-center">  Our Services  </h2>
                                <p class="mt-2 text-gray-500 leading-relaxed text-center"> ~~~~~~~~~</p>
                                <p  class="mt-2 text-gray-500 leading-relaxed text-base" style="white-space: pre-line;">
                                    {{ companySettings[0]['service_info_mm'] }}
                                </p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>


            <div class="w-full sm:w-6/12 px-12">
                <div id="gallery2" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="1000">
                    <div class="carousel-indicators">
                      <button v-for="(imagePath, index) in companySettings[0]['gallery2_photos'].split(',')" :key="index" type="button" :data-bs-target="'#gallery2'" :data-bs-slide-to="index" :class="{ active: index === 0 }" aria-current="true" aria-label="Slide {{ index + 1 }}"></button>
                    </div>
                    <div class="carousel-inner">
                      <div v-for="(imagePath, index) in companySettings[0]['gallery2_photos'].split(',')" :key="index" class="carousel-item" :class="{ active: index === 0 }">
                        <img :src="imagePath" :alt="'Gallery Image ' + index" class="rounded-xl shadow-xl w-full">
                    </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#gallery2" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#gallery2" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
        </div>
        

        <!--Start Background Animation Body-->

			<!-- <ul class="circles">
				<li> -->
                    <!-- <img src = "/images/silver_medal.jpg" class="rounded-xl shadow-x  w-auto " /> -->
                <!-- </li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
                <li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
                <li></li>
				<li></li>
			</ul> -->
		<!--End Background Animation Body-->

         <div class=" px-4 py-4 text-center" :class="{ 'dark:bg-gray-800': darkMode }">
            <h1 class="text-base text-blue-950 leading-tight"  :class="{ 'dark:text-white': darkMode}">
                © {{ companySettings[0]['company_name'] }}  Co.,Ltd. 2024 - 2025. All right reserved.
            </h1>
        </div>
    </AppLayout>
</template>

