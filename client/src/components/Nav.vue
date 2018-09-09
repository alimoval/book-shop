<template>
    <nav class='navbar navbar-light bg-dark' style='font-weight: 400;'>
      <div class='container'>
        <router-link to='/' class='nav-link'>BOOKS SHOP</router-link>
        <router-link to='/orders' class='nav-link' v-if='userId'>Orders</router-link>
			  <ul class='nav justify-content-end'>
				  <li class='nav-item' v-if='!userId'>
            <router-link class='nav-link' to='/login'>LOG IN</router-link>
          </li>
          <li class='nav-item' v-if='!userId'>
            <router-link to='/register' class='nav-link'>REGISTER</router-link>
          </li>
          <li class='nav-item' v-if='userId'>
            <a href="#" class='nav-link' v-on:click.prevent='logout'>LOG OUT</a>
          </li>
        </ul>
      </div>
		</nav>
</template>

<script>
export default {
  name: "Nav",
  props: ['userID'],
  data() {
    return {};
  }
};
</script>