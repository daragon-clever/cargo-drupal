/**
 * Adding animation class on element
 * @property {HTMLElement} element
 * @property {{rootMargin: string}} options
 */
class Animate {
  /**
   * @param {HTMLElement} element
   */
  constructor(element) {
    this.element = element
    this.options = this.parseAttribute()

    this.onIntersection = this.onIntersection.bind(this)
    const observer = new IntersectionObserver(this.onIntersection, this.options)
    observer.observe(element)
  }

  parseAttribute () {
    const defautlOptions = {
      rootMargin: "0px",
    }

    if(this.element.dataset.animate.startsWith('{')) {
      return {
        ...defautlOptions,
        ...JSON.parse(this.element.dataset.animate)
      }
    }
    return defautlOptions
  }

  /**
   * @param {IntersectionObserverEntry[]} entries
   */
  onIntersection (entries) {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        this.isIntersecting(entry)
      } else {
        console.log('coucou')
      }
    }
  }

  /**
   * 
   * @param {IntersectionObserverEntry} entry 
   */
  isIntersecting (entry) {
    entry.target.classList.add('is-animate')
  }

  /**
   * 
   * @returns {Animate[]}
   */
  static bind () {
    return Array.from(document.querySelectorAll('[data-animate]')).map(
      (element) => {
        return new Animate(element)
      }
    )
  }
}

Animate.bind()