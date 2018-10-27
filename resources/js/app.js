
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('actions-component', require('./components/relationships/ActionsComponent.vue'));

Vue.component('received-requests', require('./components/contact/ReceivedRequests.vue'));

Vue.component('requests-sent', require('./components/contact/RequestsSent.vue'));

Vue.component('summary-component', require('./components/dashboard/SummaryComponent.vue'));

Vue.component('activity-log', require('./components/dashboard/ActivityLog.vue'));

Vue.component('default-event-activity', require('./components/dashboard/partials/DefaultEventActivity.vue'));

Vue.component('event-activity', require('./components/dashboard/partials/EventActivity.vue'));

/**
 * This let us access the `__` method for localization in VueJS templates
 * ({{ __('user.add_contact_cta') }})
 */
Vue.prototype.__ = (key) => {
    return _.get(window.trans, key, key);
};

const app = new Vue({
    el: '#app'
});

require('./search');

require('./form');

require('./contacts');
