<template>
  <div id="app">
    <the-header/>
    <the-slider/>
    <router-view/>
    <the-footer/>
  </div>
</template>

<script>
import TheHeader from '@/components/TheHeader'
import TheSlider from '@/components/TheSlider'
import TheFooter from '@/components/TheFooter'

export default {
  name: 'App',
  components: {
    TheHeader,
    TheSlider,
    TheFooter
  }
}
</script>

<style>
</style>
