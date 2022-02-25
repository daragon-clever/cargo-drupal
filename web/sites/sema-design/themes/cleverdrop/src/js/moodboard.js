/**
 * Adding animation class on element
 * @property {HTMLElement} element
 */
 class MoodBoard {
  /**
   * @param {HTMLElement} element
   */
  constructor (element) {
    this._element = element
    this._imgs = element.querySelectorAll('[data-moodboard-img]')

    Array.from(this._imgs).map( el => {
      el.addEventListener('mouseenter', e => {
        e.preventDefault()
        Array.from(this._imgs).map( el => {
          el.classList.add('is-animate')
        })
      })
      el.addEventListener('mouseleave', e => {
        e.preventDefault()
        Array.from(this._imgs).map( el => {
          el.classList.remove('is-animate')
        })
      })
    })
  }

  /**
   * 
   * @returns {Backdrop[]}
   */
   static bind () {
    return Array.from(document.querySelectorAll('[data-moodboard]')).map(
      (element) => {
        return element.MoodBoard = new MoodBoard(element)
      }
    )
  }
}

MoodBoard.bind()