'use strict';

const elem = {
  controls: document.querySelectorAll('.js-videoPlayer-controls'),
}

const videoPlayer = function() {

  function playPause(e) {
    let target = e.currentTarget;
    let player = target.closest('.videoPlayer').querySelector('.js-videoPlayer-container');

    if (target.classList.contains('on-poster')) {
      target.classList.remove('on-poster');
    }

    if (player.paused) {
      target.classList.add('is-played');
      target.classList.remove('is-paused');
      player.play();
    } else {
      target.classList.add('is-paused');
      target.classList.remove('is-played');
      player.pause();
    }
  }

  if (elem.controls) {
    elem.controls.forEach(function(item) {
      item.addEventListener('click', playPause, false);
    });
  }
};

window.addEventListener("DOMContentLoaded", videoPlayer);
