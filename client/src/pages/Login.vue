<template>
  <div class='container'>
    <div class='title'>
      <h1>{{msg}}</h1>
    </div>
    <div class='row top-buffer' style='align: center'>
      <div class='col-sm-3'></div>
      <div class='col-sm-6'>
        <form v-on:submit.stop.prevent='checkForm' method='post'>
          <p v-if="errors.length">
            <b>Пожалуйста исправьте указанные ошибки:</b>
            <ul>
              <li v-for="error in errors" v-bind:key='error.id'>{{ error }}</li>
            </ul>
          </p>
          <div class='form-group'>
            <label for='emailInput'>Email address</label>
            <input type='email' class='form-control' placeholder='Enter email' id='emailInput' v-model='email'>
            <small id='emailHelp' class='form-text text-muted'>We'll never share your email with anyone else.</small>
          </div>
          <div class='form-group'>
            <label for='pass'>Password</label>
            <input type='password' class='form-control' id='pass' placeholder='Password' v-model='password'>
          </div>
          <button type='submit' class='btn btn-primary'>Submit</button>
        </form>
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
        this.errors.push('Требуется указать email.')
      }
      if (!this.password) {
        this.errors.push('Требуется указать пароль.')
      }
    },
    proceedForm: function () {
      let data = {email: this.email, password: this.password}
      this.$http.post('http://192.168.0.15/~user16/rest/client/api/users/login', data)
        .then(response => {
          localStorage.setItem('user_id', response.body.id)
          this.$emit('setUser', response.body.id)
        })
        .catch(error => {
          this.message = error
        })
    }
  }
}
</script>
