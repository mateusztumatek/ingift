import Vue from 'vue';
Vue.component('cart-component', require('./app/components/cart.vue').default);
Vue.component('sidebar-component', require('./app/components/sidebar.vue').default);
Vue.component('header-component', require('./app/components/header.vue').default);
Vue.component('errors', require('./app/components/errors').default);
Vue.component('quantity-input', require('./app/components/quantity-input').default);
Vue.component('image-uploader', require('./app/components/image-uploader').default);
Vue.component('color-select', require('./app/components/color-select').default);
Vue.component('rate-section', require('./app/rate-section').default);
