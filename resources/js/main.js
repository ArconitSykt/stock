require('./bootstrap');
import 'material-design-icons-iconfont'
import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuetify from 'vuetify'
import ru from 'vuetify/es5/locale/ru'
import axios from 'axios'
import 'vuetify/dist/vuetify.min.css'
import Config from "./includes/Config";

import { library } from '@fortawesome/fontawesome-svg-core'
import { faPen, faTrash, faPlus, faCopy, faDoorOpen, faChild, faGamepad, faSearch, faCalendarTimes, faSync, faList, faEye, faSave } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'



library.add(faPen, faTrash, faPlus, faCopy, faDoorOpen, faChild, faGamepad, faSearch, faCalendarTimes, faSync, faList, faEye, faSave)
Vue.component('font-awesome-icon', FontAwesomeIcon)


Event = new Vue();
const opts = {
  icons: {
    iconfont: 'mdi',
  },
  lang: {
    locales: { ru },
    current: 'ru'
  },

}
Vue.use(Vuetify)


new Vue({
  el: '#app',
  router,
  axios,
  vuetify: new Vuetify(opts),
  data: {
    url: `${Config.getURL()}`
  },
  components: { App },
  template: '<App/>'
}
)

