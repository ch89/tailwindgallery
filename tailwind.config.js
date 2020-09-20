module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
  },
  purge: [],
  theme: {
    extend: {
      inset: {
        "5": "1.25rem",
        "8": "2rem"
      },
      colors: {
        star: "#ffc107"
      }
    },
  },
  variants: {
    backgroundColor: ['responsive', 'even', 'hover', 'focus']
  },
  plugins: [],
}
