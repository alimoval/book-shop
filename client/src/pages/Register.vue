<template>
  <div class='container'>
    <div class='title'>
      <h2>{{msg}}</h2>
    </div>
    <div class='row top-buffer' style="align: center">
      <div class="col-sm-3"></div>
      <div class='col-sm-6'>
        <form>
          <div class='form-group'>
            <label for='name'>Name</label>
            <input type='text' class='form-control' placeholder='Enter user name' id='name'>
          </div>
          <div class='form-group'>
            <label for='emailInput'>Email address</label>
            <input type='email' class='form-control' placeholder='Enter email' id='emailInput'>
            <small id='emailHelp' class='form-text text-muted'>We'll never share your email with anyone else.</small>
          </div>
          <div class='form-group'>
            <label for='pass'>Password</label>
            <input type='password' class='form-control' id='pass' placeholder='Password'>
          </div>
          <button type='submit' class='btn btn-primary'>Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'register',
  data () {
    return {
      msg: 'Welcome to the Register Page'
    }
  },
  methods: {
    
  }
}
</script>
