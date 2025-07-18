import { createApp } from 'vue'

import { aliases, mdi } from 'vuetify/iconsets/mdi'; // Configuración de iconos Material Design Icons (MDI)
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// Crear Vuetify con configuración opcional
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
});

export default vuetify;