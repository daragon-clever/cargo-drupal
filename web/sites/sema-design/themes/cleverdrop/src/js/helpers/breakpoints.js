export const breakpoints = {
  md: 768,
  l: 1440
}

export const isMobile = () => window.matchMedia(`(max-width: ${breakpoints.md}px)`).matches

export const isDesktop = () => window.matchMedia(`(min-width: ${breakpoints.md + 1}px)`).matches

export const isBiggerThanL = () => window.matchMedia(`(min-width: ${breakpoints.l + 1}px)`).matches
