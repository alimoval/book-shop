<template>
  <div class='container'>
    <div class='row'>
      <div class='col-sm-3 d-flex justify-content-start'>
        <ul class="list-group">
          <li class="list-group-item">
            <div class='input-group mb-3'>
              <input type='text' class='form-control' placeholder='Brand search' v-model='searchBrand' v-on:keyup.prevent='filterByBrand'>
            </div>
          </li>
          <li class="list-group-item">
            <div class='input-group mb-3'>
              <input type='text' class='form-control' placeholder='Model search' v-model='searchModel' v-on:keyup.prevent='filterByModel'>
            </div>
          </li>
          <li class="list-group-item">
            <div class='input-group-append'>
              <button class='btn btn-outline-secondary' type='button' v-on:click='resetFilter'>Reset</button>
            </div>
          </li>
        </ul>
      </div>
      <div class="col-sm-9">
        <div class='row' style='padding-top: 10px'>
          <div class='col-sm-4' v-for='car in cars' v-bind:key='car.id'>
            <router-link :to='`/${car.id}`'>
              <div class='card'>
                <img class='card-img-top img-fluid' v-bind:src='car.images' alt='Card image cap'>
                <div class='card-body'>
                  <h5 class='card-title' style='color: grey'>{{car.tm}} {{car.model}}</h5>
                  <p class='card-text' style='color: tomato'>
                      <b>{{car.price}}</b>
                  </p>
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'home',
  props: ['userID'],
  data: function () {
    return {
      searchBrand: '',
      searchModel: '',
      cars: [],
      fullCarsArray: []
    }
  },
  created () {
    this.fetchCars()
  },
  computed: {
    filteredByBrandCars () {
      return this.cars.filter(car => {
        return car.tm.toLowerCase().includes(this.searchBrand.toLowerCase())
      })
    },
    filteredByModelCars () {
      return this.cars.filter(car => {
        return car.model.toLowerCase().includes(this.searchModel.toLowerCase())
      })
    }
  },
  methods: {
    fetchCars: function () {
      fetch('http://rest/server/api/cars/')
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
              images: item.images
            })
          })
        })
        .catch(error => {
          console.log(error)
        })
      this.fullCarsArray = this.cars
    },
    filterByBrand: function () {
      if (this.searchBrand !== '') {
        this.cars = this.filteredByBrandCars
      } else {
        this.cars = this.fullCarsArray
      }
    },
    filterByModel: function () {
      if (this.searchModel !== '') {
        this.cars = this.filteredByModelCars
      } else {
        this.cars = this.fullCarsArray
      }
    },
    resetFilter: function () {
      this.searchBrand = ''
      this.searchModel = ''
      this.filterByBrand()
    }
  }
}
</script>
