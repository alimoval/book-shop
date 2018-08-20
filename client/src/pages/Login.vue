<template>
  <div class='container'>
    <div class='title'>
      <h1>{{msg}}</h1>
    </div>
    <form>
      <div class='form-group'>
        <label for='emailInput'>Email address</label>
        <input type='email' class='form-control' placeholder='Enter email' id="emailInput">
        <small id='emailHelp' class='form-text text-muted'>We'll never share your email with anyone else.</small>
      </div>
      <div class='form-group'>
        <label for='pass'>Password</label>
        <input type='password' class='form-control' id='pass' placeholder='Password'>
      </div>
      <button type='submit' class='btn btn-primary'>Submit</button>
    </form>
  </div>
</template>

<script>
  export default {
    name: 'home',
    data () {
      return {
        msg: 'Welcome to the Login Page'
      }
    }
  }
</script>
