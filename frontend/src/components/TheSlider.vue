<template>
  <div id="tg-homeslider" class="tg-homeslider tg-haslayout owl-carousel">
    <slide/>
    <slide/>
    <slide/>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'

import Slide from '@/components/slider/Slide'

export default {
  name: 'TheSlider',
  components: {
    Slide
  },
  computed: {
    ...mapGetters([
      'currentUser',
      'isAuthenticated'
    ])
  }
}
</script>
