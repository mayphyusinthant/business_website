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
    import Banner from '@/Components/banner.vue';

    defineEmits(['submitted']);
    const hasActions = computed(() => !!form);

    const errors = ref(null);
    const props = defineProps([ 'companySettings']);
    console.log('Company Settings:', props.companySettings);
    
    const components = {
        JetLabel,
        JetInputError,
        TextInput,
        JetActionMessage,
        Banner
    };


    // Start Top Section
    const form1 = useForm({
        _method: 'PUT',
        photo: null,
    });

    const photoPreview1 = ref(null);
    const photoInput1 = ref(null);

    const updateProfileInformation1 = () => {
        if (photoInput1.value) {
            form1.photo = photoInput1.value.files;
            console.log("Selected Photos", form1.photo);
        }

        form1.post(route('company_setting.photos.save1'), {
            errorBag: 'updateProfileInformation',
            preserveScroll: true,
            onSuccess: () => clearPhotoFileInput1(),
        });
    };

    const selectNewPhoto1 = () => {
        photoInput1.value.click();
    };

    const updatePhotoPreview1 = () => {
        const photo1 = photoInput1.value.files[0];

        if (! photo1) return;

        const reader = new FileReader();

        reader.onload = (e) => {
            photoPreview1.value = e.target.result;
        };

        reader.readAsDataURL(photo1);
    };

    const clearPhotoFileInput1 = () => {
        if (photoInput1.value?.value) {
            photoInput1.value.value = null;
        }
    };
    // End Top Section

    // Start Bottom Section
    const form = useForm({
        _method: 'PUT',
        photo: null,
    });

    const photoPreview = ref(null);
    const photoInput = ref(null);

    const updateProfileInformation = () => {
        if (photoInput.value) {
            form.photo = photoInput.value.files;
            console.log("Selected Photos", form.photo);
        }

        form.post(route('company_setting.photos.save2'), {
            errorBag: 'updateProfileInformation',
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
    // End Bottom Section


    // onMounted(() => {
    // // Set the initial value of description based on edit mode
    // if (props.companySettings) {
    //         //formData.photos = props.companySettings[0]['photos'],

    // }
    // // return formData;
    // });

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
                    <Banner :v-if="show && message"/>  

                     <!-- Gallery 1 Photos - Bottom Section of Home Page -->
                     <form @submit.prevent="$emit('submitted')"
                     class="w-full max-w-xl flex flex-wrap">
                     
                       <div
                           class="px-4 py-5 bg-white sm:p-6"
                           :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
                       >
                                       <input
                                           id="photo1"
                                           ref="photoInput1"
                                           type="file"
                                           class="hidden"
                                           @change="updatePhotoPreview1" multiple
                                       >
                                       <JetLabel for="photo1" value="Images for Home Page - Top Section" />
                       
                                       <!-- Current Profile Photo -->
                                       <div v-show="! photoPreview1" class="mt-2">
                                        <img :src="companySettings[0]['gallery1_photos'].split(',')[0]" 
                                        alt="Gallery 1 Photos" class="rounded-full h-20 w-20 object-cover">
                                    </div>
                    
                       
                                       <!-- New Profile Photo Preview -->
                                       <div v-show="photoPreview1" class="mt-2">
                                           <span
                                               class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                               :style="'background-image: url(\'' + photoPreview1 + '\');'"
                                           />
                                       </div>
                       
                                       <button                          
                                       class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none"
                                           type="button" @click.prevent="selectNewPhoto1">
                                           Select A New Photo
                                       </button>

                                       <button 
                                       class="bg-pink-900 ml-1 text-white py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none"
                                       type="button" @click.prevent="updateProfileInformation1"  
                                       :class="{ 'opacity-25': form1.processing }" :disabled="form1.processing">
                                           Save
                                       </button>

                                       <JetLabel class="text-muted mt-2" :class="{  'dark:text-white': darkMode  }">
                                           Notice: If You Save Change, Old Photos will be replaced with your new photos.
                                           Photos that you upload will be shown in Home Page Top Section.
                                        </JetLabel> 
                       
                                       <JetInputError :message="form.errors.photo1" class="mt-2" />
                       </div>
                   </form>
                    
                      <!-- Gallery 2 Photos - Bottom Section of Home Page -->
                      <form @submit.prevent="$emit('submitted')"
                      class="w-full max-w-xl flex flex-wrap">
                      
                        <div
                            class="px-4 py-5 bg-white sm:p-6"
                            :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
                        >
                                        <input
                                            id="photo"
                                            ref="photoInput"
                                            type="file"
                                            class="hidden"
                                            @change="updatePhotoPreview" multiple
                                        >
                                        <JetLabel for="photo" value="Images for Home Page - Bottom Section" />
                        
                                        <!-- Current Profile Photo -->
                                        <div v-show="! photoPreview" class="mt-2">
                                            <img :src="companySettings[0]['gallery2_photos'].split(',')[0]" 
                                            alt="Gallery 2 Photos" class="rounded-full h-20 w-20 object-cover">
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
                                        type="button" @click.prevent="updateProfileInformation"  
                                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Save
                                        </button>

                                        <JetLabel class="text-muted mt-2" :class="{  'dark:text-white': darkMode  }">
                                            Notice: If You Save Change, Old Photos will be replaced with your new photos.
                                            Photos that you upload will be shown in Home Page Bottom Section.
                                         </JetLabel> 
                        
                                        <JetInputError :message="form.errors.photo2" class="mt-2" />
                        </div>
                    </form>

                  </div>
            </div>
        </template>

        
        
        <div>

        </div>      
    </AppLayout>
</template>


