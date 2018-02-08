jQuery(document).ready(function () {
  var mySwiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 2000,
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    autoplay: {
      delay: 7000,
    },
  })
});
