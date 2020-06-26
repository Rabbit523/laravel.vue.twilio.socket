require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import VueNativeSock from 'vue-native-websocket';
import VueI18n from 'vue-i18n';
import Vuelidate from 'vuelidate';
import CustomerComponent from './components/CustomerComponent.vue';
import ConsultantComponent from './components/ConsultantComponent.vue';
import Locale from './vue-i18n-locales.generated';

import store from './store';
import {
  SOCKET_ONOPEN,
  SOCKET_ONCLOSE,
  SOCKET_ONERROR,
  SOCKET_ONMESSAGE,
  SOCKET_RECONNECT,
  SOCKET_RECONNECT_ERROR
} from './store/mutation-types';
 
const mutations = {
  SOCKET_ONOPEN,
  SOCKET_ONCLOSE,
  SOCKET_ONERROR,
  SOCKET_ONMESSAGE,
  SOCKET_RECONNECT,
  SOCKET_RECONNECT_ERROR
};

if(document.getElementById("chat-component")){
  // Vue.use(VueNativeSock, 'ws://localhost:8081', {
  Vue.use(VueNativeSock, 'wss://status-socket-gotoconsult.fantasylab.io:8081', {
    store: store,
    mutations: mutations,
    reconnection: true,
    reconnectionAttempts: 5,
    reconnectionDelay: 3000,
    format: 'json'
  });
  Vue.use(Vuex);
  Vue.use(VueI18n);
  Vue.use(Vuelidate);
  
  const lang = document.documentElement.lang.substr(0, 2);
  const i18n = new VueI18n({
    locale: lang,
    messages: Locale
  })

  const app = new Vue({
    el: '#chat-component',
    i18n,
    components: {
      'customer-component': CustomerComponent,
      'consultant-component': ConsultantComponent
    }
  });
}