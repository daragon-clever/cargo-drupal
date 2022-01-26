import Slider from './components/slider'

export const Classes = {
  SLIDER_PREFIX: 'Slider',
}

export const Selectors = {
  SLIDER_CONTAINER: '.js-slider',
  BTN_PREV: `.${Classes.SLIDER_PREFIX}-btnPrev`,
  BTN_NEXT: `.${Classes.SLIDER_PREFIX}-btnNext`,
  PAGINATION: `.${Classes.SLIDER_PREFIX}-pagination`,
  SCROLLBAR: `.${Classes.SLIDER_PREFIX}-scrollbar`,
}

// COMMON OPTIONS FOR ALL SLIDERS
export const CommonSliderOptions = {
  spaceBetween: 20,
  keyboard: {
    enabled: true,
    onlyInViewport: true,
  },
  containerModifierClass: Classes.SLIDER_PREFIX + '-',
  wrapperClass: Classes.SLIDER_PREFIX + '-wrapper',
  slideActiveClass: 'is-active',
  slideBlankClass: Classes.SLIDER_PREFIX + '-slideInvisibleBlank',
  slideClass: Classes.SLIDER_PREFIX + '-slide',
  slidePrevClass: Classes.SLIDER_PREFIX + '-slide-prev',
  slideNextClass: Classes.SLIDER_PREFIX + '-slide-next',
  slideVisibleClass: Classes.SLIDER_PREFIX + '-slide-visible',
  a11y: {
    notificationClass: Classes.SLIDER_PREFIX + '-notification',
  },
}

export const NavigationSliderOptions = {
  navigation: {
    prevEl: Selectors.BTN_PREV,
    nextEl: Selectors.BTN_NEXT,
    disabledClass: 'is-disabled',
    hiddenClass: 'is-hidden',
  },
}

// SCROLLBAR OPTIONS
export const ScrollbarSliderOptions = {
  scrollbar: {
    el: Selectors.SCROLLBAR,
    draggable: true,
    snapOnRelease: true,
    dragSize: 'auto',
    lockClass: Classes.SLIDER_PREFIX + '-scrollbar-lock',
    dragClass: Classes.SLIDER_PREFIX + '-scrollbar-drag',
  },
}

// PAGINATION OPTIONS
export const PaginatedSliderOptions = {
  pagination: {
    el: Selectors.PAGINATION,
    type: 'bullets',
    clickable: true,
    clickableClass: 'is-clickable',
    currentClass: 'is-current',
    hiddenClass: 'is-hidden',
    lockClass: 'is-locked',
    modifierClass: 'is-',
    bulletClass: Classes.SLIDER_PREFIX + '-bullet',
    bulletActiveClass: 'is-active',
  },
}

window.addEventListener('DOMContentLoaded', () => {
  const CommonSliders = document.querySelectorAll(Selectors.SLIDER_CONTAINER)

  Array.prototype.map.call(CommonSliders,
    el => new Slider(
      el,
      Selectors,
      {
        ...CommonSliderOptions,
        ...NavigationSliderOptions,
        ...PaginatedSliderOptions,
        ...ScrollbarSliderOptions,
        slidesPerView: 'auto',
      }
    )
  )

  const InstagramSlider = document.querySelectorAll('.js-instagram-slider')

  Array.prototype.map.call(InstagramSlider,
    el => new Slider(
      el,
      Selectors,
      {
        ...CommonSliderOptions,
        ...ScrollbarSliderOptions,
        breakpoints: {
          0: {
            slidesPerView: 2,
          },
          // when window width is >= 480px
          769: {
            slidesPerView: 4,
          },
        }
      }
    )
  )

  const HomeBanner = document.querySelectorAll('.js-home-banner')

  Array.prototype.map.call(HomeBanner,
    el => new Slider(
      el,
      Selectors,
      {
        ...CommonSliderOptions,
        speed: 0,
        autoplay: {
          delay: 4000,
        },
        keyboard: {
          enabled: false,
        },
        effect: "creative",
      }
    )
  )
})
