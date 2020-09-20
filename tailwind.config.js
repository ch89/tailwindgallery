module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
  },
  purge: [],
  theme: {
    extend: {
      inset: {
        "5": "1.25rem"
      },
    },
  },
  variants: {
    backgroundColor: ['responsive', 'even', 'hover', 'focus']
  },
  plugins: [],
}
