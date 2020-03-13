require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import VueNativeSock from 'vue-native-websocket';

import CustomerComponent from './components/CustomerComponent.vue';
import ConsultantComponent from './components/ConsultantComponent.vue';

import store from './store'
import {
  SOCKET_ONOPEN,
  SOCKET_ONCLOSE,
  SOCKET_ONERROR,
  SOCKET_ONMESSAGE,
  SOCKET_RECONNECT,
  SOCKET_RECONNECT_ERROR
} from './store/mutation-types'
 
const mutations = {
  SOCKET_ONOPEN,
  SOCKET_ONCLOSE,
  SOCKET_ONERROR,
  SOCKET_ONMESSAGE,
  SOCKET_RECONNECT,
  SOCKET_RECONNECT_ERROR
}
 
Vue.use(VueNativeSock, 'ws://localhost:8081/one2one', {
  store: store,
  mutations: mutations,
  reconnection: true,
  reconnectionAttempts: 5,
  reconnectionDelay: 3000,
  format: 'json'
})
Vue.use(Vuex)

const app = new Vue({
  el: '#chat-component',
  components: {
    'customer-component': CustomerComponent,
    'consultant-component': ConsultantComponent
  }
});