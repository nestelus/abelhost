require('./bootstrap');

window.Vue = require('vue');

Vue.component('projects', require('./components/Projects.vue').default);

const app = new Vue({
    el: '#app'
});