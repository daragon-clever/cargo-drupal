(function($) {

  var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

  function initBurger() {
    $('.hamburger').click(function() {
      $('.hamburger').toggleClass('active');
      $('#menu').toggleClass('active');
    });
  }

  function initSliderCollection() {
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
  }

  function initVideoElement() {
    $('.video_control').click(function() {
      if (!$(this).hasClass('playing')) {
        $('.video_control video').get(0).play();
      } else {
        $('.video_control video').get(0).pause();
      }
      $(this).toggleClass('playing');
      $(this).toggleClass('touched');
    });
  }

  function initCarouselInstagramOnMobiles() {
    console.log(isTabletOrLess);
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
  }

  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  }

  jQuery(document).ready(function () {
    initBurger();
    initSliderCollection();
    initCarouselInstagramOnMobiles();
    initVideoElement();
    initSmoothScroll();
  });

  jQuery(window).resize(function () {

    isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    initCarouselInstagramOnMobiles();
  });

} (jQuery));
