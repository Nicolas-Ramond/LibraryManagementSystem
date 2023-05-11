<template>
  <div class="profile-page">
    <RwvBookList
      :favorited="favorited"
      :items-per-page="5">
    </RwvBookList>
  </div>
</template>
<script>
  import RwvBookList from '@/components/BookList'

  export default {
    name: 'RwvProfileFavorited',
    components: {
      RwvBookList
    },
    computed: {
      favorited () {
        return this.$route.params.username
      }
    }
  }
</script>
