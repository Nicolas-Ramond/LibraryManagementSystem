<template>
  <div class="home-author">
    <RwvBookList :author="author"></RwvBookList>
  </div>
</template>
<script>
  import RwvBookList from '@/components/BookList'

  export default {
    name: 'RwvHomeAuthor',
    components: {
      RwvBookList
    },
    computed: {
      author () {
        return this.$route.params.author
      }
    }
  }
</script>
