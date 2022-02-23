import {Swiper, zoom} from 'swiper/bundle'

const prefixClass = 'slider'

const defaultParams = {
  wrapperClass: prefixClass + '-wrapper',
  slideActiveClass: 'is-active',
  slideDuplicateActiveClass: 'is-active',
  slideBlankClass: prefixClass + '-slideInvisibleBlank',
  slideClass: prefixClass + '-slide',
  slidePrevClass: prefixClass + '-slide-prev',
  slideDuplicatePrevClass: prefixClass + '-slide-duplicate-prev',
  slideNextClass: prefixClass + '-slide-next',
  slideDuplicateNextClass: prefixClass + '-slide-duplicate-next',
  slideVisibleClass: prefixClass + '-slide-visible',
}

const navParams = {
  navigation: {
    prevEl: `.${prefixClass}-btnPrev`,
    nextEl: `.${prefixClass}-btnNext`,
    disabledClass: 'is-disabled',
    hiddenClass: 'is-hidden',
  },
}


// SCROLLBAR OPTIONS
const scrollbarParams = {
  scrollbar: {
    el: `.${prefixClass}-scrollbar`,
    draggable: true,
    snapOnRelease: true,
    dragSize: 'auto',
    lockClass: prefixClass + '-scrollbar-lock',
    dragClass: prefixClass + '-scrollbar-drag',
  },
}

// PAGINATION OPTIONS
const paginatedParams = {
  pagination: {
    el: `.${prefixClass}-pagination`,
    type: 'bullets',
    clickable: true,
    clickableClass: 'is-clickable',
    currentClass: 'is-current',
    hiddenClass: 'is-hidden',
    lockClass: 'is-locked',
    modifierClass: 'is-',
    bulletClass: prefixClass + '-bullet',
    bulletActiveClass: 'is-active',
  },
}

function carousel() {

  const sliderInstagram = new Swiper(".js-instagram-slider", {
    ...defaultParams,
    ...paginatedParams,
    spaceBetween: 20,
    breakpoints: {
      0: {
        slidesPerView: 1.4,
      },
      499: {
        slidesPerView: 2.4,
      },
      749: {
        slidesPerView: 4,
      },
    }
  });

  const sliderCreation = new Swiper(".js-highlight-creation-slider", {
    ...defaultParams,
    ...scrollbarParams,
    spaceBetween: 20,
    breakpoints: {
      0: {
        slidesPerView: 2.2,
      },
      749: {
        slidesPerView: 3,
      },
    }
  });


  const sliderCollections = new Swiper(".js-collections-slider", {
    ...defaultParams,
    ...navParams,
    ...paginatedParams,
    loop: true,
    slidesPerView: 1,
    effect: 'fade',
    speed: 1000,
  });

  const backstageCollections = new Swiper(".js-backstage-slider", {
    ...defaultParams,
    ...navParams,
    loop: true,
    centeredSlides: true,
    watchSlidesProgress: true,
    effect: 'slide',
    speed: 300,
    breakpoints: {
      0: {
        slidesPerView: 1.7,
      },
      499: {
        slidesPerView: 2.2,
      },
      749: {
        slidesPerView: 3.8,
      },
      999: {
        slidesPerView: 4.3,
      },
    }
  });

  const historySlider = new Swiper(".js-history-slider", {
    ...defaultParams,
    ...navParams,
    loop: true,
    centeredSlides: true,
    watchSlidesProgress: true,
    breakpoints: {
      0: {
        spaceBetween: 30,
        slidesPerView: 1.4,
      },
      749: {
        spaceBetween: 60,
        slidesPerView: 2.4,
      },
      1199: {
        slidesPerView: 3.7,
      },
    }
  });

  const galleryThumbs = new Swiper(".js-imageGallery-thumbs", {
    ...defaultParams,
    ...navParams,
    ...paginatedParams,
    loop: true,
    centeredSlides: true,
    watchSlidesProgress: true,
    breakpoints: {
      0: {
        slidesPerView: 1.8,
      },
      499: {
        slidesPerView: 3.4,
      },
      749: {
        slidesPerView: 4.4,
      },
      999: {
        slidesPerView: 6.4,
      },
      1199: {
        slidesPerView: 8.4,
      },
    }
  });

  const gallery = new Swiper(".js-imageGallery", {
    ...defaultParams,
    ...navParams,
    ...paginatedParams,
    loop: true,
    slidesPerView: 1,
    effect: 'fade',
    speed: 0,
    thumbs: {
      swiper: galleryThumbs
    }
  });


  // sliderCollections.on('slidePrevTransitionStart', function () {
  //   let index_previousSlide = sliderCollections.activeIndex;

  //   console.log('previous : ', index_previousSlide);
  //   sliderCollections.slides[index_previousSlide].classList.add('effect');
  //   setTimeout(() => {
  //     sliderCollections.slides[index_previousSlide].classList.remove('effect');
  //   }, 1000);
  // });


  // sliderCollections.on('slideNextTransitionStart', function () {
  //   let index_nextSlide = sliderCollections.activeIndex;
  //   console.log('next : ', index_nextSlide);
  //   sliderCollections.slides[index_nextSlide].classList.add('effect');
  //   setTimeout(() => {
  //     sliderCollections.slides[index_nextSlide].classList.remove('effect');
  //   }, 1000);
  // });


  // pagination information on load (currentSlide index –– All slides collection number)
  function pagerInfo() {
    let onLoadInfo = document.querySelector('.js-withInfo .slider-slide:not(.swiper-slide-duplicate).is-active')
    let text = onLoadInfo.getAttribute('aria-label')
    let result = text.replace('/', '––');

    targetForInfos.innerHTML = result;
  }

  let targetForInfos = document.getElementById('slider-infos');
  if (targetForInfos) {
    pagerInfo();
  }

  backstageCollections.on('slideChange', function () {
    let index_activeSlide = backstageCollections.activeIndex;

    // pagination information incrementation
    let infos = backstageCollections.slides[index_activeSlide].getAttribute('aria-label');
    let result = infos.replace('/', '––');
    targetForInfos.innerHTML = result;
  });

  // Let synchronize both galleryThumbs and gallery slider
  galleryThumbs.on('slideChange', function () {
    let index_currentSlide = galleryThumbs.realIndex;
    let index_activeSlide = galleryThumbs.activeIndex;
    gallery.slideToLoop(index_currentSlide, 1000, false);

    // pagination information incrementation
    let infos = galleryThumbs.slides[index_activeSlide].getAttribute('aria-label');
    let result = infos.replace('/', '––');
    targetForInfos.innerHTML = result;
  });

  gallery.on('slideChange', function () {
    let index_currentSlide = gallery.realIndex;
    galleryThumbs.slideToLoop(index_currentSlide, 1000, false);
  });
}

window.addEventListener("DOMContentLoaded", carousel);
