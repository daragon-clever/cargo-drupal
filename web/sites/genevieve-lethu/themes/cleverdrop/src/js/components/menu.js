'use strict';

const elem = {
  cta: document.querySelector('.js-header-cta'),
  nav: document.querySelector('.js-header-nav'),
  body: document.documentElement
}

const menu = function() {

  function toggleMenu(e) {
    let target = e.currentTarget;

    if (!target.classList.contains('is-open')) {
      target.classList.add('is-open');
      elem.nav.classList.add('is-open');
      elem.body.classList.add('is-fixed');
    } else {
      target.classList.remove('is-open');
      elem.nav.classList.remove('is-open');
      elem.body.classList.remove('is-fixed');
    }
  }

  elem.cta.addEventListener('click', toggleMenu, false);
};

window.addEventListener("DOMContentLoaded", menu);
