module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
        opacity: ['disabled'],
    }
  },
  variants: {},
  plugins: [
      require('@tailwindcss/forms'),
  ]
}
