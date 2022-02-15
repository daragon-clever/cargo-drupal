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
    spaceBetween: 20,
    loopFillGroupWithBlank: false,
    centeredSlides: true,
    slidesPerView: 5.2,
    speed: 700,
    watchSlidesProgress: true,
  });

  const historySlider = new Swiper(".js-history-slider", {
    ...defaultParams,
    ...navParams,
    loop: true,
    centeredSlides: true,
    slidesPerView: 1,
    breakpoints: {
      0: {
        spaceBetween: 30,
      },
      749: {
        spaceBetween: 60,
      },
    }
  });

  const galleryThumbs = new Swiper(".js-imageGallery-thumbs", {
    ...defaultParams,
    ...navParams,
    ...paginatedParams,
    loop: true,
    watchSlidesProgress: true,
  });

  const gallery = new Swiper(".js-imageGallery", {
    ...defaultParams,
    ...navParams,
    ...paginatedParams,
    loop: true,
    slidesPerView: 1,
    effect: 'fade',
    speed: 1000,
    thumbs: {
      swiper: galleryThumbs
    }
  });


  // pagination information on load (currentSlide index –– All slides collection number)
  function pagerInfo() {
    let onLoadInfo = document.querySelector('.js-imageGallery-thumbs .slider-slide:not(.swiper-slide-duplicate).is-active')
    let text = onLoadInfo.getAttribute('aria-label')
    let result = text.replace('/', '––');

    targetForInfos.innerHTML = result;
  }

  let targetForInfos = document.getElementById('slider-infos');
  if (targetForInfos) {
    pagerInfo();
  }

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
