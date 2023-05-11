<template>
  <section class="tg-parallax tg-bgtestimonials tg-haslayout" data-z-index="-100" data-appear-top-offset="600" data-parallax="scroll" data-image-src="static/images/parallax/bgparallax-05.jpg">
    <div class="tg-sectionspace tg-haslayout">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-push-2">
            <div id="tg-testimonialsslider" class="tg-testimonialsslider tg-testimonials owl-carousel">
              <div class="item tg-testimonial">
                <figure><img src="static/images/author/imag-02.jpg" alt="image description"></figure>
                <blockquote><q>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore tolore magna aliqua enim ad minim veniam, quis nostrud exercitation ullamcoiars nisi ut aliquip commodo.</q></blockquote>
                <div class="tg-testimonialauthor">
                  <h3>Holli Fenstermacher</h3>
                  <span>Manager @ CIFP</span>
                </div>
              </div>
              <div class="item tg-testimonial">
                <figure><img src="static/images/author/imag-02.jpg" alt="image description"></figure>
                <blockquote><q>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore tolore magna aliqua enim ad minim veniam, quis nostrud exercitation ullamcoiars nisi ut aliquip commodo.</q></blockquote>
                <div class="tg-testimonialauthor">
                  <h3>Holli Fenstermacher</h3>
                  <span>Manager @ CIFP</span>
                </div>
              </div>
              <div class="item tg-testimonial">
                <figure><img src="static/images/author/imag-02.jpg" alt="image description"></figure>
                <blockquote><q>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore tolore magna aliqua enim ad minim veniam, quis nostrud exercitation ullamcoiars nisi ut aliquip commodo.</q></blockquote>
                <div class="tg-testimonialauthor">
                  <h3>Holli Fenstermacher</h3>
                  <span>Manager @ CIFP</span>
                </div>
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
    name: 'Testimonials',
    computed: {
      ...mapGetters([
        'currentUser',
        'isAuthenticated'
      ])
    }
  }
</script>
