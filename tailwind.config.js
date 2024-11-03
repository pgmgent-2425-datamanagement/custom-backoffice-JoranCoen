/** @type {import('tailwindcss').Config} */
import daisyui from "daisyui";

module.exports = {
  content: [
    './views/**/*.php',
  ],
  theme: {
    extend: {
      height: {
        21: '5rem',
      }
    },
  },
  daisyui: {
    themes: ["light", "dark", "cupcake"],
  },
  plugins: [
    daisyui,
  ],
}
