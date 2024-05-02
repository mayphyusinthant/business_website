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
    import { computed, useSlots } from 'vue';

    defineEmits(['submitted']);

    const errors = ref(null);
    const props = defineProps(['edit', 'item', 'categories']);
    console.log('edit:', props.edit);
    console.log('Category:', props.categories);
    
    const components = {
      JetLabel,
      JetInputError,
      TextInput,
      JetActionMessage
    };

    const formData = useForm({
      name: '',
      description: '',
      category: '',
      size: '',
      medium: '',
      status: '',
      price: '',
    });

    const formErrors = ref({
      name: null,
      description: null,
      category: 0,
      size: null,
      medium: null,
      status: null,
      price: 0,
    });

 

    const saveItem1 = () => {
      console.log(props.edit);

      if(props.edit === true) {
        formData.put(route('admin.update', props.item['id']), {
          name: formData.data.name,
          description: formData.data.description,
          category: formData.data.category,
          size: formData.data.size,
          medium: formData.data.medium,
          status: formData.data.status,
          price: formData.data.price,

        }, {
          onSuccess: () => {
          },
          onError: (errors) => {
            // Handle errors if needed
          },
        });
      }
      else {

        formData.post(route('admin.store'), {
        // Adjust the data fields based on your form structure
        name: formData.data.name,
        description: formData.data.description,
        category: formData.data.category,
        size: formData.data.size,
        medium: formData.data.medium,
        status: formData.data.status,
        price: formData.data.price,

      }, {
        onSuccess: () => {
            // Handle success if needed
        },
          onError: (errors) => {
            // Handle errors if needed
        },});

        }
    };

    // Form Input for Photo Uploads
    const form = useForm({
        _method: 'PUT',
        photo: null,
    });

    const photoPreview = ref(null);
    const photoInput = ref(null);

    const updateItemImage = () => {
        if (photoInput.value) {
            form.photo = photoInput.value.files;
            console.log("Selected Photos", form.photo);
        }

        form.post(route('admin.photo.update', props.item['id']), {
            errorBag: 'updateItemImage',
            preserveScroll: true,
            onSuccess: () => clearPhotoFileInput(),
        });
    };

    const selectNewPhoto = () => {
        photoInput.value.click();
    };

    const updatePhotoPreview = () => {
        const photo = photoInput.value.files[0];

        if (! photo) return;

        const reader = new FileReader();

        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };

        reader.readAsDataURL(photo);
    };

    const clearPhotoFileInput = () => {
        if (photoInput.value?.value) {
            photoInput.value.value = null;
        }
    };

  onMounted(() => {
  // Set the initial value of description based on edit mode
  if (props.edit && props.item) {
    formData.name = props.item['name'];
    formData.description = props.item['description'];
    formData.category = props.item['category'];
    formData.size = props.item['size'];
    formData.medium = props.item['medium'];
    formData.status = props.item['status'];
    formData.price = props.item['price'];
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

<!-- resources/js/Pages/Item/Create.vue -->
<template #header>
  <AppLayout title="Item">
      <template #header>
          <h1 class="font-semibold custom-text-xl  leading-tight">
              <Link :href="route('admin.index')" class = "text-pink-900"  :class="{ 'dark:text-gray-100': darkMode }">Items</Link>
              <span class="text-gray-600" :class="{ 'dark:text-white': darkMode}"> {{ edit ? '/ Edit' : '/ Create' }} </span>
          </h1>
          <div class="flex" >
              <div class="max-w-6xl mx-auto py-5 px-6 overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                  <form class="w-full max-w-lg flex flex-wrap"   @submit.prevent="$emit('submitted')"
                    enctype="multipart/form-data">
                      <!-- Item Name -->
                      <div class="mb-6 w-full md:w-1/2 ">

                          <JetLabel for="name" value="Name" />
                          <TextInput
                              id="name"
                              v-model="formData.name"
                              type="text"
                              class="mt-1 block w-full"
                              required
                              autocomplete="name"
                          />
                          <InputError :message="formData.errors.name" class="mt-2" />
                          
                        </div>

                      <div class="mb-6 w-full md:w-1/2 ">
                          <JetLabel for="category" :class="{ 'dark:text-white': darkMode}" >Category</JetLabel>
                          <select name="category"
                                id="category"
                                v-model="formData.category"
                                class="form-select w-full border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"
                                :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode }">
                            <option v-for="(id, name) in props.categories" :key="id" :value="id">{{ name }}</option>
                        </select>

                          <JetInputError :message="formData.errors.category" />

                        </div>

                      <!-- Description Textarea -->
                      <div class="mb-6 w-full ">
                        <JetLabel for="description" :class="{ 'dark:text-white': darkMode}" >Description</JetLabel>
                        <textarea id="description" placeholder="Enter item description" 
                        class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                         v-model="formData.description" rows = "4"> </textarea>
                        <JetInputError :message="formData.errors.description" />

                      </div>
                    
                      <div class="mb-6 w-full md:w-1/2 ">
                        <JetLabel for="size" :class="{ 'dark:text-white': darkMode}"> Size </JetLabel>
                        <TextInput  id= "size" type="text" placeholder="Enter Item Size"                      
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                        v-model="formData.size"></TextInput>
                        <JetInputError :message="formData.errors.size" />

                      </div>

                      <div class="mb-6 w-full md:w-1/2 ">
                        <JetLabel for="medium"  :class="{ 'dark:text-white': darkMode}">Medium</JetLabel>
                        <TextInput  id= "medium" type="text" placeholder="Enter Medium"                      
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                        v-model="formData.medium"></TextInput>
                        <JetInputError :message="formData.errors.medium" />

                      </div>
                      <div class="mb-6 md:w-1/2 ">
                        <JetLabel for="price" :class="{ 'dark:text-white': darkMode}">Item Price</JetLabel>
                        <TextInput  id= "price" type="text" placeholder="Enter Item Price"                      
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                        v-model="formData.price"></TextInput>
                        <JetInputError :message="formData.errors.price" />

                      </div>

                      <!-- Status Dropdown -->
                      <div class="mb-6 md:w-1/2">
                        <JetLabel for="status" :class="{ 'dark:text-white': darkMode}">Status</JetLabel>
                        <select id="status" class="form-select w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"
                        :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }" v-model="formData.status">
                          <option>Available</option>
                          <option>Sold Out</option>
                          <option>Not for Sale</option>

                        </select>
                        <JetInputError :message="formData.errors.status" />

                      </div>
                    
                    <!-- Submit Button -->
                      <div class="w-full flex md:flex justify-end"> <!-- Add justify-end here to align the button to the right -->
                          <button  class="bg-gray-700 ml-1  text-white py-2 px-4 rounded hover:bg-gray-500 focus:shadow-outline focus:outline-none">
                            <Link :href="route('admin.index')" >Back</Link> </button> 
                          
                            <button type="submit"  
                            @click.prevent="saveItem1"  
                            :class="{ 'opacity-25': formData.processing }" 
                            class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none">
                            {{ edit ? ' Update' : 'Create Item' }}  </button>
                      
                            <JetActionMessage :on="formData.recentlySuccessful" >
                              Saved.  ✔
                            </JetActionMessage> 
                      </div>
                    </form>
                </div>

                <div class="max-w-6xl mx-auto py-5 px-6 overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                    <h1 class="font-semibold custom-text-xl  leading-tight flex mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-upload-fill text-gray-600" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0m-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0"/>
                        </svg> 
                        <span class="text-gray-600 px-2" :class="{ 'dark:text-white': darkMode}"> 
                          Upload Image(s)
                      </span>
                    </h1>

                    <form @submit.prevent="$emit('submitted')"
                      class="w-full max-w-xl flex flex-wrap">
                        <div class="px-4 py-5 bg-white sm:p-6"
                        :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'">
                          <input id="photo" ref="photoInput" type="file"
                          class="hidden" @change="updatePhotoPreview" multiple>
                        
                          <!-- Current Profile Photo -->
                          <div v-show="! photoPreview" class="mt-2">
                               <img :src="item.img" 
                                alt="Images" class="rounded-full h-20 w-20 object-cover">
                          </div>
                        
                          <!-- New Profile Photo Preview -->
                          <div v-show="photoPreview" class="mt-2">
                            <span
                                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                :style="'background-image: url(\'' + photoPreview + '\');'"
                            />
                          </div>              
                        
                          <button                          
                          class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none"
                              type="button" @click.prevent="selectNewPhoto">
                              Select A New Photo
                          </button>

                          <button 
                          class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none"
                          type="button" @click.prevent="updateItemImage"  
                          :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                              Save
                          </button>

                          <JetActionMessage :on="form.recentlySuccessful" class="w-1/2" >
                            Saved. ✔
                          </JetActionMessage> 

                          <JetLabel class="text-muted mt-2" :class="{  'dark:text-white': darkMode  }">
                              Notice: If You Save Change, Old Trophy Images will be replaced with your new photos that you selected.
                           </JetLabel> 
                          <JetInputError :message="form.errors.photo2" class="mt-2" />             
                        </div>
                    </form>
                </div>
          </div>
      </template>
      
      
        
  </AppLayout>
</template>

