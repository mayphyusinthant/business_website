<script setup>
  
    import { itemStore } from '../store/ItemStore';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SectionBorder from '@/Components/SectionBorder.vue';
    import { Link, Head } from '@inertiajs/vue3';
    import { defineProps , watch } from 'vue';
    import { reactive, ref, onMounted, watchEffect} from 'vue';
    import JetLabel from "@/Components/InputLabel.vue";
    import JetInput from "@/Components/TextInput.vue";
    import axios from 'axios';
    import { useForm } from '@inertiajs/vue3';
    import { getCookie } from '@/utils'; 


    let darkMode = null;

    onMounted(() => {
      if(getCookie('darkMode') == 'on'){
        darkMode = true;
      }else{
        darkMode = false;
      }
      console.log(darkMode)
    });
    const components = {
    JetLabel,
    JetInput
  };

  async function filterData() {
    // Fetch parameter value - art Type
    const par1 = document.getElementsByName('TypeParam')[0];
    const index = par1.selectedIndex;
    const category = par1.options[index].text;
    const url = `/api/items/filter?category=${encodeURIComponent(category)}`;
    itemStore().fetchData(url, 0);

    console.log('Fetched Filtered API Data...', url );
}

  // This search function includes debouncing in order to reduce unnecessary request sent to server per keystoke
  // While maintaining the real-time search functionality 
  async function search() {
    const query = document.getElementsByName('searchQuery')[0].value;
    const url = `/api/items/search?itemName=${encodeURIComponent(query)}`;
    itemStore().fetchData(url, 400);
    console.log('Fetched Search API Data...', url );
  }


  onMounted(async () => {
    if (getCookie('darkMode') == 'on') {
      darkMode = true;
    } else {
      darkMode = false;
    }
    // Fetch item lists data from the API
    itemStore().fetchData('/api/items', 0);
  });

  async function paginate(url) {
  if (url) {
      //Pagination for Filtered Data
      const filtered_query = document.getElementsByName('TypeParam')[0];
      const index = filtered_query.selectedIndex;
      const category = filtered_query.options[index].text;

      //Pagination for Filtered Data
      const search_query = document.getElementsByName('searchQuery')[0].value;
      if(category != ''){
        var indexOfQuestionMark = url.indexOf('?');
        // Split the URL into two parts
        var baseUrl = url.substring(0, indexOfQuestionMark);
        var queryParams = url.substring(indexOfQuestionMark + 1);
        url = `${baseUrl}?category=${encodeURIComponent(category)}&&${queryParams}`;
        itemStore().fetchData(url, 0);
        console.log('Filtered condition');
      }
      else if(search_query){
        var indexOfQuestionMark = url.indexOf('?');
        // Split the URL into two parts
        var baseUrl = url.substring(0, indexOfQuestionMark);
        var queryParams = url.substring(indexOfQuestionMark + 1);
        url = `${baseUrl}?itemName=${encodeURIComponent(search_query)}&&${queryParams}`;

        itemStore().fetchData(url, 400);
        console.log('Search condition');
      }
      else {
        itemStore().fetchData(url, 0);
        console.log('List All condition');
      }
      console.log('Fetched API Data from Page (Pagination):', url);
  }
}

</script>

<!-- resources/js/Pages/Items/Index.vue -->
<template #header>
    <AppLayout title="Item" :class="{ 'dark-mode-class': darkMode }">
        <template #header >
          <div class="grid grid-cols-4 items-center">
            <!-- Item Label -->
            <h2 
            class="col-span-1 md:grid-cols-2 lg:grid-cols-4 font-semibold custom-text-xl text-pink-800 leading-tight" 
            :class="{ 'dark:text-gray-100': darkMode  }">
                Items
            </h2>
            
            <form @submit.prevent="search" class="col-span-1 flex items-center space-x-2 mr-20 sm:flex-col sm:items-start">
              <JetInput name="searchQuery" placeholder="Search By Name"
                @keyup.enter="search" 
                @input="search"> </JetInput>
            </form>

            <form @submit.prevent="filterData" class="col-span-1 flex items-center space-x-2">
                <select name="TypeParam"
                        id="category"
                        class="form-select w-full border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode }"
                >

                    <option value="{{ itemStore().filteredCategory ? itemStore().filteredCategory : '' }}"  selected>{{ itemStore().filteredCategory ? itemStore().filteredCategory : "Filter By Trophy Type" }}</option>
                    <option v-for="category in itemStore().categories" :key="category" :value="category">{{ category  }}</option>
                </select>
        
            
                <span :class="{ 'dark:bg-gray-900': darkMode }" @click="filterData()"
                      class="bg-pink-900 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none">
                    Filter
                </span>
            </form>
          
           
            <!-- Create Button -->
            <!-- <div class="col-span-1 w-full flex justify-end">
                <button class="bg-pink-900 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none"
                        :class="{ 'dark:bg-gray-700': darkMode }">
                    <Link :href="route('items.create')">+ Create</Link>
                </button>
            </div> -->
        </div>

</template>                  


        <div v-if="itemStore().loading" class="flex items-center align-middle justify-center h-screen  " >
          <div role="status">
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-pink-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        
        <div v-else class="py-3" >
          <div class="flex justify-center items-center mt-6">

            <nav aria-label="Page navigation"  class = "flex items-center justify-center "  >
              <ul class="pagination flex">

                  <li v-for="link in itemStore().items.links" :key="link.label">
                      
                        <span v-if="link.label === itemStore().items.current_page || Math.abs(link.label - itemStore().items.current_page) <= 1"
                          @click="paginate(link.url)"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ link.label }}</span>
                        <span @click="paginate(link.url)" v-else-if="Math.abs(link.label - itemStore().items.current_page) <= 2"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">{{ link.label }}</span>
                        <span @click="paginate(link.url)" v-else-if="Math.abs(link.label - itemStore().items.current_page) === 3"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                        <span @click="paginate(itemStore().items.prev_page_url)" :href="itemStore().items.prev_page_url" v-else-if="link.label.includes('Previous')"
                        v-html="link.label" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">  </span>
                        <span :href="itemStore().items.next_page_url" v-else-if="link.label.includes('Next')"
                        v-html="link.label" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">  </span>
                          
                  </li>

                
                </ul>
            </nav>
        </div>
          <!-- Pagination controls -->
         <!-- <nav aria-label="Page navigation"  class = "flex items-center justify-center ">
          <ul class="pagination flex">
    
            <li v-for="link in itemStore().items.links" :key="link.label" class="page-item" :class="{ 'active': link.active, 'disabled': !link.url }">
              <button v-if="link.url" @click="paginate(link.url)"
              :class="{ 'bg-red-900': link.active,  'border-glow': link.active , 'bg-pink-900': !link.active,
              'dark:bg-gray-700': darkMode  , 'dark:text-white': darkMode  }"
              class="px-4 py-2 rounded mx-2 my-2 mb-0 text-white">
              <span v-html="link.label"></span>

              </button>
          </li>
          </ul>
        </nav> -->
 


            <div class="max-w-8xl mx-auto md:p-5 p-2 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                <div class="grid grid-cols-2 md:grid-cols-4 md:gap-4 gap-1">
                  <!-- Loop through items and create a card for each -->
                  <div v-for="item in itemStore().items.data" :key="item.id" class="p-0 bg-pink-950  overflow-hidden shadow-xl rounded-lg text-white text-center" 
                  :class="{ 'dark:bg-gray-700': darkMode}">
                  <!-- <div v-if="item.owner === $page.props.auth.user.id"> -->

                    <div class="w-full md:w-auto flex md:flex justify-end "  >
                      <button v-if="item.status === 'Available'" 
                              class="bg-pink-200 text-pink-900 px-10 py-2 transform rotate-45  translate-y-4 right-[-80%] translate-x-9   m-0">{{ item.status }}</button>
                      <button v-else-if="item.status === 'Sold Out'" 
                              class="bg-red-500 text-white px-10 py-2 transform rotate-45  translate-y-4 right-[-80%] translate-x-9   m-0">{{ item.status }}</button>
                      <button v-else-if="item.status == 'Not For Sale'" 
                      class="bg-red-500 text-white px-10 py-2 transform rotate-45  translate-y-4 right-[-80%] translate-x-9   m-0">{{ item.status }}</button>
                    </div>
                    <div class = "p-5"  >
  
                      <b>{{ item.name }}</b>
                    
                      <div class="w-full h-auto object-cover mb-4">
                        <div :id="'gallery' + item.id" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="2000">
                            <div class="carousel-indicators">
                                <button v-for="(imagePath, index) in item.img.split(',')" :key="index" type="button" :data-bs-target="'#gallery' + item.id" :data-bs-slide-to="index" :class="{ active: index === 0 }" aria-current="true" :aria-label="'Slide ' + (index + 1)"></button>
                            </div>
                            <div class="carousel-inner">
                                <div v-for="(imagePath, index) in item.img.split(',')" :key="index" class="carousel-item" :class="{ active: index === 0 }">
                                    <img :src="imagePath" :alt="'Gallery Image ' + index" class="rounded-xl shadow-xl w-full">
                                </div>
                            </div>
                        </div>
                    </div>


                      <!-- <img :src="`http://127.0.0.1:8000/${item.img}`" class="w-full h-auto object-cover mb-4" alt="Item Image"> -->
                      
                      <p class = "text-justify">{{ item.description }}</p>
                      <hr/>
                      <b>{{ item.category.name }}</b>
                      <p>{{ item.size }} - {{ item.medium }}</p>
                      <p>{{ item.price }} MMK</p>

                      <button class="bg-pink-200 text-pink-950 px-2 py-2 m-1 shadow-xl sm:rounded-lg"> 
                        <Link :href="route('items.view',  { id: item.id })"  >
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          </svg>
                          
                        </Link>               
                      </button>
                    </div>
                    <!-- </div> -->
                  </div> 
              </div>
            </div>
          </div>
        
         
    </AppLayout>
</template>


<style>
  .border-glow {
    box-shadow: 0 0 20px rgba(81, 4, 4, 0.9); 
  }
</style>
