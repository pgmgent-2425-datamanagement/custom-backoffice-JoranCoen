/** @type {import('tailwindcss').Config} */
import daisyui from "daisyui";

module.exports = {
  content: ["./views/**/*.php"],
  theme: {
    extend: {
      width: {
        '275': '68.75rem',
      },
      height: {
        '150': '37.5rem',
        '180': '45rem',
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
