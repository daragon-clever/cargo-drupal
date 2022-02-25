const page = document.querySelector('.Page')
const header = document.querySelector('.Header')

function onScroll(){
  requestAnimationFrame(() => {
    if (page.getBoundingClientRect().y < 0) {
      header.classList.add('is-sticky')
    } else {
      header.classList.remove('is-sticky')
    }
  })
}

window.addEventListener('scroll', onScroll)
