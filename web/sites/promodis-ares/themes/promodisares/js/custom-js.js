(function($) {

  jQuery(document).ready(function () {

    var elementsAnimated = document.querySelectorAll('.fadein-animation');
    elementsAnimated.forEach(function(element) {
      var waypointOpacity = new Waypoint.Inview({
        element: element,
        entered: function(direction) {
          this.element.classList.add('fadein-animation-start');
          console.log(this);
        },
        exited: function(direction) {
          this.element.classList.remove('fadein-animation-start');
        },
      });
    });

    var simpleParallaxImages = document.getElementsByClassName('ares_img_parallax');
    new simpleParallax(simpleParallaxImages);

    var elementsAnimatedLogo = document.querySelectorAll('.ares_header_top_logo');
    elementsAnimatedLogo.forEach(function(element) {
      var waypointLogoAnimation = new Waypoint.Inview({
        element: element,
        entered: function(direction) {
          this.element.classList.add('appears');
          console.log(this);
        },
        exited: function(direction) {
          this.element.classList.remove('appears');
        },
      });
    });
  });

} (jQuery));
