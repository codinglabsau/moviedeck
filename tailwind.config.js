module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        colors: {
            footer: "#3F3F46"
        },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
