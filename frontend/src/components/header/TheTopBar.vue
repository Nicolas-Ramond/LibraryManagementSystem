<template>
  <div class="tg-middlecontainer">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <strong class="tg-logo"><a href="index.html"><img src="static/images/logo.png" alt="company name here"></a></strong>

          <div class="tg-wishlistandcart">
            <div class="dropdown tg-themedropdown tg-wishlistdropdown">
              <a href="javascript:void(0);" id="tg-wishlisst" class="tg-btnthemedropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="tg-themebadge">3</span>
                <i class="icon-heart"></i>
                <span>Wishlist</span>
              </a>
              <div class="dropdown-menu tg-themedropdownmenu" aria-labelledby="tg-wishlisst">
                <div class="tg-description"><p>No products were added to the wishlist!</p></div>
              </div>
            </div>
            <div class="dropdown tg-themedropdown tg-minicartdropdown">
              <a href="javascript:void(0);" id="tg-minicart" class="tg-btnthemedropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="tg-themebadge">3</span>
                <i class="icon-cart"></i>
                <span>$123.00</span>
              </a>
              <div class="dropdown-menu tg-themedropdownmenu" aria-labelledby="tg-minicart">
                <div class="tg-minicartbody">
                  <div class="tg-minicarproduct">
                    <figure>
                      <img src="static/images/products/img-01.jpg" alt="image description">

                    </figure>
                    <div class="tg-minicarproductdata">
                      <h5><a href="javascript:void(0);">Our State Fair Is A Great Function</a></h5>
                      <h6><a href="javascript:void(0);">$ 12.15</a></h6>
                    </div>
                  </div>
                  <div class="tg-minicarproduct">
                    <figure>
                      <img src="static/images/products/img-02.jpg" alt="image description">

                    </figure>
                    <div class="tg-minicarproductdata">
                      <h5><a href="javascript:void(0);">Bring Me To Light</a></h5>
                      <h6><a href="javascript:void(0);">$ 12.15</a></h6>
                    </div>
                  </div>
                  <div class="tg-minicarproduct">
                    <figure>
                      <img src="static/images/products/img-03.jpg" alt="image description">

                    </figure>
                    <div class="tg-minicarproductdata">
                      <h5><a href="javascript:void(0);">Have Faith In Your Soul</a></h5>
                      <h6><a href="javascript:void(0);">$ 12.15</a></h6>
                    </div>
                  </div>
                </div>
                <div class="tg-minicartfoot">
                  <a class="tg-btnemptycart" href="javascript:void(0);">
                    <i class="fa fa-trash-o"></i>
                    <span>Clear Your Cart</span>
                  </a>
                  <span class="tg-subtotal">Subtotal: <strong>35.78</strong></span>
                  <div class="tg-btns">
                    <a class="tg-btn tg-active" href="javascript:void(0);">View Cart</a>
                    <a class="tg-btn" href="javascript:void(0);">Checkout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tg-searchbox">
            <form class="tg-formtheme tg-formsearch">
              <fieldset>
                <input type="text" name="search" class="typeahead form-control" placeholder="Search by title, author, keyword, ISBN...">
                <button type="submit"><i class="icon-magnifier"></i></button>
              </fieldset>
              <a href="javascript:void(0);">+  Advanced Search</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'TheMiddleContainer',
    computed: {
      ...mapGetters([
        'currentUser',
        'isAuthenticated'
      ])
    }
  }
</script>
