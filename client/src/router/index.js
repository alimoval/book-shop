import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/pages/Home'
import BookDetails from '@/pages/BookDetails'
import Login from '@/pages/Login'
import Orders from '@/pages/Orders'
import Register from '@/pages/Register'
import OrderDetails from '@/pages/OrderDetails'
import ThankYou from '@/pages/ThankYou'

Vue.use(Router)

export default new Router({
  // base: '/~user16/book-shop/client/dist',
  mode: 'history',
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
      name: 'BookDetails',
      component: BookDetails
    }
  ]
})
