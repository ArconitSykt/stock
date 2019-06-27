import Vue from 'vue'
import Router from 'vue-router'
import Items from '../components/Items'
import Users from '../components/Users'
import Agreements from '../components/Agreements'
Vue.use(Router)

export default new Router({
  
  routes: [
    {
      path: '/',
      name: 'Items',
      component: Items
    },
    {
      path: '/users',
      name: 'Users',
      component: Users
    },
    {
      path: '/agreements',
      name: 'Agreements',
      component: Agreements
    },
  ]
})
