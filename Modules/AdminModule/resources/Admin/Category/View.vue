<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SectionBorder from '@/Components/SectionBorder.vue';
    import { Link, Head } from '@inertiajs/vue3';
    import { defineProps , watch } from 'vue';
    import { reactive, ref, onMounted, watchEffect} from 'vue';

   
    const { category } = defineProps(['category']);

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

<!-- resources/js/Pages/Category/View.vue -->
<template #header>
    <AppLayout title="Item" :class="{ 'dark-mode-class': darkMode }">
        <template #header >
            <div class="grid grid-cols-2" >
                <h2 class="font-semibold custom-text-xl  leading-tight">
                    <Link :href="route('items.index')" class = "text-pink-900"  :class="{ 'dark:text-gray-100': darkMode }">Items</Link>
                    <span class="text-gray-600"> / View Detail </span>
                </h2>
          </div>
          
        </template>
        <div class="py-12 text-center">
            <div class="max-w-screen-md mx-auto bg-pink-950 p-5 sm:px-6 lg:px text-white overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                <div class="col-span-4 mx-auto" :class="{ 'dark:text-white': darkMode}" >
                    <b>{{ category.name }}</b><br/>
                    <!-- <img :src="`http://127.0.0.1:8000/${item.img}`" class="block mx-auto h-auto object-cover mb-4 w-100" alt="Item Image"> -->
                    <p class="text-justify">{{ category.description }}</p> <br/>
                    <hr/>
                    <p>{{ category.status }} </p>
                    <p>{{ category.createdBy }} </p>
                    <p>{{ category.updatedBy }} </p>
                    <p>
                        Created By - {{ category.created_by.name }} 
                        : {{ dateFormattter(category.created_at) }}
                    </p>
                    <p>Updated By - {{ category.updated_by.name }} 
                        : {{ dateFormattter(category.updated_at) }}

                    </p>

                    <button  class=" ml-1  text-white py-2 px-4 rounded hover:bg-gray-500  bg-pink-900 focus:shadow-outline focus:outline-none">

                        <Link :href="route('admin.category.index')" class="text-white" :class="{ 'dark:text-white': darkMode }">Back</Link>

                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


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
