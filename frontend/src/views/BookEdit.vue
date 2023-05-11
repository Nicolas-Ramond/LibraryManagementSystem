<template>
  <div class="editor-page">
    <div class="container page">
      <div class="row">
        <div class="col-md-10 offset-md-1 col-xs-12">
          <RwvListErrors :errors="errors"/>
          <form v-on:submit.prevent="onPublish(book.slug, book)">
            <fieldset :disabled="inProgress">
              <fieldset class="form-group">
                <input
                  type="text"
                  class="form-control form-control-lg"
                  v-model="book.title"
                  placeholder="Book Title">
              </fieldset>
              <fieldset class="form-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="book.description"
                  placeholder="What's this book about?">
              </fieldset>
              <fieldset class="form-group">
                <textarea
                  class="form-control"
                  rows="8"
                  v-model="book.body"
                  placeholder="Write your book (in markdown)">
                </textarea>
              </fieldset>
              <fieldset class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter tags"
                  v-model="tagInput"
                  v-on:keypress.enter.prevent="addTag(tagInput)">
                <div class="tag-list">
                  <span
                    class="tag-default tag-pill"
                    v-for="(tag, index) of book.tagList"
                    :key="tag + index">
                  <i
                    class="ion-close-round"
                    v-on:click="removeTag(tag)">
                </i>
                {{ tag }}
              </span>
                </div>
              </fieldset>
            </fieldset>
            <button
              :disabled="inProgress"
              class="btn btn-lg pull-xs-right btn-primary"
              type="submit">
              Publish Book
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { mapGetters } from 'vuex'
  import store from '@/store'
  import RwvListErrors from '@/components/ListErrors'
  import {
    BOOK_PUBLISH,
    BOOK_EDIT,
    FETCH_BOOK,
    BOOK_EDIT_ADD_TAG,
    BOOK_EDIT_REMOVE_TAG,
    BOOK_RESET_STATE
  } from '@/store/actions.type'

  export default {
    name: 'RwvBookEdit',
    components: { RwvListErrors },
    props: {
      previousBook: {
        type: Object,
        required: false
      }
    },
    async beforeRouteUpdate (to, from, next) {
      // Reset state if user goes from /editor/:id to /editor
      // The component is not recreated so we use to hook to reset the state.
      await store.dispatch(BOOK_RESET_STATE)
      return next()
    },
    async beforeRouteEnter (to, from, next) {
      // SO: https://github.com/vuejs/vue-router/issues/1034
      // If we arrive directly to this url, we need to fetch the book
      await store.dispatch(BOOK_RESET_STATE)
      if (to.params.slug !== undefined) {
        await store.dispatch(FETCH_BOOK,
          to.params.slug,
          to.params.previousBook
        )
      }
      return next()
    },
    async beforeRouteLeave (to, from, next) {
      await store.dispatch(BOOK_RESET_STATE)
      next()
    },
    data () {
      return {
        tagInput: null,
        inProgress: false,
        errors: {}
      }
    },
    computed: {
      ...mapGetters([
        'book'
      ])
    },
    methods: {
      onPublish (slug, book) {
        let action = slug ? BOOK_EDIT : BOOK_PUBLISH
        this.inProgress = true
        this.$store
          .dispatch(action)
          .then(({ data }) => {
            this.inProgress = false
            this.$router.push({
              name: 'book',
              params: { slug: data.book.slug }
            })
          })
          .catch(({ response }) => {
            this.inProgress = false
            this.errors = response.data.errors
          })
      },
      removeTag (tag) {
        this.$store.dispatch(BOOK_EDIT_REMOVE_TAG, tag)
      },
      addTag (tag) {
        this.$store.dispatch(BOOK_EDIT_ADD_TAG, tag)
        this.tagInput = null
      }
    }
  }
</script>
