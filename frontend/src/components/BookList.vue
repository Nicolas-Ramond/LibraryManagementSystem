<template>
  <div>
    <div v-if="isLoading" class="book-preview">
      Loading books...
    </div>
    <div v-else>
      <div v-if="books.length === 0" class="book-preview">
        No books are here... yet.
      </div>
      <rwv-book-preview
        v-for="(book, index) in books"
        :book="book"
        :key="book.title + index">
      </rwv-book-preview>
      <v-pagination
        :pages="pages"
        :currentPage.sync="currentPage"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import RwvAuthor from '@/components/VAuthor'
  import RwvBookPreview from '@/components/VBookPreview'
  import VPagination from '@/components/VPagination'
  import { FETCH_BOOKS } from '@/store/actions.type'

  export default {
    name: 'rwv-book-list',
    components: {
      RwvAuthor,
      RwvBookPreview,
      VPagination
    },
    props: {
      type: {
        type: String,
        required: false,
        default: 'all'
      },
      author: {
        type: String,
        required: false
      },
      favorited: {
        type: String,
        required: false
      },
      itemsPerPage: {
        type: Number,
        required: false,
        default: 10
      }
    },
    data () {
      return {
        currentPage: 1
      }
    },
    computed: {
      listConfig () {
        const { type } = this
        const filters = {
          offset: (this.currentPage - 1) * this.itemsPerPage,
          limit: this.itemsPerPage
        }
        if (this.author) {
          filters.author = this.author
        }
        if (this.author) {
          filters.author = this.author
        }
        if (this.favorited) {
          filters.favorited = this.favorited
        }
        return {
          type,
          filters
        }
      },
      pages () {
        if (this.isLoading || this.booksCount <= this.itemsPerPage) {
          return []
        }
        return [...Array(Math.ceil(this.booksCount / this.itemsPerPage)).keys()].map(e => e + 1)
      },
      ...mapGetters([
        'booksCount',
        'isLoading',
        'books'
      ])
    },
    watch: {
      currentPage (newValue) {
        this.listConfig.filters.offset = (newValue - 1) * this.itemsPerPage
        this.fetchBooks()
      },
      type () {
        this.resetPagination()
        this.fetchBooks()
      },
      author () {
        this.resetPagination()
        this.fetchBooks()
      },
      favorited () {
        this.resetPagination()
        this.fetchBooks()
      }
    },
    mounted () {
      this.fetchBooks()
    },
    methods: {
      fetchBooks () {
        this.$store.dispatch(FETCH_BOOKS, this.listConfig)
      },
      resetPagination () {
        this.listConfig.offset = 0
        this.currentPage = 1
      }
    }
  }
</script>
