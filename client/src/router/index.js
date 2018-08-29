import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/pages/Home'
import CarDetails from '@/pages/CarDetails'
import Login from '@/pages/Login'
import Orders from '@/pages/Orders'
import Register from '@/pages/Register'
import OrderDetails from '@/pages/OrderDetails'
import ThankYou from '@/pages/ThankYou'

Vue.use(Router)

export default new Router({
  base: '/~user16/rest/client/dist/',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/thank-you',
      name: 'Thankyou',
      component: ThankYou
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
