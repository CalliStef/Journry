const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      fontFamily: {
        teko: ['"Teko"', ...defaultTheme.fontFamily.sans]
      }
    },
  },
  plugins: [],
}