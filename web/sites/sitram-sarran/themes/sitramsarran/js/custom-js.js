jQuery(document).ready(function ($) {

  $('.hamburger').click(function() {
    $('.hamburger').toggleClass('active');
    $('#menu').toggleClass('active');
  });

  var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

  $('#slider_collection').owlCarousel({
    loop: true,
    margin: 0,
    responsiveClass: true,
    items:1,
    nav:true,
    navText : [
      "<img src=\"/sites/sitram-sarran/themes/sitramsarran/images/Pictos_Icons/Icon feather-arrow-left-circle.svg\"/>",
      "<img src=\"/sites/sitram-sarran/themes/sitramsarran/images/Pictos_Icons/Icon feather-arrow-right-circle.svg\"/>",
    ]
  });

  if (isTabletOrLess) {
    $('#slider_instagram').owlCarousel({
      loop:true,
      margin:0,
      nav:true,
      dots: false,
      autoPlay: 2500,
      responsive:{
        0:{
          items:1
        }
      }
    });
  }

  $('.video_control').click(function() {
    if (!$(this).hasClass('playing')) {
      $('.video_control video').get(0).play();
    } else {
      $('.video_control video').get(0).pause();
    }
    $(this).toggleClass('playing');
    $(this).toggleClass('touched');
  });

  /*if (isTabletOrLess) {
    productsSlider.slick({
      infinite: true,
      dots: true,
      adaptiveHeight: true
    });
  }*/

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();

      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });

});
