<template>
  <div id="app">
    <nav class="navbar navbar-light bg-dark">
      <router-link to="/" class="nav-link">Cars Shop</router-link>
			<ul class="nav justify-content-end">
				<li class="nav-item">
          <router-link to="/admin" class="nav-link">ADMIN</router-link>
				</li>
				<li class="nav-item">
          <router-link to="/cart" class="nav-link">CART</router-link>
				</li>
			</ul>
		</nav>
    <router-view/>
  </div>
</template>

<script>
  export default {
    name: "App"
  };
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
