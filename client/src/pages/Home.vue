<template>
  <div class='container'>
    <div class='row'>
      <div class='col-sm-3 d-flex justify-content-start'>
        <ul class='list-group' style='text-align:left;'>
          <li class='list-group-item'>
            <p>Authors</p>
            <div class='form-check' v-for='author in authors' v-bind:key='author.id'>
              <input class='form-check-input' type='checkbox' value='author.id' id='author.id' @click='filterByAuthor'>
              <label class='form-check-label' for='author.id'>
                {{author.id}}{{author.name}}
              </label>
            </div>
          </li>
          <li class='list-group-item'>
            <p>Genres</p>
            <div class='form-check' v-for='genre in genres' v-bind:key='genre.id'>
              <input class='form-check-input' type='checkbox' value='genre.name' id='genre.name'>
              <label class='form-check-label' for='genre.name'>
                {{genre.name}}
              </label>
            </div>
          </li>
          <!-- <li class='list-group-item'>
            <div class='input-group mb-3'>
              <input type='text' class='form-control' placeholder='Model search' v-model='searchModel' v-on:keyup.prevent='filterByModel'>
            </div>
          </li>
          <li class='list-group-item'>
            <div class='input-group-append'>
              <button class='btn btn-outline-secondary' type='button' v-on:click='resetFilter'>Reset</button>
            </div>
          </li> -->
        </ul>
      </div>
      <div class='col-sm-9'>
        <div class='row' style='padding-top: 10px'>
          <div class='col-sm-4' v-for='book in books' v-bind:key='book.id'>
            <router-link :to='`/${book.id}`'>
              <div class='card'>
                <!-- <img class='card-img-top img-fluid' v-bind:src='author.images' alt='Card image cap'> -->
                <div class='card-body'>
                  <h5 class='card-title' style='color: grey'>{{book.name}}</h5>
                  <p class='card-text'>
                      <b>{{book.description}}</b>
                  </p>
                  <p class='card-text' style='color: tomato'>
                      <b>${{book.price}}</b>
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
      authors: [],
      genres: [],
      books: []
    }
  },
  created () {
    this.fetchAuthors()
    this.fetchGenres()
    this.fetchBooks()
  },
  computed: {
    // filteredByBrandCars () {
    //   return this.cars.filter(car => {
    //     return car.tm.toLowerCase().includes(this.searchBrand.toLowerCase())
    //   })
    // },
    // filteredByModelCars () {
    //   return this.cars.filter(car => {
    //     return car.model.toLowerCase().includes(this.searchModel.toLowerCase())
    //   })
    // }
  },
  methods: {
    fetchAuthors: function () {
      fetch('http://book-shop/server/api/authors/')
      // fetch('http://192.168.0.15/~user16/book-shop/client/api/authors/')
        .then(response => {
          if (response.ok) {
            return response.json()
          }
          throw new Error('Network response was not ok')
        })
        .then(json => {
          let data = json['data']
          let authors = []
          Object.keys(data).forEach(function (key) { 
            let item = data[key]
            authors.push({
              id: item.id,
              name: item.name
            })
          })
          return authors
        })
        .then(authors => {
          this.authors = authors
        })
        .catch(error => {
          console.log(error)
        })
    },
    fetchGenres: function () {
      fetch('http://book-shop/server/api/genres/')
      // fetch('http://192.168.0.15/~user16/book-shop/client/api/authors/')
        .then(response => {
          if (response.ok) {
            return response.json()
          }
          throw new Error('Network response was not ok')
        })
        .then(json => {
          let data = json['data']
          let genres = []
          Object.keys(data).forEach(function (key) { 
            let item = data[key]
            genres.push({
              id: item.id,
              name: item.name
            })
          })
          return genres
        })
        .then(genres => {
          this.genres = genres
        })
        .catch(error => {
          console.log(error)
        })
    },
    fetchBooks: function () {
      fetch('http://book-shop/server/api/books/')
      // fetch('http://192.168.0.15/~user16/book-shop/client/api/authors/')
        .then(response => {
          if (response.ok) {
            return response.json()
          }
          throw new Error('Network response was not ok')
        })
        .then(json => {
          let data = json['data']
          let books = []
          Object.keys(data).forEach(function (key) { 
            let item = data[key]
            books.push({
              id: item.id,
              name: item.name,
              description: item.description,
              price: item.price,
              authors: item.authors,
              genres: item.genres,
              discount: item.discount
            })
          })
          return books
        })
        .then(books => {
          this.books = books
        })
        .catch(error => {
          console.log(error)
        })
    },
    filterByAuthor: function () {

    },
    // filterByBrand: function () {
    //   if (this.searchBrand !== '') {
    //     this.cars = this.filteredByBrandCars
    //   } else {
    //     this.cars = this.fullCarsArray
    //   }
    // },
    // filterByModel: function () {
    //   if (this.searchModel !== '') {
    //     this.cars = this.filteredByModelCars
    //   } else {
    //     this.cars = this.fullCarsArray
    //   }
    // },
    // resetFilter: function () {
    //   this.searchBrand = ''
    //   this.searchModel = ''
    //   this.filterByBrand()
    // }
  }
}
</script>
