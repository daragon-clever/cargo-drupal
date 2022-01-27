import Dropdown from './components/dropdown'

window.addEventListener('DOMContentLoaded', () => {

  // Mobile menu
  const MainMenuBtns = document.querySelectorAll('[data-mobile-menu]')
  Array.prototype.map.call(MainMenuBtns, btn => {
    btn.dropdown = new Dropdown(btn, {
      clickOutside: '.MainMenu-inner',
      onOpen: () => {
        const body = document.querySelector('body')
        body.classList.add('has-backdrop')
      },
      onClose: () => {
        const body = document.querySelector('body')
        body.classList.remove('has-backdrop')
      }
    })
  })

  // SubMenus open
  const MainSubMenuBtns = document.querySelectorAll('[data-submenu-btn]')
  Array.prototype.map.call(MainSubMenuBtns, btn => {
    btn.dropdown = new Dropdown(btn, {
      clickOutside: '.MainSubMenu-inner',
      onOpen: () => {
        const body = document.querySelector('body')
        body.classList.add('has-backdrop')
      },
      onClose: () => {
        const body = document.querySelector('body')
        body.classList.remove('has-backdrop')
      }
    })
  })
})