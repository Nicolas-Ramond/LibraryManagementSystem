import {
  AuthorsService,
  BooksService
} from '@/common/api.service'
import {
  FETCH_BOOKS,
  FETCH_AUTHORS
} from './actions.type'
import {
  FETCH_START,
  FETCH_END,
  SET_AUTHORS,
  UPDATE_BOOK_IN_LIST
} from './mutations.type'

const state = {
  authors: [],
  books: [],
  isLoading: true,
  booksCount: 0
}

const getters = {
  booksCount (state) {
    return state.booksCount
  },
  books (state) {
    return state.books
  },
  isLoading (state) {
    return state.isLoading
  },
  authors (state) {
    return state.authors
  }
}

const actions = {
  [FETCH_BOOKS] ({ commit }, params) {
    commit(FETCH_START)
    return BooksService.query(params.type, params.filters)
      .then(({ data }) => {
        commit(FETCH_END, data)
      })
      .catch((error) => {
        throw new Error(error)
      })
  },
  [FETCH_AUTHORS] ({ commit }) {
    return AuthorsService.get()
      .then(({ data }) => {
        commit(SET_AUTHORS, data.authors)
      })
      .catch((error) => {
        throw new Error(error)
      })
  }
}

/* eslint no-param-reassign: ["error", { "props": false }] */
const mutations = {
  [FETCH_START] (state) {
    state.isLoading = true
  },
  [FETCH_END] (state, { books, booksCount }) {
    state.books = books
    state.booksCount = booksCount
    state.isLoading = false
  },
  [SET_AUTHORS] (state, authors) {
    state.authors = authors
  },
  [UPDATE_BOOK_IN_LIST] (state, data) {
    state.books = state.books.map((book) => {
      if (book.slug !== data.slug) { return book }
      // We could just return data, but it seems dangerous to
      // mix the results of different api calls, so we
      // protect ourselves by copying the information.
      book.favorited = data.favorited
      book.favoritesCount = data.favoritesCount
      return book
    })
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
