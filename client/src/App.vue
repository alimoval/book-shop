<template>
  <div id='app'>
    <nav class='navbar navbar-light bg-dark' style='font-weight: 400;'>
      <div class='container'>
        <router-link to='/' class='nav-link'>CARS SHOP</router-link>
        <router-link to='/orders' class='nav-link' v-if='userID'>Orders</router-link>
			  <ul class='nav justify-content-end'>
				  <li class='nav-item' v-if='!userID'>
            <router-link class='nav-link' to='/login'>LOG IN</router-link>
          </li>
          <li class='nav-item' v-if='!userID'>
            <router-link to='/register' class='nav-link'>REGISTER</router-link>
          </li>
          <li class='nav-item' v-if='userID'>
            <a href="#" class='nav-link' v-on:click.prevent='logout'>LOG OUT</a>
          </li>
        </ul>
      </div>
		</nav>
    <div class='row' style='min-height: 50px;'>
      <div class='col-sm-12'>
        <div class='message'></div>
      </div>
    </div>
    <router-view v-bind:userID="userID"></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
  data: function () {
    return {
      userID: null,
      userName: null
    }
  },
  created: function () {
    this.checkUser()
  },
  methods: {
    checkUser: function () {
      this.userID = localStorage.getItem('user_id')
      this.userName = localStorage.getItem('user_name')
      console.log(this.userID + ' ' + this.userName);
    },
    logout: function () {
      localStorage.removeItem('user_id')
      localStorage.removeItem('user_name')
      this.userID = null
      this.userName = null
      this.$router.push('/')
    }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
