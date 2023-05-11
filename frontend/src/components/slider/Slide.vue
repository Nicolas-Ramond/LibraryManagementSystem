<template>
  <div class="item" data-vide-bg="poster: static/images/slider/img-01.jpg" data-vide-options="position: 0% 50%">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
          <div class="tg-slidercontent">
            <figure class="tg-authorimg"><a href="javascript:void(0);"><img src="static/images/author/imag-01.jpg" alt="image description"></a></figure>
            <h1>Jude Morphew</h1>
            <h2>Latest 2017 Release</h2>
            <div class="tg-description">
              <p>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore tolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamcoiars nisi ut aliquip commodo.</p>
            </div>
            <div class="tg-btns">
              <a class="tg-btn" href="javascript:void(0);">buy now</a>
              <a class="tg-btn" href="javascript:void(0);">read more</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'Slide',
    computed: {
      ...mapGetters([
        'currentUser',
        'isAuthenticated'
      ])
    }
  }
</script>
