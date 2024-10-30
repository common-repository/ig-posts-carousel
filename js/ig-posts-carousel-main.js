/**
 * Main js
 */
jQuery(document).ready(function($) {
$(".ig-posts-carousel").slick({
  pauseOnHover:true,
  adaptiveHeight: true,
  dotsClass: 'igpc-slick-dots',
  prevArrow:'<button type="button" class="igpc-slick-prev"></button>',
  nextArrow:'<button type="button" class="igpc-slick-next"></button>',
  responsive: [
     {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
 ]
    });
});