/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 import moment from 'moment';

window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('reaction-list', require('./components/items/ReactionList.vue').default);
Vue.component('comment-list', require('./components/items/CommentList.vue').default);

// Index
Vue.component('index-feedbacks', require('./components/index/Feedbacks.vue').default);
Vue.component('index-services', require('./components/index/Services.vue').default);

// Pages
Vue.component('feedback-page',require('./pages/FeedbackPage.vue').default);
Vue.component('servicos-solicitar-page',require('./pages/ServicoSolicitarPage.vue').default);
Vue.component('servicos-acompanhar-page',require('./pages/ServicoAcompanharPage.vue').default);
Vue.component('item-page',require('./pages/ItemPage.vue').default);
Vue.component('edit-page',require('./pages/EditPage.vue').default);
Vue.component('admin-page',require('./pages/AdminPage.vue').default);
Vue.component('lousas-page',require('./pages/LousaPage.vue').default);

// Filtros
Vue.filter('formatDate', function(value) {
    moment.locale();
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
}); 
Vue.filter('prettyDate', function(value) {
    moment.locale('pt-br');
    if (value) {
        return moment(String(value)).fromNow()
    }
}); 
Vue.filter('capitalize', function (value) {
        return value.replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
}); 

Vue.filter('status',function(value){
    if(value == 1) return 'Aguardando';
    else if(value == 2) return 'Em Progresso';
    else if(value == 3) return 'Concluído';
    else if(value == 4) return 'Recusado';
});
Vue.filter('status_class',function(value){
    if(value == 1) return 'aguardando';
    else if(value == 2) return 'progresso';
    else if(value == 3) return 'concluido';
    else if(value == 4) return 'recusado';
});
Vue.filter('status_tag', function (value) {
    if (value === 1) return 'Em análise';
    else if (value === 2) return 'Em produção';
    else if (value === 3) return 'Entregue';
    else if (value === 4) return 'Recusado';
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
