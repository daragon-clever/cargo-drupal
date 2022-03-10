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
    speed: 0,
  });

  const backstageCollections = new Swiper(".js-backstage-slider", {
    ...defaultParams,
    ...navParams,
    loop: true,
    centeredSlides: true,
    watchSlidesProgress: true,
    effect: 'slide',
    speed: 300,
    autoHeight: true,
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
    },
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
  });

  const historySlider = new Swiper(".js-history-slider", {
    ...defaultParams,
    ...navParams,
    loop: true,
    centeredSlides: true,
    watchSlidesProgress: true,
    autoHeight: true,
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
    },
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
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
    watchSlidesVisibility: true,
    speed: 0,
    thumbs: {
      swiper: galleryThumbs
    }
  });


  /* *********************************** */
  /*            CUSTOM HANDLE            */
  /* *********************************** */
  sliderCollections.on('slideNextTransitionStart', function () {
    let index_nextSlide = sliderCollections.activeIndex;
    sliderCollections.slides[index_nextSlide].classList.add('effect-next');

    setTimeout(() => {
      sliderCollections.slides[index_nextSlide].classList.remove('effect-next');
    }, 1000);
  });

  sliderCollections.on('slidePrevTransitionEnd', function () {
    let index_prevSlide = sliderCollections.previousIndex;
    sliderCollections.slides[index_prevSlide].classList.add('effect-prev');

    setTimeout(() => {
      sliderCollections.slides[index_prevSlide].classList.remove('effect-prev');
    }, 1000);
  });

  gallery.on('slideNextTransitionStart', function () {
    let index_nextSlide = gallery.activeIndex;
    gallery.slides[index_nextSlide].classList.add('effect-next');

    setTimeout(() => {
      gallery.slides[index_nextSlide].classList.remove('effect-next');
    }, 1000);
  });

  gallery.on('slidePrevTransitionEnd', function () {
    let index_prevSlide = gallery.previousIndex;

    if (index_prevSlide === 0) {
      index_prevSlide = parseInt(gallery.slides.length - 1);
    }

    gallery.slides[index_prevSlide].classList.add('effect-prev');

    setTimeout(() => {
      gallery.slides[index_prevSlide].classList.remove('effect-prev');
    }, 1000);
  });


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
    let index_activeSlide = galleryThumbs.activeIndex;

    // pagination information incrementation
    let infos = galleryThumbs.slides[index_activeSlide].getAttribute('aria-label');
    let result = infos.replace('/', '––');
    targetForInfos.innerHTML = result;
  });

  galleryThumbs.on('slideNextTransitionEnd', function () {
    let btnNext = document.querySelector('.js-imageGallery .slider-btnNext');
    btnNext.click();
  });

  galleryThumbs.on('slidePrevTransitionEnd', function () {
    let btnPrev = document.querySelector('.js-imageGallery .slider-btnPrev');
    btnPrev.click();
  });

  gallery.on('slideChange', function () {
    let index_currentSlide = gallery.realIndex;
    galleryThumbs.slideToLoop(index_currentSlide, 1000, false);
  });
}

window.addEventListener("DOMContentLoaded", carousel);
