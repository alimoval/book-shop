<template>
  <div class='container'>
        <div class='row top-buffer' v-for='car in cars' v-bind:key='car.id'>
            <div class='col-sm-4'>
              <img class='img-fluid' v-bind:src='car.images' alt='Card image cap'>
            </div>
            <div class='col-sm-8' style='text-align:left;'>
              <h4 style='color: grey;'>{{car.tm}} {{car.model}}</h4>
              <p>
                    year: <b>{{car.year}}</b>
                </p>
                <p>
                    odometr: <b>{{car.odo}}</b> km
                </p>
              <p>
                    color: <b>{{car.color}}</b>
                </p>
              <p>
                    engine type: <b>{{car.gas}}</b>
                </p>
              <p>
                    engine amount: <b>{{car.engine}}</b>
                </p>
              <p>
                    town: <b>{{car.town}}</b>
                </p>
                <p style='color: tomato;'>
                  Price: <b>${{car.price}}</b>
              </p>
              <form method="post" v-if="userID"  v-on:submit.stop.prevent='buyCar'>
                <input type='submit' value='Buy'>
              </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'carDetails',
  props: ['userID'],
  data () {
    return {
      cars: [],
      message: null
    }
  },
  created () {
    this.fetchCar(this.$route.params.id)
  },
  methods: {
    buyCar: function () {
      let date = new Date()
      let data = {user_id: this.userID, car_id: this.$route.params.id, date: date.toLocaleString('ru')}
      this.$http.post('http://rest/server/api/orders/', data)
        .then(response => {
          this.msg = 'Order Registered'
        })
        .catch(error => {
          this.message = error
        })
      this.$router.push('/thank-you')
    },
    fetchCar: function (id) {
      fetch('http://rest/server/api/cars/' + id)
        .then(response => {
          if (response.ok) {
            return response.json()
          }
          throw new Error('Network response was not ok')
        })
        .then(json => {
          json['data'].forEach(item => {
            this.cars.push({
              id: item.id,
              model: item.model,
              tm: item.tm,
              price: item.price,
              color: item.color,
              year: item.year,
              gas: item.gas,
              odo: item.odo,
              engine: item.engine,
              town: item.town,
              images: item.images
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
