<template>
  <div class="profile-page">
    <RwvBookList :author="author" :items-per-page="5"></RwvBookList>
  </div>
</template>
<script>
  import RwvBookList from '@/components/BookList'

  export default {
    name: 'RwvProfileBooks',
    components: {
      RwvBookList
    },
    computed: {
      author () {
        return this.$route.params.username
      }
    }
  }
</script>
