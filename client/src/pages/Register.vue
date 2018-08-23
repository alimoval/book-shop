<template>
  <div class='container'>
    <div class='title'>
      <h2>{{msg}}</h2>
    </div>
    <div class='row top-buffer' style="align: center">
      <div class="col-sm-3"></div>
      <div class='col-sm-6'>
        <form method="post" v-on:submit.stop.prevent='checkForm'>
          <div class='form-group'>
            <label for='name'>Name</label>
            <input type='text' class='form-control' placeholder='user name' id='name' v-model='name'>
          </div>
          <div class='form-group'>
            <label for='emailInput'>Email address</label>
            <input type='email' class='form-control' placeholder='email' id='emailInput' v-model='email'>
            <small id='emailHelp' class='form-text text-muted'>We'll never share your email with anyone else.</small>
          </div>
          <div class='form-group'>
            <label for='pass'>Password</label>
            <input type='password' class='form-control' id='pass' placeholder='password' v-model='password'>
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
  props: ['userID'],
  data () {
    return {
      msg: 'Welcome to the Register Page',
      password: null,
      email: null,
      name: null,
      errors: [],
      message: null
    }
  },
  methods: {
    checkForm: function (e) {
      if (this.email && this.password && this.name) {
        this.proceedForm()
      }
      this.errors = []
      if (!this.email) {
        this.errors.push('enter email.')
      }
      if (!this.password) {
        this.errors.push('enter password.')
      }
      if (!this.name) {
        this.errors.push('enter user name.')
      }
    },
    proceedForm: function () {
      let data = {email: this.email, password: this.password, name: this.name}
      this.$http.post('http://rest/server/api/users/', data)
        .then(response => {
          this.msg = "User Registered"
          console.log(response)
        })
        .catch(error => {
          this.message = error
        })
      this.$router.push('/')
    }
  }
}
</script>
