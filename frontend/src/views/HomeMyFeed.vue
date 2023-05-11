<template>
  <div class="home-my-feed">
    <RwvBookList type="feed" />
  </div>
</template>
<script>
  import RwvBookList from '@/components/BookList'

  export default {
    name: 'rwv-home-my-feed',
    components: {
      RwvBookList
    }
  }
</script>
