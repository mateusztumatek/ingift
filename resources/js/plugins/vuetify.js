import Vue from 'vue';
import Vuetify from 'vuetify';

Vue.use(Vuetify)


const opts = {
    theme: {
        themes: {
            light: {
                primary: '#4c7bab', // #E53935
                secondary: '#4c7bab', // #E4E6E9
            },
        },
    },
}

export default new Vuetify(opts)
