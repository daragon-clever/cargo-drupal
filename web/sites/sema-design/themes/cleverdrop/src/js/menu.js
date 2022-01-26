import Dropdown from './components/dropdown'

window.addEventListener('DOMContentLoaded', () => {
  // MENU
  const menuToggles = document.querySelectorAll('[data-menu-toggle="menuToggle"]')
  Array.prototype.map.call(menuToggles, toggle => {
    if(toggle) {
      toggle.dropdown = new Dropdown(toggle, {
        clickOutside: '.fvMainMenu',
        onOpen: () => {
          const backdrop = document.querySelector('.fvBackdrop')
          backdrop.backdrop.open()
        },
        onClose: () => {
          const backdrop = document.querySelector('.fvBackdrop')
          backdrop.backdrop.close()
        }
      })
    }
  })

  const MainMenuBtns = document.querySelectorAll('[data-submenu-btn]')
  Array.prototype.map.call(MainMenuBtns, btn => {
    btn.dropdown = new Dropdown(btn, {
      clickOutside: true,
    })
  })
})