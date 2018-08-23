<template>
  <div id='app'>
    <nav class='navbar navbar-light bg-dark' style='font-weight: 400;'>
      <div class='container'>
        <router-link to='/' class='nav-link'>CARS SHOP</router-link>
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
    <div class='row' style='min-height: 50px;'>
      <div class='col-sm-12'>
        <div class='message'>{{msg}}</div>
      </div>
    </div>
    <router-view v-bind:userID='userId' v-on:setUser='setUserID($event)'></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
  data: function () {
    return {
      userId: null,
      msg: null
    }
  },
  created () {
    this.getUserFromLocalStorage()
  },
  methods: {
    getUserFromLocalStorage: function() {
      this.userId = localStorage.getItem('user_id')
    },
    setUserID: function (id) {
      this.userId = id
      this.$router.push('/')
    },
    logout: function () {
      this.userId = null
      localStorage.removeItem('user_id')
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
