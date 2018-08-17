<template>
  <div class="container">
        <div class="row top-buffer">
            <div class="col-sm-3" v-for="car in cars" v-bind:key='car.id'>
                <router-link :to="`/${car.id}`">
                    <div class="card">
                        <img class="card-img-top" v-bind:src="car.images" alt="Card image cap" style="max-height: 170px;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: grey;">{{car.tm}} {{car.model}}</h5>
                            <p class="card-text" style="color: tomato;">
                                <b>{{car.price}}</b>
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
  name: "home",
  data() {
    return {
      cars: [],
      msg: "Welcome to Your Vue.js App"
    };
  },
  created() {
    this.fetchCars();
  },
  methods: {
    fetchCars: function() {
      fetch("http://rest/server/api/cars/")
        .then(response => {
          if (response.ok) {
            return response.json();
          }
          throw new Error("Network response was not ok");
        })
        .then(json => {
          json["data"].forEach(item => {
            this.cars.push({
              id: item.id,
              model: item.model,
              tm: item.tm,
              price: item.price,
              images: item.images
            });
          });
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>