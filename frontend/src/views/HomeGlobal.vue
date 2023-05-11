<template>
  <div class="home-global">
    <RwvBookList type="all" />
  </div>
</template>
<script>
  import RwvBookList from '@/components/BookList'

  export default {
    name: 'rwv-home-global',
    components: {
      RwvBookList
    }
  }
</script>
