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
    const props = defineProps([ 'companySettings']);
    console.log('Company Settings:', props.companySettings);
    
    const components = {
    JetLabel,
    JetInputError,
    TextInput,
    JetActionMessage
  };


  const formData = useForm({
    name: '',
    info: '',
    service: '',
    info_mm: '',
    service_mm: '',
    phone: '',
    email: '',
    address: '',
    facebook_page: '',
    open_hour: '',
    close_hour: '',
    close_day: '',
    img: '',
    location_point: '',


  });

  const formErrors = ref({
    name: null,
    info: null,
    service: null,
    info_mm: null,
    service_mm: null,
    phone: 0,
    email: null,
    address: null,
    facebook_page: null,
    open_hour: null,
    close_hour: null,
    close_day: null,
    img: null,
    location_point: null,
  });

const saveItem = () => {
  console.log(formData);

    formData.put(route('company_setting.save', props.companySettings[0]['id']), {
        
        name: formData.data.name,
        info: formData.data.info,
        service: formData.data.service,
        info_mm: formData.data.info_mm,
        service_mm: formData.data.service_mm,
        phone: formData.data.phone,
        email: formData.data.email,
        address: formData.data.address,
        facebook_page: formData.data.facebook_page,
        open_hour: formData.data.open_hour,
        close_hour: formData.data.close_hour,
        close_day: formData.data.close_day,
        location_point: formData.data.location_point

  }, {
    onSuccess: () => {
      // Handle success if needed
    },
    onError: (errors) => {
      // Handle errors if needed
    },
  });


  
};


  
onMounted(() => {
  // Set the initial value of description based on edit mode
  if (props.companySettings) {
        formData.name = props.companySettings[0]['company_name'],
        formData.info = props.companySettings[0]['company_info'],
        formData.service = props.companySettings[0]['service_info'],
        formData.info_mm = props.companySettings[0]['company_info_mm'],
        formData.service_mm = props.companySettings[0]['service_info_mm'],
        formData.phone = props.companySettings[0]['phone_number'],
        formData.email = props.companySettings[0]['email'],
        formData.address = props.companySettings[0]['address'],
        formData.facebook_page = props.companySettings[0]['facebook_page'],
        formData.open_hour = props.companySettings[0]['open_hour'],
        formData.close_hour = props.companySettings[0]['close_hour'],
        formData.close_day = props.companySettings[0]['close_day'],
        formData.location_point = props.companySettings[0]['location_point']


  }
  return formData;
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


<template #header>
    <AppLayout title="Admin Panel" :class="{ 'dark-mode-class': darkMode }">
        <template #header >
            <div class="grid grid-cols-5 items-center">
              <h2 class="col-span-1 font-semibold custom-text-xl text-pink-800 leading-tight" 
              :class="{ 'dark:text-white': darkMode }">
                  Company Settings
              </h2>
            </div>

            <div class="py-12" >
                <div class="max-w-7xl mx-auto p-5 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg" :class="{ 'dark:bg-gray-800': darkMode }">
                    <div v-if="errors" class="alert alert-danger">
                        <ul>
                            <li v-for="(error, key) in errors" :key="key">{{ error[0] }}</li>
                        </ul>
                    </div>

                    <form class="w-full max-w-xl flex flex-wrap" @submit.prevent="saveItem" >

                        <div class="mb-6 w-full md:w-1/2 ">
                            <JetLabel for="name"  :class="{  'dark:text-white': darkMode  }">Company Name</JetLabel>
                            <TextInput  id= "name" type="text" placeholder="Enter Company Name"                      
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.name"></TextInput>
                            <JetInputError :message="formData.errors.name" />

                          </div>

                          <div class="mb-6 md:w-1/2">
                            <JetLabel for="img" :class="{  'dark:text-white': darkMode  }">Image</JetLabel>
                            <TextInput id="img"  type="file" class="form-input w-full" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode }"
                            v-model="formData.img"  >
                               
                            </TextInput>
                            <JetInputError :message="formData.errors.img" />
    
                          </div>

                          <div class="mb-6 w-full  ">
                            <JetLabel for="info" :class="{  'dark:text-white': darkMode  }">Company Info (English)</JetLabel>
                            <textarea  id= "info" type="text" placeholder="Enter Company Information" 
                            class="form-textarea w-full border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"                      
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.info" rows="5"></textarea>
                            <JetInputError :message="formData.errors.info" />

                          </div>

                          <div class="mb-6 w-full  ">
                            <JetLabel for="info_mm" :class="{  'dark:text-white': darkMode  }">Company Info (Burmese)</JetLabel>
                            <textarea  id= "info_mm" type="text" placeholder="Enter Company Information" 
                            class="form-textarea w-full border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"                      
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.info_mm" rows="5"></textarea>
                            <JetInputError :message="formData.errors.info_mm" />

                          </div>

                          <div class="mb-6 w-full ">
                            <JetLabel for="service" :class="{  'dark:text-white': darkMode  }">Our Services (English)</JetLabel>
                            <textarea  id= "service" type="text"   
                            class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"     
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.service" rows="5" ></textarea>
                            <JetInputError :message="formData.errors.service" />

                          </div>

                          <div class="mb-6 w-full ">
                            <JetLabel for="service_mm" :class="{  'dark:text-white': darkMode  }">Our Services (Burmese) </JetLabel>
                            <textarea  id= "service_mm" type="text"   
                            class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm"     
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.service_mm" rows="5" ></textarea>
                            <JetInputError :message="formData.errors.service_mm" />

                          </div>

                          <div class="mb-6 md:w-1/2 ">
                            <JetLabel for="phone" :class="{  'dark:text-white': darkMode  }">Phone Number </JetLabel>
                            <TextInput  id= "phone" type="text" placeholder="Enter Office Phone Number"                      
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                            v-model="formData.phone"></TextInput>
                            <JetInputError :message="formData.errors.phone" />
    
                          </div>

                        <div class="mb-6 w-full md:w-1/2 ">
                            <JetLabel for="email" :class="{  'dark:text-white': darkMode  }">Email Address</JetLabel>
                            <TextInput id="email" placeholder="Enter Email Address" 
                            class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.email" > </TextInput>
                            <JetInputError :message="formData.errors.email" />
  
                          </div>

                          

                          <div class="mb-6 w-full ">
                            <JetLabel for="address" :class="{  'dark:text-white': darkMode  }">Office Address</JetLabel>
                            <textarea id="address" placeholder="Enter Office Address" 
                            class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.address" rows = "3"> </textarea>
                            <JetInputError :message="formData.errors.address" />
                          </div>

                          <div class="mb-6 w-full ">
                            <JetLabel for="facebook_page" :class="{  'dark:text-white': darkMode  }">Facebook Page (Optional)</JetLabel>
                            <textarea id="facebook_page" placeholder="Enter Facebook Page Name" 
                            class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.facebook_page" rows = "1"> </textarea>
                            <JetInputError :message="formData.errors.facebook_page" />
                          </div>

                          <div class="mb-6 w-full ">
                            <JetLabel for="location_point" :class="{  'dark:text-white': darkMode  }">Location Point</JetLabel>
                            <textarea id="location_point" placeholder="Location Point" disabled
                            class="form-textarea w-full  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.location_point" rows = "4"> </textarea>
                            <JetInputError :message="formData.errors.location_point" />
  
                          </div>

                          <div class="mb-6 w-full md:w-1/2 ">
                            <JetLabel for="open_hour" :class="{  'dark:text-white': darkMode  }">Open Hour</JetLabel>
                            <TextInput id="open_hour" placeholder="Enter Open Hour" 
                            class=" border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.open_hour"> </TextInput>
                            <JetInputError :message="formData.errors.open_hour" />
  
                          </div>

                          <div class="mb-6 w-full md:w-1/2 ">
                            <JetLabel for="close_hour" :class="{  'dark:text-white': darkMode  }">Close Hour</JetLabel>
                            <TextInput id="close_hour" placeholder="Enter Close Hour" 
                            class="  border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.close_hour" rows = "4"> </TextInput>
                            <JetInputError :message="formData.errors.close_hour" />
  
                          </div>

                          <div class="mb-6 w-full md:w-1/3 ">
                            <JetLabel for="close_day" :class="{  'dark:text-white': darkMode  }">Close Day</JetLabel>
                            <TextInput id="close_day" 
                            class=" border-gray-300 focus:border-pink-400 focus:ring-pink-400 rounded-md shadow-sm" 
                            :class="{ 'dark:bg-gray-800': darkMode, 'focus:border-none': darkMode, 'focus:ring-white': darkMode, 'dark:text-white': darkMode  }"
                             v-model="formData.close_day" rows = "4"> </TextInput>
                            <JetInputError :message="formData.errors.close_day" />
  
                          </div>

                         
                      
                        <!-- Submit Button -->
                        <div class="w-full flex md:flex justify-end"> <!-- Add justify-end here to align the button to the right -->
                            <button  class="bg-gray-700 ml-1  text-white py-2 px-4 rounded hover:bg-gray-500 focus:shadow-outline focus:outline-none">
                              <Link :href="route('company_setting.view')" >Back</Link> </button> 
                            <button type="submit"   :class="{ 'dark:bg-gray-900': darkMode}"
                            class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none">
                              Update Settings </button>
                        </div>
                      </form>
                  </div>
            </div>

        </template>
        <div>

        </div>      
    </AppLayout>
</template>


