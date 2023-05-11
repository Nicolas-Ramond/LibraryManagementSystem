import { BooksService, CommentsService } from '@/common/api.service'
import { FETCH_BOOK, FETCH_COMMENTS } from './actions.type'
import { SET_BOOK, SET_COMMENTS } from './mutations.type'

export const state = {
  book: {},
  comments: []
}

export const actions = {
  [FETCH_BOOK] (context, bookSlug) {
    return BooksService.get(bookSlug)
      .then(({ data }) => {
        context.commit(SET_BOOK, data.book)
      })
      .catch((error) => {
        throw new Error(error)
      })
  },
  [FETCH_COMMENTS] (context, bookSlug) {
    return CommentsService.get(bookSlug)
      .then(({ data }) => {
        context.commit(SET_COMMENTS, data.comments)
      })
      .catch((error) => {
        throw new Error(error)
      })
  }
}

/* eslint no-param-reassign: ["error", { "props": false }] */
export const mutations = {
  [SET_BOOK] (state, book) {
    state.book = book
  },
  [SET_COMMENTS] (state, comments) {
    state.comments = comments
  }
}

export default {
  state,
  actions,
  mutations
}
