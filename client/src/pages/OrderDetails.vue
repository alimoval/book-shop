<template>
  <div class="container">
        <div class="row top-buffer" v-for="order in orders" v-bind:key='order.id'>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8" style="text-align:left;">
              <h4 style="color: grey;">{{order.name}} bought {{order.car}}</h4>
              <p>date: <b>{{order.date}}</b></p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: "orderDetails",
  data() {
    return {
      orders: [],
      message: null
    };
  },
  created() {
    this.fetchOrder(this.$route.params.id);
  },
  methods: {
    fetchOrder: function(id) {
      fetch("http://rest/server/api/orders/" + id)
        .then(response => {
          if (response.ok) {
            return response.json();
          }
          throw new Error("Network response was not ok");
        })
        .then(json => {
            this.orders.push({
              id: json.id,
              car: json.car,
              name: json.name,
              date: json.date
            })
        })
        .catch(error => {
          this.message = error
        })
    }
  }
}
</script>