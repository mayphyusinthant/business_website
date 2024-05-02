<script setup>
defineProps({
    on: Boolean,
});
</script>

<template>
    <div>
        <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="on" 
            class="text-sm text-white bg-green-600 ml-1  py-2 px-4 rounded hover:bg-pink-950 focus:shadow-outline focus:outline-none">
                <slot />
            </div>
        </transition>
    </div>
</template>
