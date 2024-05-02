<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SectionBorder from '@/Components/SectionBorder.vue';
    import { Link, Head } from '@inertiajs/vue3';
    import { defineProps , watch } from 'vue';
    import { reactive, ref, onMounted, watchEffect} from 'vue';
    import JetLabel from "@/Components/InputLabel.vue";
    import axios from 'axios';
    import JetActionMessage from "@/Components/ActionMessage.vue";
    import JetConfirmModal from "@/Components/ConfirmationModal.vue";
    import DialogModal from '@/Components/DialogModal.vue';
    import Banner from '@/Components/banner.vue';

    import { useForm } from '@inertiajs/vue3';

    //defineProps({ items: Array})
    const { categories , catTypes, error, success } = defineProps(['categories', 'catTypes', 'error', 'success']);
    console.log('Category' , categories);
    console.log('First Page URL' , categories.first_page_url);
    console.log('Last Page URL' , categories.last_page_url);
    console.log('Links' , categories.links);
    console.log('Next Page URL' , categories.next_page_url);
    console.log('Cat Types' , catTypes);

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

    const components = {
      JetLabel,
      JetActionMessage,
      JetConfirmModal,
      DialogModal,
      Banner
    };

      function myfunc() {
        //Fetch parameter value - art Type
        var par1=document.getElementsByName('TypeParam')[0];
        var index=par1.selectedIndex
        console.log(par1.options[index].text);
        
        var url = '/admin/filter?category=' + encodeURIComponent(par1.options[index].text);
        window.location.href = url;
      }

      const paginate = (url) => {
      if (url) {
        // Extract the current page number from the URL
        const currentPageMatch = url.match(/page=(\d+)/);
        if (currentPageMatch) {
          let currentPage = parseInt(currentPageMatch[1], 10);

          // Increment or decrement the page number
          // You can customize this logic based on your requirements
          if (url.includes('prev')) {
            currentPage--;
          } else if (url.includes('next')) {
            currentPage++;
          }

          // Generate the new URL with the updated page number
          const newUrl = url.replace(/page=\d+/, `page=${currentPage}`);

          // Redirect or perform any other action with the new URL
          console.log('Loading page:', newUrl);
          // Example: Redirect using window.location.href
          window.location.href = newUrl;
        }
      }
    };

    const form = useForm({
        
      });

    const confirmingCategoryDeletion = ref(false);
    const confirmCategoryDeletion = () => {
      confirmingCategoryDeletion.value = true;
    };

    const deleteCategory = (category) => {
      console.log("Debug" , category);
      form.delete(route('admin.category.delete',  { id: category.id }), {
          preserveScroll: true,
          onSuccess: () => closeModal(),
          onFinish: () => form.reset(),
        });
    };

    const closeModal = () => {
        confirmingCategoryDeletion.value = false;
        form.reset();
    };
    
</script>

<!-- resources/js/Pages/Items/Index.vue -->
<template #header>
    <AppLayout title="Item" :class="{ 'dark-mode-class': darkMode }">
        <template #header >
          <div class="grid grid-cols-5 items-center">
            <!-- Category Label -->
            <h2 class="col-span-1 font-semibold custom-text-xl text-pink-800 leading-tight" :class="{ 'dark:text-gray-800': darkMode }">
                Categories
            </h2>
            <form  class="col-span-1 flex items-center space-x-2">
                <select name="TypeParam"
                        id="category"
                        class="form-select w-full border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode }"
                >

                    <option value="catTypes"  selected>{{ catTypes ? 'Select All' : "Filter By Trophy Type" }}</option>
                    <option v-for="category in catTypes" :key="category" :value="category">{{ category }}</option>

                  </select>
        
            
                <span :class="{ 'dark:bg-gray-900': darkMode }" @click="myfunc()"
                      class="bg-pink-900 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none">
                    Filter
                </span>
            </form>

            <!-- Create Category Button -->
            <div class="col-span-1 w-full flex justify-end">
              <button class="bg-pink-900 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none"
                      :class="{ 'dark:bg-gray-700': darkMode }">
                  <Link :href="route('admin.category.create')">Create New Category</Link>
              </button>
          </div>

            
        </div>
        </template>
       
        <div class="py-12" >
          <div class="flex justify-center items-center mt-6">
            <nav aria-label="Page navigation"  class = "flex items-center justify-center "  >
              <ul class="pagination flex">

                  <li v-for="link in categories.links" :key="link.label">
                    <template v-if="link.url">
                      
                        <a v-if="link.label === categories.current_page || Math.abs(link.label - categories.current_page) <= 1"
                            :href="link.url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ link.label }}</a>
                        <a :href="link.url" v-else-if="Math.abs(link.label - categories.current_page) <= 2"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">{{ link.label }}</a>
                        <a :href="link.url" v-else-if="Math.abs(link.label - categories.current_page) === 3"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</a>
                        <a :href="categories.prev_page_url" v-else-if="link.label.includes('Previous')"
                        v-html="link.label" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">  </a>
                        <a :href="categories.next_page_url" v-else-if="link.label.includes('Next')"
                        v-html="link.label" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">  </a>
                          
                          </template>
                  </li>

                
                </ul>
            </nav>
        </div>

        
           <!-- Pagination controls -->
           <!-- <nav aria-label="Page navigation"  class = "flex items-center justify-center "  >
            <ul class="pagination flex">
      
              <li v-for="link in items.links" :key="link.label" class="page-item" :class="{ 'active': link.active, 'disabled': !link.url }">
                <button v-if="link.url" aria-hidden="true" @click="paginate(link.url)"
                :class="{ 'bg-red-900': link.active,  'border-glow': link.active , 'bg-pink-900': !link.active,
                'dark:bg-gray-700': darkMode  , 'dark:text-white': darkMode  }"
                class="px-4 py-2 rounded mx-2 my-2 mb-0 text-white">
                <span v-html="link.label"></span>
              </button>
              </li>

            </ul>
          </nav> -->

            <div 
            class="max-w-8xl mx-auto  p-5 sm:px-6 lg:px-8  overflow-hidden shadow-xl sm:rounded-lg" 
            :class="{ 'dark:bg-gray-800': darkMode , 'dark:text-white': darkMode}">

            <Banner :v-if="show && message"/> 
            
            <!-- <div v-if="error" class="alert alert-danger">
              {{ error }}
            </div>
            <div v-if="success" class="alert alert-success">
              {{ success }}
            </div> -->

              <!-- Table -->
              Page {{ categories.current_page }} of Total {{ categories.last_page }} Pages

              <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-white uppercase bg-pink-900" :class="{ 'dark:bg-gray-800': darkMode }">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Product Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center"> Description
                                    <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                      </svg>
                                    </a>
                                </div>
                            </th>
                        <th scope="col" class="px-6 py-3">
                          <div class="flex items-center">Created By
                              <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                  <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                              </a>
                          </div>
                      </th>

                      <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">Updated By
                            <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                              </svg>
                            </a>
                        </div>
                      </th> 
                          <th scope="col" class="px-6 py-3">
                              <div class="flex items-center">
                                  Status
                                  <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                    </svg>
                                  </a>
                              </div>
                          </th>
                          <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">Created At
                                <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                  </svg>
                                </a>
                            </div>
                          </th> 
                          <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">Updated At
                                <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                  </svg>
                                </a>
                            </div>
                          </th> 
                          <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Actions
                                <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                  </svg>
                                </a>
                            </div>
                        </th>
                         
                      </tr>
                  </thead>
                  <tbody>
                    
                    <template v-for="category in categories.data" :key="category.id">

                        <tr  class="border-b text-pink-950"  :class="{ 'dark:bg-gray-450': darkMode  , 'dark:text-white': darkMode  }">
                            <th scope="row" class="px-6 py-4 font-mediumwhitespace-nowrap" style="width: 50px;">
                                {{ category.name }}
                            </th>
                            <td class="px-6 py-4" style="width: 250px;">
                                {{ category.description }}
                            </td>
                            <td class="px-6 py-4">
                              {{ category.created_by.name }}
                            </td>
                            <td class="px-6 py-4">
                              {{ category.updated_by.name }}
                            </td>
                            <td class="px-6 py-4">
                              {{ category.status }}
                          </td>
                          <td class="px-6 py-4">
                            {{ dateFormattter(category.created_at) }}
                        </td>
                        <td class="px-6 py-4">
                          {{ dateFormattter(category.updated_at) }}
                      </td>
                            <td class="px-6 py-4 text-right">
                              <button class="bg-pink-200 text-pink-950 px-2 py-2 m-1 shadow-xl sm:rounded-lg"> 
                                <Link :href="route('admin.category.view',  { id: category.id })"  >
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                  </svg>
                                  
                                </Link>               
                              </button>
                              <button class="bg-pink-200 text-pink-950 px-2 py-2 m-1 shadow-xl sm:rounded-lg"> 
                                <Link :href="route('admin.category.edit',  { id: category.id })" :data="{ edit: true }" >
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                  </svg>
                                </Link>               
                              </button>
                              <!-- <button class="bg-pink-200 text-pink-950 px-2 py-2 m-1 shadow-xl sm:rounded-lg"> 
                                <Link :href="route('admin.category.delete',  { id: category.id })" >
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                  </svg>
                                </Link>
                              </button> -->


                              <div class="mt-0">
                                <button  @click="confirmCategoryDeletion"
                                  class="bg-pink-200 text-pink-950 px-2 py-2 m-1 shadow-xl sm:rounded-lg"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                      <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                              <!-- Delete Item Confirmation Modal -->
                              <DialogModal :show="confirmingCategoryDeletion" @close="closeModal">
                                <template #title>
                                    Delete Category
                                </template>
                
                                <template #content>
                                    Are you sure you want to delete this category ?                 
                                </template>
                
                                <template #footer>
                                    <button 
                                        class="bg-gray-600 text-white px-2 py-2 m-1 shadow-xl sm:rounded-lg"
                                        @click="closeModal">
                                        Cancel
                                    </button>
                                    
                                    <button 
                                        class="bg-pink-950 text-white px-2 py-2 m-1 shadow-xl sm:rounded-lg"
                                        @click="deleteCategory(category)">
                                        Delete Current Category 
                                    </button>
                                </template>
                            </DialogModal>
                            </td>
                        </tr>
                    </template>
                </tbody>
                
                </table> 
              </div>
            </div>
          </div>
        
    </AppLayout>
</template>


<style>
  .border-glow {
    box-shadow: 0 0 15px rgb(94, 3, 3) ; /* Adjust the size and color as needed */
  }
</style>


<script>
    function dateFormattter(dateStr){
      const dateObj = new Date(dateStr);

      const year = dateObj.getFullYear();
      const month = (dateObj.getMonth() + 1).toString().padStart(2, '0'); // Adding 1 because months are zero-based
      const day = dateObj.getDate().toString().padStart(2, '0');
      const hours = dateObj.getHours().toString().padStart(2, '0');
      const minutes = dateObj.getMinutes().toString().padStart(2, '0');
      const seconds = dateObj.getSeconds().toString().padStart(2, '0');

      const formattedDate = `${year}-${month}-${day}-${hours}:${minutes}:${seconds}`;
      console.log(formattedDate);
      return formattedDate;
    }
</script>