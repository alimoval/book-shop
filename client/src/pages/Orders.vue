<template>
  <div class='container'>
        <div class='row' style='padding-top: 20px'>
            <div class='col-sm-4' v-for='order in orders' v-bind:key='order.id'>
                <router-link :to='`/orders/${order.id}`'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title' style='color: grey'>{{order.name}} {{order.car}}</h5>
                            <p class='card-text' style='color: tomato'>
                                <b>{{order.date}}</b>
                            </p>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'orders',
  props: ['userID'],
  data: function () {
    return {
      orders: []
    }
  },
  created () {
    this.fetchOrders(this.userID)
  },
  methods: {
    fetchOrders: function (userID) {
      fetch('http://rest/server/api/orders/?userID=' + userID)
        .then(response => {
          if (response.ok) {
            return response.json()
          }
          throw new Error('Network response was not ok')
        })
        .then(json => {
          json['data'].forEach(item => {
            this.orders.push({
              id: item.id,
              model: item.model,
              name: item.name,
              date: item.date
            })
          })
        })
        .catch(error => {
          console.log(error)
        })
    }
  }
}
</script>
