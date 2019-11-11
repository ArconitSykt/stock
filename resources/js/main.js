require('./bootstrap');
import 'material-design-icons-iconfont'
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuetify from 'vuetify'
import ru from 'vuetify/es5/locale/ru'
import axios from 'axios'
import 'vuetify/dist/vuetify.min.css'
import Config from "./includes/Config";

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
  data: {
    url: `${Config.getURL()}`
  },
  components: { App },
  template: '<App/>'
}
)

