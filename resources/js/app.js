import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import { createPinia } from 'pinia';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    
    resolve: async (name) => {
        console.log('Resolving component for name:', name);

        // Check if the component is in the Admin module
        if (name.startsWith('Admin/')) {
            return await resolvePageComponent(`../../Modules/AdminModule/resources/${name}.vue`, 
                    import.meta.glob('../../Modules/AdminModule/resources/**/*.vue'));
        }

        else {
            // Check if the component is in the default Pages directory
        return await resolvePageComponent(`./Pages/${name}.vue`, 
                import.meta.glob('./Pages/**/*.vue'));}
    },

    //resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});




