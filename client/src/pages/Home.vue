<template>
  <div class='container'>
    <div class='row'>
      <div class='col-sm-3 d-flex justify-content-start'>
        <ul class='list-group' style='text-align:left;'>
          <li class='list-group-item'>
            <p>Authors</p>
            <div class='form-check' v-for='author in authors' v-bind:key='author.id'>
              <input class='form-check-input' type='checkbox' value='author.id' @click='filterByAuthor'>
              <label class='form-check-label'>
                {{author.name}}
              </label>
            </div>
          </li>
          <li class='list-group-item'>
            <p>Genres</p>
            <div class='form-check' v-for='genre in genres' v-bind:key='genre.id'>
              <input class='form-check-input' type='checkbox' value='genre.name'>
              <label class='form-check-label'>
                {{genre.name}}
              </label>
            </div>
          </li>
        </ul>
      </div>
      <div class='col-sm-9'>
        <div class='row'>
          <div class='col-sm-4' v-for='book in books' v-bind:key='book.id'  style='padding-bottom: 20px'>
            <router-link :to='`/${book.id}`' onmouseover='this.style="text-decoration: none;"'>
              <div class='card' style='min-height: 200px'>
                <!-- <img class='card-img-top img-fluid' v-bind:src='author.images' alt='Card image cap'> -->
                <div class='card-body'>
                  <h5 class='card-title' style='color: #007bff'>{{book.name}}</h5>
                  <p v-for='author in book.authors' v-bind:key='author.id' style="color:black; font-size:14px; line-height:0.9em">
                    {{author}}
                  </p>
                  <p class='card-text bottom' style='color: tomato'>
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
