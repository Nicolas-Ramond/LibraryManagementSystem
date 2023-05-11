<template>
  <div class="book-preview">
    <rwv-book-meta
      :book="book"
      :isPreview="true">
    </rwv-book-meta>
    <router-link
      :to="{name: 'book', params: {'slug': book.slug}}"
      class="preview-link">
      <h1>{{book.title}}</h1>
      <p>{{book.description}}</p>
      <span>Read more...</span>
      <ul class="tag-list">
        <li class="tag-default tag-pill tag-outline"
         v-for="(tag, index) of book.tagList"
         :key="tag + index">
         {{ tag }}
        </li>
      </ul>
    </router-link>
  </div>
</template>

<script>
import RwvBookMeta from '@/components/BookMeta'

export default {
  name: 'RwvBookPreview',
  props: {
    book: { type: Object, required: true }
  },
  components: {
    RwvBookMeta
  }
}
</script>
