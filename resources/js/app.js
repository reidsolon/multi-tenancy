/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import './bootstrap';

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token

import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import ProductsTable from './components/Products/Table.vue'
import Main from "./components/Auth/Main.vue";
import Register from './components/Auth/Register.vue'
import MainHeader from './components/Main/Header.vue'
import TenantsTable from './components/Tenants/Table.vue'
import UserHeader from './components/User/Header.vue'
import UserHomeScreen from './components/User/Home/Home.vue'

app.component('example-component', ExampleComponent);
app.component('products-table', ProductsTable)
app.component('main-login', Main)
app.component('main-header', MainHeader)
app.component('user-header', UserHeader)
app.component('tenants-table', TenantsTable)
app.component('home', UserHomeScreen)
app.component('register', Register)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.mount('#app');
