<template>
  <div class='container'>
    <div class='row'>
      <div class='col-12 col-md-3 justify-content-start'>
        <div class="row">
          <div class="col-6 col-md-12" style='text-align:left; margin-bottom: 30px'>
            <p>Authors</p>
            <div class='form-check' v-for='author in authors' v-bind:key='author.id'>
              <input class='form-check-input' type='checkbox' v-bind:value='author.id' @click='addAuthorToFilterArray'>
              <label class='form-check-label' style='font-size:14px'>
                {{author.name}}
              </label>
            </div>
          </div>
          <div class=" col-6 col-md-12" style='text-align:left; margin-bottom: 30px'>
            <p>Genres</p>
            <div class='form-check' v-for='genre in genres' v-bind:key='genre.id'>
              <input class='form-check-input' type='checkbox' v-bind:value='genre.id' @click='addGenreToFilterArray'>
              <label class='form-check-label' style='font-size:14px'>
                {{genre.name}}
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class='col-12 col-md-9'>
        <div class='row'>
          <div class='col-12 col-sm-6 col-md-4 col-lg-3' v-for='book in books' v-bind:key='book.id'  style='padding-bottom: 20px;'>
            <router-link :to='`/${book.id}`' onmouseover='this.style="text-decoration: none;"'>
              <div class='card' style='min-height: 300px;'>
                <img class='card-img-top img-fluid' src='http://softcatalog.info/sites/default/files/styles/program_logo/public/program/logo/ice_book_reader_professional_.png' alt='Book image' style='max-height:200px'>
                <div class='card-body' style='padding: 5px;'>
                  <h6 class='card-title' style='color: #007bff'>{{book.name}}</h6>
                  <div v-for='author in book.authors' v-bind:key='author.id' style="color:black; font-size:14px; line-height:1em">
                    {{author}}
                  </div>
                  <p class='card-text bottom' style='color:tomato; position: absolute; bottom: 5px; left: 43%'>
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
      query: '',
      authors: [],
      genres: [],
      books: [],
      authorsInFilter: [],
      genresInFilter: []
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
    fetchBooks: function (query) {
      this.query = ''
      fetch('http://book-shop/server/api/books/' + query)
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
    addAuthorToFilterArray: function (e) {
      let value = e.target.value
      if (this.authorsInFilter.indexOf(value) >= 0) {
        this.authorsInFilter.splice(this.authorsInFilter.indexOf(value), 1)
        if (this.query === '?') {
          this.query = ''
        }
      } else {
        this.authorsInFilter.push(value)
      }
      this.buildQuery()
    },
    buildQuery: function () {
      this.authorsInFilter.forEach((item, i) => {
        if (i === 0 && this.query.indexOf('?') < 0) {
          this.query += '?authors[]=' + item
        } else {
          this.query += '&authors[]=' + item
        }
      })
      this.genresInFilter.forEach((item, i) => {
        if (i === 0 && this.query.indexOf('?') < 0) {
          this.query += '?genres[]=' + item
        } else {
          this.query += '&genres[]=' + item
        }
      })
      this.fetchBooks(this.query)
    },
    addGenreToFilterArray: function (e) {
      let value = e.target.value
      if (this.genresInFilter.indexOf(value) >= 0) {
        this.genresInFilter.splice(this.genresInFilter.indexOf(value), 1)
        if (this.query === '?') {
          this.query = ''
        }
      } else {
        this.genresInFilter.push(value)
      }
      this.buildQuery()
    },
    resetFilter: function () {
      this.query = ''
      this.fetchBooks()
    }
  }
}
</script>
