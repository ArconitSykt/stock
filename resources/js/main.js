require('./bootstrap');
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuetify from 'vuetify'
import ru from 'vuetify/es5/locale/ru'
import axios from 'axios'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify, {
  lang: {
    locales: { ru },
    current: 'ru'
  }
})
Event = new Vue();



new Vue({
  el: '#app',
  router,
  axios,
  data() {
    return {
      url: "http://192.168.0.232/stock2.0/public/"
    }
  },
  components: { App },
  template: '<App/>'
}
)

