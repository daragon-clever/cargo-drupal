import debounce from 'lodash.debounce'
import Slider from './components/slider'
import { isDesktop } from './helpers/breakpoints'

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

  const ContentsTable = document.querySelectorAll('.js-contents-table')

  Array.prototype.map.call(ContentsTable,
    el => {
      new Slider(
        el,
        Selectors,
        {
          ...CommonSliderOptions,
          ...ScrollbarSliderOptions,
          pagination: {
            el: ".Slider-pagination",
            type: 'bullets',
            clickable: true,
          },
          navigation: {
            nextEl: ".Slider-button-next",
            prevEl: ".Slider-button-prev",
          },
          breakpoints: {
            0: {
              slidesPerView: 1.5,
              centeredSlides: true,
            },
            // when window width is >= 769px
            769: {
              slidesPerView: 3,
              centeredSlides: false,
            },
          }
        }
      )

      const initSlider = () => {
        if (isDesktop() && el.querySelectorAll('.ContentsTable-slide').length <= 3) {
          el.swiper.enabled = false
          el.classList.add('is-disabled')
        } else {
          el.swiper.enabled = true
          el.classList.remove('is-disabled')
        }
      }
    
      window.addEventListener('resize', debounce(initSlider, 200))
      initSlider()
    }
  )

  const WhoAreWe = document.querySelectorAll('.js-who-are-we')

  Array.prototype.map.call(WhoAreWe,
    el => new Slider(
      el,
      Selectors,
      {
        ...CommonSliderOptions,
        ...ScrollbarSliderOptions,
        pagination: {
          el: ".Slider-pagination",
          type: 'bullets',
          clickable: true,
        },
        navigation: {
          nextEl: ".Slider-button-next",
          prevEl: ".Slider-button-prev",
        },
        breakpoints: {
          0: {
            slidesPerView: 1.5,
            loop: true,
          },
          // when window width is >= 769px
          769: {
            slidesPerView: 2,
            loop: true,
          },
        }
      }
    )
  )

  const PressRelease = document.querySelectorAll('.js-press-release')

  Array.prototype.map.call(PressRelease,
    el => new Slider(
      el,
      Selectors,
      {
        ...CommonSliderOptions,
        ...ScrollbarSliderOptions,
        pagination: {
          el: ".Slider-pagination",
          type: 'bullets',
          clickable: true,
        },
        navigation: {
          nextEl: ".Slider-button-next",
          prevEl: ".Slider-button-prev",
        },
        breakpoints: {
          0: {
            slidesPerView: 1.6,
            slidesPerGroup: 1,
          },
          // when window width is >= 769px
          769: {
            slidesPerView: 3,
            slidesPerGroup: 3,
          },
        }
      }
    )
  )


  /**
   * Product slider
   */
  const initProductSlider = () => {
    const ProductSlider = document.querySelectorAll('.js-product-slider')

    Array.prototype.map.call(ProductSlider,
      el => {
        if (el.swiper) el.swiper.destroy()

        if (isDesktop()) {
          new Slider(
            el,
            Selectors,
            {
              ...CommonSliderOptions,
              ...ScrollbarSliderOptions,
              wrapperClass: 'ProductSlider-wrapper',
              slideClass: 'ProductSlider-slide',
              spaceBetween: 0,
              effect: "creative",
            }
          )
    
          const thumbs = document.querySelector(`[data-control-id="${el.id}"]`)
    
          if (thumbs) {
            Array.prototype.map.call(thumbs.querySelectorAll(`[data-slide]`), thumb => {
              thumb.addEventListener('mouseover', e => {
                e.preventDefault()
                el.swiper.slideTo(thumb.dataset.slide)
              })
            })
          }
        } else {
          new Slider(
            el,
            Selectors,
            {
              ...CommonSliderOptions,
              ...ScrollbarSliderOptions,
              wrapperClass: 'ProductSlider-wrapper',
              slideClass: 'ProductSlider-slide',
              slidesPerView: "auto",
            },
          )
        }
      }
    )
  }

  window.addEventListener('resize', debounce(initProductSlider, 200))

  initProductSlider()
})
