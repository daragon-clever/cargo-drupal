export default class Backdrop {
  constructor (element, options) {
    this._element = element
    this._body = document.querySelector('body')

    element.addEventListener('backdrop:open', e => {
      e.preventDefault()
      this.open()
    })

    element.addEventListener('backdrop:close', e => {
      e.preventDefault()
      this.close()
    })
  }

  open({ higher, top } = {}) {
    this._element.classList.add('is-open')
    if (higher) this._element.classList.add('is-higher')
    this._element.style.top = top ? top.getBoundingClientRect().bottom + 'px' : '0'
    this._body.classList.add('backdrop-open')
  }

  close() {
    this._element.classList.remove('is-open')
    this._element.classList.remove('is-higher')
    this._body.classList.remove('backdrop-open')
  }
}
