<template>
  <div class='container'>
    {{message}}
  </div>
</template>

<script>
export default {
  name: 'carDetails',
  props: ['userID'],
  data () {
    return {
      message: 'Thank You User ' + this.userID + ' for order!'
    }
  },
  created () {
    // setTimeout(function(){
    //   this.$router.push('/')
    //   }, 5000)
  },
  methods: { }
}
</script>
