'use strict';

function paralax() {
  const distance = window.scrollY
  let elems = document.querySelectorAll('.paralax img');

  if (elems) {
    elems.forEach(function(item) {
      item.style.transform = `translateY(${-distance *
        .2}px)`;
    });
  }
}

window.addEventListener("scroll", paralax, false);
