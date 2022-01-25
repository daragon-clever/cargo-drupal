import Swiper from 'swiper/bundle'

const Attributes = {
  HIDDEN: 'hidden',
}

export default class Slider {
  constructor (element, selectors, options) {
    this._element = element
    this._sliderEl = this._element.querySelector(selectors.SLIDER_WRAPPER)
    this._slider = new Swiper(this._element, options)

    this._btnPlay = element.querySelector('.js-slider-play')
    if (this._btnPlay) {
      this._btnPlay.addEventListener('click', this._btnPlay, false)
    }

    this._btnPause = element.querySelector('.js-slider-pause')
    if (this._btnPause) {
      this._btnPause.addEventListener('click', this.pause, false)
    }
  };

  play = () => {
    this.slider.autoplay.start()
    this._btnPlay.setAttribute(Attributes.HIDDEN, '')
    this._btnPause.removeAttribute(Attributes.HIDDEN)
    this._btnPause.focus()
  };

  pause = () => {
    this.slider.autoplay.pause()
    this._btnPause.setAttribute(Attributes.HIDDEN, '')
    this._btnPlay.removeAttribute(Attributes.HIDDEN)
    this._btnPlay.focus()
  };
}
