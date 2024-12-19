import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import router from './router'
import { aliases, mdi } from 'vuetify/iconsets/mdi'

// import { createInertiaApp } from '@inertiajs/vue3';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
// import vuetify from './plugins/vuetify';
// import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import App from './App.vue'

//const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const vuetify = createVuetify({
    icons: {
      defaultSet: 'mdi',
      aliases,
      sets: {
        mdi,
    },
},
components,
directives,
})

createApp(App).use(vuetify).use(router).mount('#app')

