<template>
  <div class='container'>
        <div class='row top-buffer' v-for='book in books' v-bind:key='book.id'>
            <div class='col-sm-3'>
              <!-- <img class='img-fluid' v-bind:src='book.images' alt='Card image cap'> -->
            </div>
            <div class='col-sm-9' style='text-align:left;'>
              <h3 style="font-weight:bold">{{book.name}}</h3>
              <p>
                    Authors: 
                    <span v-for='author in bookAuthors' v-bind:key='author.id'>{{author}}, </span>
                </p>
                <p>
                    Genres:
                    <span v-for='genre in bookGenres' v-bind:key='genre.id'>{{genre}}, </span>
                </p>
              <p>
                    Description: {{book.description}}
                </p>
              <p>
                    Discount: {{book.discount || 0}} %
                </p>
                <p style='color: tomato;'>
                  Price: <b>${{book.price}}</b>
              </p>
              <form method='post' v-if='userID'  v-on:submit.stop.prevent='buyBook'>
                <input type='submit' value='Add to Cart'>
              </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'bookDetails',
  props: ['userID'],
  data () {
    return {
      books: [],
      message: null
    }
  },
  created () {
    this.fetchBook(this.$route.params.id)
  },
  computed: {
    bookAuthors () {
      return this.books[0].authors
    },
    bookGenres () {
      return this.books[0].genres
    },
    bookPrice () {
      return this.books[0].price
    }
  },
  methods: {
    buyBook: function () {
      let date = new Date()
      let data = {user_id: this.userID, book_id: this.$route.params.id, date: date.toLocaleString('ru'), price: this.bookPrice}
      this.$http.post('http://book-shop/server/api/orders/', data)
      // this.$http.post('http://192.168.0.15/~user16/rest/client/api/orders/', data)
        .then(response => {
          this.msg = 'Order Registered'
        })
        .catch(error => {
          this.message = error
        })
      this.$router.push('/thank-you')
    },
    fetchBook: function (id) {
      // fetch('http://192.168.0.15/~user16/rest/client/api/cars/' + id)
      fetch('http://book-shop/server/api/books/' + id)
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
          this.message = error
        })
    }
  }
}
</script>
