<template>
  <section class="tg-parallax tg-bgcalltoaction tg-haslayout" data-z-index="-100" data-appear-top-offset="600" data-parallax="scroll" data-image-src="static/images/parallax/bgparallax-06.jpg">
    <div class="tg-sectionspace tg-haslayout">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="tg-calltoaction">
              <h2>Open Discount For All</h2>
              <h3>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore.</h3>
              <a class="tg-btn tg-active" href="javascript:void(0);">Read More</a>
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
    name: 'CallToAction',
    computed: {
      ...mapGetters([
        'currentUser',
        'isAuthenticated'
      ])
    }
  }
</script>
