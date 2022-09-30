import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#7C92FE',
                secondary: '#696969',
                accent: '#8c9eff',
                error: '#b71c1c',
            },
        },
    },
    icons: {
        iconfont: 'md' || 'fa' || 'md'
    }
})
