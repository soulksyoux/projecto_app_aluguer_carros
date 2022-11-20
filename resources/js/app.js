/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createStore } from 'vuex'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

// Create a new store instance.
const store = createStore({
    state () {
      return {
        count: 0,
        item: {},
        transacao: { status: '', mensagem: '' }
      }
    },
    mutations: {
      increment (state) {
        state.count++
      }
    }
  })

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import LoginComponent from './components/Login.vue';
app.component('login-component', LoginComponent);

import HomeComponent from './components/Home.vue';
app.component('home-component', HomeComponent);

import MarcasComponent from './components/app/Marcas.vue';
app.component('marcas-component', MarcasComponent);

import InputContainerComponent from './components/layouts/InputContainer.vue';
app.component('input-container-component', InputContainerComponent);

import TableComponent from './components/layouts/Table.vue';
app.component('table-component', TableComponent);

import CardComponent from './components/layouts/Card.vue';
app.component('card-component', CardComponent);

import ModalComponent from './components/layouts/Modal.vue';
app.component('modal-component', ModalComponent);

import AlertComponent from './components/layouts/Alert.vue';
app.component('alert-component', AlertComponent);

import PaginateComponent from './components/layouts/Paginate.vue';
app.component('paginate-component', PaginateComponent);

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

app.use(store);
app.mount('#app');
