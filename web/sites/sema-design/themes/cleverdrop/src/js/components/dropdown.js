import { isMobile } from '../helpers/breakpoints'
export default class Dropdown {
  constructor (element, options) {
    this._element = element
    this._panel = document.querySelector(`[aria-labelledby="${element.getAttribute('id')}"]`)
    this._groupBtns = document.querySelectorAll(`[data-dropdown-group="${element.dataset.dropdownGroup}"]`)
    this._closeBtn = document.querySelectorAll(`[data-close="${element.id}"]`)
    this.backdrop = document.querySelector('.fvBackdrop')
    this.options = {
      clickOutside: element.dataset.dropdownOutside === "true" ? true : false,
      openBackDrop: element.dataset.dropdownBackdrop === "true" ? true : false,
      ...options
    }

    Array.prototype.map.call(this._closeBtn, btn => {
      btn.addEventListener('click', e => {
        this.closeDropdown()
      })
    })

    element.addEventListener('click', e => {
      e.preventDefault()
      if (this._element.ariaExpanded === 'true') {
        this.closeDropdown()
      } else {
        this.openDropdown()
      }
    })
  }

  clickOutside = event => {
    const { target } = event
    const parentEl = typeof this.options.clickOutside !== 'boolean'
      ? this.options.clickOutside
      : `[aria-labelledby="${this._panel.getAttribute('aria-labelledby')}"]`

    if (
      !target.closest(parentEl)
      && !target.closest(`#${this._element.id}`)) {
      this.closeDropdown()
    }
  }

  openDropdown = () => {
    if (this.options.beforeOpen) {
      this.options.beforeOpen()
    }

    if (this._groupBtns) {
      Array.prototype.map.call(this._groupBtns, btn => {
        if(btn.getAttribute('aria-expanded') === 'true') btn.dropdown.closeDropdown()
      })
    }
    this._panel.classList.add('is-open')
    this._element.ariaExpanded = true
    this._element.classList.add('is-active')

    if (this.options.clickOutside) {
      document.addEventListener('click', this.clickOutside, false)
    }

    if (this.options.onOpen) {
      this.options.onOpen()
    }
  }

  closeDropdown = () => {
    this._panel.classList.remove('is-open')
    this._element.ariaExpanded = false
    this._element.classList.remove('is-active')

    if (this.options.clickOutside) {
      document.removeEventListener('click', this.clickOutside)
    }

    if (this.options.onClose) {
      this.options.onClose()
    }
  }
}