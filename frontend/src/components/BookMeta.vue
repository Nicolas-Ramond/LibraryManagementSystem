<template>
  <div class="book-meta">
    <router-link
      :to="{ name: 'profile', params: { 'username': book.author.username } }">
      <img :src="book.author.image"/>
    </router-link>
    <div class="info">
      <router-link
        :to="{ name: 'profile', params: { 'username': book.author.username } }"
        class="author">
        {{ book.author.username }}
      </router-link>
      <span class="date">{{ book.createdAt | date }}</span>
    </div>
    <template v-if="actions">
      <rwv-book-actions
      :book="book"
      :canModify="isCurrentUser()"
      ></rwv-book-actions>
    </template>
    <template v-else>
      <button
      class="btn btn-sm pull-xs-right"
      v-if="!actions"
      v-on:click="toggleFavorite"
      :class="{
        'btn-primary': book.favorited,
        'btn-outline-primary': !book.favorited
        }">
        <i class="ion-heart"></i>
        <span class="counter">
          {{ book.favoritesCount }}
        </span>
      </button>
    </template>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import RwvBookActions from '@/components/BookActions'
  import { FAVORITE_ADD, FAVORITE_REMOVE } from '@/store/actions.type'

  export default {
    name: 'RwvBookMeta',
    components: {
      RwvBookActions
    },
    props: {
      book: {
        type: Object,
        required: true
      },
      actions: {
        type: Boolean,
        required: false,
        default: false
      }
    },
    computed: {
      ...mapGetters([
        'currentUser',
        'isAuthenticated'
      ])
    },
    methods: {
      isCurrentUser () {
        if (this.currentUser.username && this.book.author.username) {
          return this.currentUser.username === this.book.author.username
        }
        return false
      },
      toggleFavorite () {
        if (!this.isAuthenticated) {
          this.$router.push({name: 'login'})
          return
        }
        const action = this.book.favorited
          ? FAVORITE_REMOVE
          : FAVORITE_ADD
        this.$store.dispatch(action, this.book.slug)
      }
    }
  }
</script>
