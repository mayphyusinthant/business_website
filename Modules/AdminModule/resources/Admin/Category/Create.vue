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


    const errors = ref(null);
    const props = defineProps(['edit', 'category']);
    console.log('edit:', props.edit);
    console.log('Category:', props.category);
    
    const components = {
    JetLabel,
    JetInputError,
    TextInput,
    JetActionMessage
  };


  const formData = useForm({
    name: '',
    description: '',
    status: '',
  });

  const formErrors = ref({
    name: null,
    description: null,
    status: null,
    // Add other form fields errors here
  });

const saveItem = () => {
  console.log(formData);

  if(props.edit === true) {
    formData.put(route('admin.category.update', props.category['id']), {
    // Adjust the data fields based on your form structure
    name: formData.data.name,
    description: formData.data.description,
    status: formData.data.status,

  }, {
    onSuccess: () => {
      // Handle success if needed
    },
    onError: (errors) => {
      // Handle errors if needed
    },
  });

  }
  else {

    formData.post(route('admin.category.store'), {
    // Adjust the data fields based on your form structure
    name: formData.data.name,
    description: formData.data.description,
    status: formData.data.status,

  }, {
    onSuccess: () => {
      // Handle success if needed
    },
    onError: (errors) => {
      // Handle errors if needed
    },
  });

  }
};


  
onMounted(() => {
  // Set the initial value of description based on edit mode
  if (props.edit && props.category) {
    formData.name = props.category['name'];
    formData.description = props.category['description'];
    formData.status = props.category['status'];
  }

});

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

<!-- resources/js/Pages/Category/Create.vue -->
<template #header>
    <AppLayout title="Category">
        <template #header>
            <h1 class="font-semibold custom-text-xl  leading-tight">
                <Link :href="route('admin.category.index')" class = "text-pink-900"  :class="{ 'dark:text-gray-100': darkMode }">Items</Link>
                <span class="text-gray-600" :class="{ 'dark:text-white': darkMode}"> {{ edit ? '/ Edit' : '/ Create' }} </span>
            </h1>
            <div class="py-12" >
                <div class="max-w-7xl mx-auto p-5 sm:px-6 lg:px-8  overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                    <div v-if="errors" class="alert alert-danger">
                        <ul>
                            <li v-for="(error, key) in errors" :key="key">{{ error[0] }}</li>
                        </ul>
                    </div>

                    <form class="w-full max-w-lg flex flex-wrap" @submit.prevent="saveItem" >
                        <!-- Category Name -->
                        <div class="mb-6 w-full md:w-1/2 ">
                            <JetLabel for="name" :class="{ 'dark:text-white': darkMode}" >Category Name</JetLabel>
                            <TextInput  id= "name" type="text" placeholder="Enter Category name"                      
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.name"></TextInput>
                            <JetInputError :message="formData.errors.name" />

                          </div>

                        <!-- Description Textarea -->
                        <div class="mb-6 w-full ">
                          <JetLabel for="description" :class="{ 'dark:text-white': darkMode}">Description</JetLabel>
                          <textarea id="description" placeholder="Enter Category description" 
                          class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                          :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                           v-model="formData.description" rows = "4"> </textarea>
                          <JetInputError :message="formData.errors.description" />

                        </div>
                      
                        <!-- Status Dropdown -->
                        <div class="mb-6 md:w-1/2">
                          <JetLabel for="status" :class="{ 'dark:text-white': darkMode}">Status</JetLabel>
                          <select id="status" class="form-select w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"
                          :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }" v-model="formData.status">
                            <option>Available</option>
                            <option>Sold Out</option>
                          </select>
                          <JetInputError :message="formData.errors.status" />

                        </div>
                      
                        

                        <!-- Submit Button -->
                        <div class="w-full flex md:flex justify-end"> <!-- Add justify-end here to align the button to the right -->
                            <button  class="bg-gray-700 ml-1  text-white py-2 px-4 rounded hover:bg-gray-500 focus:shadow-outline focus:outline-none">
                              <Link :href="route('admin.category.index')" >Back</Link> </button> 
                            <button type="submit"   :class="{ 'dark:bg-gray-900': darkMode}"
                            class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none">
                              {{ edit ? ' Update' : 'Create Category' }} </button>
                        
                              <JetActionMessage :on="formData.recentlySuccessful" >
                                Saved.  ✔
                              </JetActionMessage> 
                        </div>
                      </form>
                  </div>
            </div>
        </template>
        
        
          
    </AppLayout>
</template>

