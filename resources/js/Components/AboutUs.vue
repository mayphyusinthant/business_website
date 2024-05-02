<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { defineProps } from 'vue';
import { getCookie } from '@/utils'; 
import { reactive, ref, onMounted, watchEffect} from 'vue';

const props = defineProps({
    appTitle: String,
    companySettings : String,
    categories: String
});
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

<template>
    <div>
        <div  :class = "{'dark:bg-gray-800': darkMode}" class="p-6 lg:p-8 bg-gray-200 border-b border-gray-200 flex flex-wrap items-center justify-center sm:justify-center">
            <ApplicationLogo class="block h-60 w-auto mr-4 mx-5" />
        
            <div class="mx-5 mt-10 w-full sm:w-6/12" >
                <h1 class="text-2xl font-semibold text-blue-900 "  :class = "{'dark:text-white': darkMode}" >
                    {{ appTitle }}
                </h1>
        
                <div id="carouselExampleIndicators1" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="1000">
                    <div class="carousel-indicators1">
                        <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="0" class="active bg-blue-500" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <p class="mt-2  text-gray-500 leading-relaxed text-base text-justify">
                                {{ companySettings[0]['company_info'] }}
                            </p>
                        </div>
                        <div class="carousel-item">
                            <p class="mt-2  text-gray-500 leading-relaxed text-base text-justify">
                                {{ companySettings[0]['company_info_mm'] }}
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

               

                <div class="text-right">
                    <p class="mt-2 text-gray-500 leading-relaxed text-base">
                        Open Daily:   {{ companySettings[0]['open_hour'] }} AM - {{ companySettings[0]['close_hour'] }} PM</p>
                    <p class="mt-2 text-gray-500 leading-relaxed text-base">Close on Every {{ companySettings[0]['close_day'] }}</p>
                    <span class="mt-2 text-gray-500 leading-relaxed text-base flex items-baseline float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill mr-1 mt-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                        </svg>
                        <p class="mt-2 text-gray-500 leading-relaxed text-base">{{ companySettings[0]['phone_number'] }} </p>
                    </span>
                    
                    
                </div>
            </div>
        </div>
        

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8" :class = "{'dark:bg-gray-800': darkMode}">
            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-900">
                        <a :href="route('items.index')" :active="route().current('items.index')" 
                        :class = "{'dark:text-white': darkMode}">
                            Our Products
                        </a>
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 text-base leading-relaxed">
                    <b class="text-base" :class = "{'dark:text-white': darkMode}"> Available Products from our shop !</b>
                    <ul class="list-disc text-base mx-8"  :class = "{'dark:text-gray-500': darkMode}">
                        <li v-for = "c in categories">
                                {{ c }}
                        </li>
                    </ul>
                    
                </p>

                
            </div>
            <div class="  md:grid-cols-2 gap-6 lg:gap-8 ">
                
                <div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <h2 class="ms-3 text-xl font-semibold text-gray-900">
                            <a :href="route('items.index')" :active="route().current('items.index')" 
                            :class = "{'dark:text-white': darkMode}">
                                Our Services
                            </a>
                        </h2>
                    </div>
    
                    <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="1000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active bg-blue-500" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <p class="mt-4 text-gray-500 text-base leading-relaxed">
                                    <b class="text-base" :class = "{'dark:text-white': darkMode}"> Our Services !</b>
                                    <p  :class = "{'dark:text-gray-500': darkMode}" style="white-space: pre-line;"> {{ companySettings[0]['service_info']}}</p>  
                                </p>
                            </div>
                            <div class="carousel-item">
                                <p class="mt-4 text-gray-500 text-base leading-relaxed">
                                    <b class="text-base" :class = "{'dark:text-white': darkMode}"> Our Services !</b>
                                    <p  :class = "{'dark:text-gray-500': darkMode}" style="white-space: pre-line;"> {{ companySettings[0]['service_info_mm']}}</p>  
                                </p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>
            

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-900" :class = "{'dark:text-white': darkMode}">
                        <a href="https://tailwindcss.com/">Contact Us </a>
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 text-base leading-relaxed"  :class = "{'dark:text-gray-500': darkMode}">
                    If you have any questions, please contact our phone number !                
                </p>

                <p class="mt-4 mx-4 text-gray-500 text-base leading-relaxed">
                    <span class="mt-2 text-gray-500 leading-relaxed text-base flex items-baseline "  :class = "{'dark:text-gray-500': darkMode}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill mr-2 mt-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                        </svg> {{ companySettings[0]['phone_number'] }}
                    </span> 
                    
                    <span class="mt-2 text-gray-500 leading-relaxed text-base flex items-baseline "  :class = "{'dark:text-gray-500': darkMode}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope mr-2 mt-2" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                          </svg> {{ companySettings[0]['email'] }}
                    </span>  
                    <span v-if = "companySettings[0]['facebook_page']" class="mt-2  text-gray-500 leading-relaxed text-base flex items-baseline "  :class = "{'dark:text-gray-500': darkMode}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook mr-2 mt-2" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                          </svg> {{ companySettings[0]['facebook_page'] }}
                    </span> 
                    <span class="mt-2 text-gray-500 leading-relaxed text-base flex items-baseline "  :class = "{'dark:text-gray-500': darkMode}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt mr-2 mt-2" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                          </svg> {{ companySettings[0]['address'] }}
                    </span> 
                   
                    </p>
            </div>

            <div>
                <div class="flex items-center" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-900" :class = "{'dark:text-white': darkMode}">
                        
                    </h2>
                </div>
                <p class="mt-4 mx-4 text-gray-500 text-base leading-relaxed">
                    <iframe :src="companySettings[0]['location_point']"
                    width="500" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> 
                </p>
                
            </div>
        </div>
    </div>
</template>
