/**
 * Adding animation class on element
 * @property {HTMLElement} element
 */
class Backdrop {
  /**
   * @param {HTMLElement} element
   */
  constructor (element) {
    this._element = element
    this._body = document.querySelector('body')
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

  /**
   * 
   * @returns {Backdrop[]}
   */
   static bind () {
    return Array.from(document.querySelectorAll('[data-backdrop]')).map(
      (element) => {
        return element.backdrop = new Backdrop(element)
      }
    )
  }
}

Backdrop.bind()
