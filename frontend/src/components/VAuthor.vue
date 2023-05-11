<template>
  <router-link :to="{ name: 'home-author', params: { author: name } }" :class="className">
    {{ name }}
  </router-link>
</template>
<script>
  export default {
    name: 'RwvAuthor',
    props: {
      name: {
        type: String,
        required: true
      },
      className: {
        type: String,
        default: 'author-pill author-default'
      }
    }
  }
</script>
