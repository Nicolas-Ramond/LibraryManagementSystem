<template>
  <section class="tg-parallax tg-bgcollectioncount tg-haslayout" data-z-index="-100" data-appear-top-offset="600" data-parallax="scroll" data-image-src="static/images/parallax/bgparallax-04.jpg">
    <div class="tg-sectionspace tg-collectioncount tg-haslayout">
      <div class="container">
        <div class="row">
          <div id="tg-collectioncounters" class="tg-collectioncounters">
            <div class="tg-collectioncounter tg-drama">
              <div class="tg-collectioncountericon">
                <i class="icon-bubble"></i>
              </div>
              <div class="tg-titlepluscounter">
                <h2>Drama</h2>
                <h3 data-from="0" data-to="6179213" data-speed="8000" data-refresh-interval="50">6,179,213</h3>
              </div>
            </div>
            <div class="tg-collectioncounter tg-horror">
              <div class="tg-collectioncountericon">
                <i class="icon-heart-pulse"></i>
              </div>
              <div class="tg-titlepluscounter">
                <h2>Horror</h2>
                <h3 data-from="0" data-to="3121242" data-speed="8000" data-refresh-interval="50">3,121,242</h3>
              </div>
            </div>
            <div class="tg-collectioncounter tg-romance">
              <div class="tg-collectioncountericon">
                <i class="icon-heart"></i>
              </div>
              <div class="tg-titlepluscounter">
                <h2>Romance</h2>
                <h3 data-from="0" data-to="2101012" data-speed="8000" data-refresh-interval="50">2,101,012</h3>
              </div>
            </div>
            <div class="tg-collectioncounter tg-fashion">
              <div class="tg-collectioncountericon">
                <i class="icon-star"></i>
              </div>
              <div class="tg-titlepluscounter">
                <h2>Fashion</h2>
                <h3 data-from="0" data-to="1158245" data-speed="8000" data-refresh-interval="50">1,158,245</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'CollectionCount',
    computed: {
      ...mapGetters([
        'currentUser',
        'isAuthenticated'
      ])
    }
  }
</script>
