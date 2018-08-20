import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/pages/Home'
import CarDetails from '@/pages/CarDetails'
import Login from '@/pages/Login'
import Orders from '@/pages/Orders'
import Register from '@/pages/Register'
import OrderDetails from '@/pages/OrderDetails'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/orders',
      name: 'Orders',
      component: Orders
    },
    {
      path: '/orders/:id',
      name: 'OrderDetails',
      component: OrderDetails
    },
    {
      path: '/:id',
      name: 'CarDetails',
      component: CarDetails
    }
  ]
})
