import Vue from 'vue'
import Vuetify, { VSnackbar, VBtn, VIcon } from 'vuetify/lib'
import VuetifyToast from 'vuetify-toast-snackbar'
import ru from "~/locale/ru";

Vue.use(Vuetify, {
  components: {
    VSnackbar,
    VBtn,
    VIcon
  }
})
Vue.use(VuetifyToast)

export default new Vuetify({
    theme: {
        dark: false,
        themes: {
            light: {
                primary: '#263238',
                accent: '#BF360C',
                secondary: '#30b1dc',
                success: '#7CB342',
                info: '#2196F3',
                warning: '#FB8C00',
                error: '#FF7043'
            }
        }
    },
    lang: {
        locales: { ru },
        current: 'ru',
    },
})
