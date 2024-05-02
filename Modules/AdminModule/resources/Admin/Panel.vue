<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SectionBorder from '@/Components/SectionBorder.vue';
    import { Link, Head } from '@inertiajs/vue3';
    import { defineProps , watch } from 'vue';
    import { reactive, ref, onMounted, watchEffect} from 'vue';
    import NavLink from '@/Components/NavLink.vue';
    const props = defineProps(['ItemCount', 'CategoryCount', 'UserCount']);

   
    import { getCookie } from '@/utils'; // Adjust the path based on your project structure
    const components = {
        NavLink
    };
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

<!-- resources/js/Pages/Items/Index.vue -->
<template #header>
    <AppLayout title="Admin Panel" :class="{ 'dark-mode-class': darkMode }">
        <template #header >
            <div class="grid grid-cols-2" >
                <h2 class="font-semibold custom-text-xl  leading-tight">
                    <span class = "text-pink-900"  :class="{ 'dark:text-gray-100': darkMode }">
                         Admin Panel 
                    </span>
                </h2>
          </div>
          
        </template>
        <div class="py-12 text-center">
            <div class="flex flex-wrap justify-center  max-w-7xl gap-4 mx-auto bg-pink-950 p-4 sm:px-6 text-white overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                <div class="w-full md:w-1/4 mb-3">
                    <!-- Card Content Here -->
                    <div class=" p-4 rounded-lg shadow-md">
                        <NavLink :href="route('admin.index')" :active="route().current('admin.index')" 
                            :class = "{'dark:text-gray-100': darkMode} "
                            class="text-white ">
                            <h2 class = "font-bold text-lg" >Products Management</h2>
                        </NavLink>
                        <p class="mt-3 font-semibold text-lg"> Total Products - {{ ItemCount }} </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Create & Update Products </b>
                            <br/>
                            Admins can create new products and modify existing products details such as name, description, images, status and so on.  
                        </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Delete Products  </b>
                            <br/>
                            Admins can delete products that are no longer required. 
                        </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Filter Products  </b>
                            <br/>
                            Admins can also filter products, 
                            facilitating effortless data browsing,
                            in order to display subsets of data based on specific category 
                            to focus on relevant information only.
                        </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Search Products  </b>
                            <br/>
                            Admins can also search specific products, 
                            facilitating effortless data browsing, 
                            to display relevant product information only.
                        </p>
                    </div>
                </div>
                
                <!-- Second Card -->
                <div class="w-full md:w-1/4 mb-3">
                    <!-- Card Content Here -->
                    <div class=" p-4 rounded-lg shadow-md">
                        <NavLink :href="route('admin.category.index')" :active="route().current('admin.category.index')" 
                        :class = "{'dark:text-gray-100': darkMode}"
                        class="text-white">
                        <h2 class = "font-bold text-lg" >  Categories Management</h2>
                       
                        </NavLink>
                        <p class="mt-3 font-semibold text-lg"> Total Categories - {{ CategoryCount }} </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Create & Update Categories </b>
                            <br/>
                            Admins can create new categories and modify existing category details such as name, description, and status.  
                        </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Delete Categories  </b>
                            <br/>
                            Admins can delete categories that are no longer required. However, it's important to note that deleting a category may also remove all items associated with it, so caution is advised.
                        </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Filter Categories  </b>
                            <br/>
                            Admins can also filter categories, 
                            facilitating effortless data browsing,
                            in order to display subsets of data based on specific category 
                            to focus on relevant information only.
                        </p>
                    </div>
                </div>
                
                <!-- Third Card -->
                <div class="w-full md:w-1/4 mb-3">
                    <!-- Card Content Here -->
                    <div class=" p-4 rounded-lg shadow-md">
                        <NavLink :href="route('admin.userList')" :active="route().current('admin.userList')" 
                        :class = "{'dark:text-gray-100': darkMode}"
                        class="text-white">
                        <p class = "font-bold text-lg " > Users Management
                        </p>
                        </NavLink>
                        <p class="mt-3 font-semibold text-lg"> Total Users - {{ UserCount }} </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> View User Lists  </b>
                            <br/>
                            Admins can access a list of all registered users, including their details such as username, email, role, etc.
                        </p>
                        <p class="mt-3 text-justify">
                            <b class="mt-3 text-left"> Ban or Restrict Users (New Version Update)  </b>
                            <br/>
                            In the new version update, admins gain the ability to ban user accounts or apply restrictions to prevent certain actions. This could include restricting access to certain features or suspending accounts temporarily.                        
                        </p>

                    </div>
                </div>

                <div class="w-full mb-3">
                    <!-- Card Content Here -->
                    <div class=" p-4 rounded-lg shadow-md">
                        <NavLink :href="route('')" :active="route().current('admin.userList')" 
                        :class = "{'dark:text-gray-100': darkMode}"
                        class="text-white">
                        <p class = "font-bold text-lg " > Company Information Management
                        </p>
                        </NavLink>
                        
                    </div>
                </div>
            </div>
        </div>
        
        
    </AppLayout>
</template>


