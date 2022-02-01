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

  });

} (jQuery));
