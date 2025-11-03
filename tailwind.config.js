/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        bcake: {
          bitter:  "#362320", // Bitter Cocoa
          wine:    "#57091d", // Wine Cherry (deep)
          cherry:  "#890524", // Cherry accent
          truffle: "#6a4e4a", // Truffle Dust
          icing:   "#d0d1c9", // Icing Mist
        },
      },
      fontFamily: {
        display: ['"Playfair Display"', "serif"],
        sans: ["Inter", "system-ui", "sans-serif"],
      },
      boxShadow: {
        soft: "0 10px 30px rgba(0,0,0,.08)",
      },
      borderRadius: {
        xl2: "1.25rem",
      },
    },
  },
  plugins: [],
}
