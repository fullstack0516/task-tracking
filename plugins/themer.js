const plugin = require('tailwindcss/plugin')

module.exports = plugin.withOptions(function (options = {}) {
  return function({ addUtilities, theme }) {
    const themes = options.themes ? options.themes : {
      green: {
        accent: theme('colors.green.600'),
        light: theme('colors.green.400'),
        dark: theme('colors.green.800'),
        contrast: theme('colors.white'),
      },
      teal: {
        accent: theme('colors.teal.600'),
        light: theme('colors.teal.400'),
        dark: theme('colors.teal.800'),
        contrast: theme('colors.white'),
      },
      blue: {
        accent: theme('colors.blue.600'),
        light: theme('colors.blue.400'),
        dark: theme('colors.blue.800'),
        contrast: theme('colors.white'),
      },
      indigo: {
        accent: theme('colors.indigo.600'),
        light: theme('colors.indigo.400'),
        dark: theme('colors.indigo.800'),
        contrast: theme('colors.white'),
      },
      purple: {
        accent: theme('colors.purple.600'),
        light: theme('colors.purple.400'),
        dark: theme('colors.purple.800'),
        contrast: theme('colors.white'),
      },
      yellow: {
        accent: theme('colors.yellow.600'),
        light: theme('colors.yellow.400'),
        dark: theme('colors.yellow.800'),
        contrast: theme('colors.white'),
      },
      orange: {
        accent: theme('colors.orange.600'),
        light: theme('colors.orange.400'),
        dark: theme('colors.orange.800'),
        contrast: theme('colors.white'),
      },
      rose: {
        accent: theme('colors.rose.600'),
        light: theme('colors.rose.400'),
        dark: theme('colors.rose.800'),
        contrast: theme('colors.white'),
      },
      pink: {
        accent: theme('colors.pink.600'),
        light: theme('colors.pink.400'),
        dark: theme('colors.pink.800'),
        contrast: theme('colors.white'),
      },
      gray: {
        accent: theme('colors.gray.600'),
        light: theme('colors.gray.400'),
        dark: theme('colors.gray.800'),
        contrast: theme('colors.white'),
      },
    }

    addUtilities({
      '.bg-accent': {
          'background-color': 'var(--accent-color)',
      },
      '.text-accent': {
          color: 'var(--accent-color)',
      },
      '.ring-accent': {
        '--tw-ring-color': 'var(--accent-color)',
      },
      '.text-accent-contrast': {
          color: 'var(--accent-contrast-color)',
      },
    })
  }
})
