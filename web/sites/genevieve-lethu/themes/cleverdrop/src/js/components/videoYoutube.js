'use strict';

const elem = {
  player: 'videoYoutube',
  element: document.getElementById('videoYoutube'),
  controls: document.querySelectorAll('.js-videoYoutube-controls')
}

const videoYoutube = function() {
  if (!elem.element) {
    return;
  }

  let player;

  let id_video = elem.element.getAttribute('data-playerID');

  window.YT.ready(function() {
    player = new YT.Player(elem.player, {
      width: '900',
      height: '505',
      videoId: id_video,
    });
  });

  function playPause(e) {
    let target = e.currentTarget;

    player.playVideo();

    if (target.classList.contains('on-poster')) {
      target.classList.remove('on-poster');
    }
  }

  if (elem.controls) {
    elem.controls.forEach(function(item) {
      item.addEventListener('click', playPause, false);
    });
  }
};

window.addEventListener("DOMContentLoaded", videoYoutube);
