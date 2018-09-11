<template>
  <div class='container'>
    <div class='title'>
      <h1>{{msg}}</h1>
    </div>
    <div class='row top-buffer' style='align: center'>
      <div class='col-sm-3'></div>
      <div class='col-sm-6'>
        <form v-on:submit.stop.prevent='checkForm' method='post'>
          <div class='form-group'>
            <input type='email' class='form-control' placeholder='Email' v-model='email'>
            <small id='emailHelp' class='form-text text-muted'>We'll never share your email with anyone else.</small>
          </div>
          <div class='form-group'>
            <input type='password' class='form-control' placeholder='Password' v-model='password'>
          </div>
          <button type='submit' class='btn btn-primary'>Submit</button>
        </form>
        <p v-if="errors.length" style='padding-top:30px'>
          <ul>
            <li v-for="error in errors" v-bind:key='error.id'>{{ error }}</li>
          </ul>
        </p>
        {{message}}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'login',
  data () {
    return {
      msg: 'Welcome to the Login Page',
      password: null,
      email: null,
      errors: [],
      message: null,
      userId: null
    }
  },
  methods: {
    checkForm: function (e) {
      if (this.email && this.password) {
        this.proceedForm()
      }
      this.errors = []
      if (!this.email) {
        this.errors.push('Enter Email.')
      }
      if (!this.password) {
        this.errors.push('Enter Password.')
      }
    },
    proceedForm: function () {
      let data = {email: this.email, password: this.password}
      this.$http.post('http://book-shop/server/api/users/login', data)
      // this.$http.post('http://192.168.0.15/~user16/rest/client/api/users/login', data)
        .then(response => {
          if (response.body.id) {
            localStorage.setItem('user_id', response.body.id)
            this.$emit('setUser', response.body.id)
          } else if (response.body.message) {
            this.errors.push(response.body.message)
          }
        })
        .catch(error => {
          this.message = error
        })
    }
  }
}
</script>
