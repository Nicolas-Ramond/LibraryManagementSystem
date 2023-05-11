<template>
  <!-- Used when user is also author -->
  <span v-if="canModify">
    <router-link
      class="btn btn-sm btn-outline-secondary"
      :to="{ name: 'book-edit', params: { slug: this.book.slug } }">
      <i class="ion-edit"></i>&nbsp;Edit Book
    </router-link>
    &nbsp;&nbsp;
    <button
      class="btn btn-outline-danger btn-sm"
      v-on:click="deleteBook(book.slug)">
      <i class="ion-trash-a"></i>&nbsp;Delete Book
    </button>
  </span>
  <!-- Used in BookView when not author -->
  <span v-else>
    <button
      class="btn btn-sm btn-outline-secondary"
      v-on:click="toggleFollow(profile.following)">
      <i class="ion-plus-round"></i>
      &nbsp;
      {{ profile.following ? 'Unfollow' : 'Follow' }} {{book.author.username}}
    </button>
    &nbsp;&nbsp;
    <button
      class="btn btn-sm"
      v-on:click="toggleFavorite(book.slug)"
      :class="{
        'btn-primary': book.favorited,
        'btn-outline-primary': !book.favorited
      }">
      <i class="ion-heart"></i>&nbsp;
      {{
        book.favorited
        ? 'Unfavorite Book'
        : 'Favorite Book'
      }}
      <span class="counter">
        ({{book.favoritesCount}})
      </span>
    </button>
  </span>
</template>

<script>
import { mapGetters } from 'vuex'
import { FAVORITE_ADD, FAVORITE_REMOVE, BOOK_DELETE, FETCH_PROFILE_FOLLOW, FETCH_PROFILE_UNFOLLOW } from '@/store/actions.type'

export default {
  name: 'RwvBookActions',
  props: {
    book: { type: Object, required: true },
    canModify: { type: Boolean, required: true }
  },
  computed: {
    ...mapGetters([
      'profile',
      'isAuthenticated'
    ])
  },
  methods: {
    toggleFavorite (slug) {
      if (!this.isAuthenticated) {
        this.$router.push({name: 'login'})
        return
      }
      const action = this.book.favorited
        ? FAVORITE_REMOVE
        : FAVORITE_ADD
      this.$store.dispatch(action, slug)
    },
    toggleFollow (following) {
      if (!this.isAuthenticated) {
        this.$router.push({name: 'login'})
        return
      }
      const action = following ? FETCH_PROFILE_UNFOLLOW : FETCH_PROFILE_FOLLOW
      this.$store.dispatch(action, {
        username: this.profile.username
      })
    },
    editBook (slug, book) {
      this.$router.push({
        name: 'book-edit',
        params: { slug, previousBook: book }
      })
    },
    deleteBook (slug) {
      this.$store
        .dispatch(BOOK_DELETE, slug)
        .then((res) => {
          this.$router.push('/')
        })
    }
  }
}
</script>
