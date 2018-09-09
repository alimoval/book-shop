<template>
  <div class='container'>
        <div class='row top-buffer' v-for='order in orders' v-bind:key='order.id'>
            <div class='col-sm-4'>
            </div>
            <div class='col-sm-8' style='text-align:left;'>
              <h4 style='color: grey;'>{{order.name}} bought {{order.book}}</h4>
              <p>date: <b>{{order.date}}</b></p>
              <p>price: <b>${{order.price}}</b></p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'orderDetails',
  props: ['userID'],
  data () {
    return {
      orders: [],
      message: null
    }
  },
  created () {
    this.fetchOrder(this.$route.params.id)
  },
  methods: {
    fetchOrder: function (id) {
      fetch('http://book-shop/server/api/orders/' + id)
      // fetch('http://192.168.0.15/~user16/rest/client/api/orders/' + id)
        .then(response => {
          if (response.ok) {
            return response.json()
          }
          throw new Error('Network response was not ok')
        })
        .then(json => {
          console.log(json)
          json['data'].forEach(item => {
            this.orders.push({
              id: item.id,
              book: item.book_name,
              name: item.user_name,
              date: item.date,
              price: item.price
            })
          })
        })
        .catch(error => {
          this.message = error
        })
    }
  }
}
</script>
