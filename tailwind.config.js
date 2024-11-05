/** @type {import('tailwindcss').Config} */
import daisyui from "daisyui";

module.exports = {
  content: ["./views/**/*.php"],
  theme: {
    extend: {
      height: {
        '212': '53rem',
      },
    },
  },
  plugins: [
    daisyui,
  ],
  daisyui: {
    themes: ["light", "dark", "cupcake"],
  },
};
