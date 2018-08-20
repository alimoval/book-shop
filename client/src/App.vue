<template>
  <div id='app'>
    <nav class='navbar navbar-light bg-dark' style='font-weight: 400;'>
      <div class='container'>
        <router-link to='/' class='nav-link'>CARS SHOP</router-link>
        <router-link to='/orders' class='nav-link'>Orders</router-link>
			  <ul class='nav justify-content-end'>
				  <li class='nav-item'>
            <router-link class='nav-link' to='/login'>LOG IN</router-link>
          </li>
          <li class='nav-item'>
            <router-link to='/register' class='nav-link'>REGISTER</router-link>
          </li>
        </ul>
      </div>
		</nav>
    <div class='row' style='min-height: 50px;'>
      <div class='col-sm-12'>
        <div class='message'></div>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
  data () {
    return {}
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
