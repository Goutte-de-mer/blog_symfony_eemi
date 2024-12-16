/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {
      colors: {
        dark_purple: "#a663cc",
        light_purple: "#b298dc",
        grey_blue: "#b8d0eb",
        blue: "#b9faf8",
        black: "#515151",
      },
    },
  },
  plugins: [],
};
