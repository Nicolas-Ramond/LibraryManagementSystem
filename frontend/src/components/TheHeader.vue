<template>
  <header id="tg-header" class="tg-header tg-haslayout">
    <the-top-bar/>
    <the-middle-container/>
    <the-navigation-area/>
  </header>
</template>

<script>
import {mapGetters} from 'vuex'

import TheTopBar from '@/components/header/TheTopBar'
import TheMiddleContainer from '@/components/header/TheMiddleContainer'
import TheNavigationArea from '@/components/header/TheNavigationArea'

export default {
  name: 'TheHeader',
  components: {
    TheTopBar,
    TheMiddleContainer,
    TheNavigationArea
  },
  computed: {
    ...mapGetters([
      'currentUser',
      'isAuthenticated'
    ])
  }
}
</script>
