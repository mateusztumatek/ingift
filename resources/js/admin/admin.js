require('./bootstrap.js');
window.Vue = require('vue');
import VueKonva from 'vue-konva'
Vue.use(VueKonva);
Vue.mixin({
    methods:{
        getSrc(src){
            return this.$root.getSrc(src);
        }
    }
})
Vue.prototype.$eventBus = new Vue();
Vue.component('products-attributes', require('./components/product-attributes').default);
Vue.component('products-placeholder', require('./components/image-placeholder').default);
Vue.component('categories-components', require('./components/categories').default);
Vue.component('tags-input', require('../admin/components/tag-input').default);

Vue.mixin({
    methods:{
        storage(path){
            return this.$root.base_url+'/storage/'+path;
        }
    }
})
const app = new Vue({
    el: '#admin_app',
    data(){
        return {
            base_url: null
        }
    },
    created(){
        this.base_url = base_url;
    },

    methods: {
        getSrc(src, params){
            if(params){}
            return this.base_url+'/storage/'+src;
        },
    }
});




