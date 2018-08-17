import Vue from 'vue';
import Router from 'vue-router';

import Home from '@/pages/Home';
import CarDetails from '@/pages/CarDetails';
import Cart from '@/pages/Cart';
import Admin from '@/pages/Admin';

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/:id',
      name: 'CarDetails',
      component: CarDetails
    },
    {
      path: '/cart',
      name: 'Cart',
      component: Cart
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin
    }
  ]
})
