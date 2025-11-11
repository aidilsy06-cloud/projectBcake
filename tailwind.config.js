import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/**/*.vue',
  ],

  theme: {
    extend: {
      /* =========================
       * Typography
       * ========================= */
      fontFamily: {
        // Body text
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
        // Headings
        display: ['"Playfair Display"', 'serif'],
      },

      /* =========================
       * 🎨 B’cake Design System
       * ========================= */
      colors: {
        bcake: {
          // inti palet
          wine:   '#890524', // alias 'cherry' di bawah
          deep:   '#57091d',
          cocoa:  '#362320', // alias 'bitter' di bawah
          blush:  '#fde2e7',
          cream:  '#fff8f2',
          petal:  '#ffe9f0',
          gold:   '#c7a869',

          // alias/legacy (biar class lama tetap jalan)
          cherry:  '#890524', // = wine
          bitter:  '#362320', // = cocoa
          truffle: '#6a4e4a',
          icing:   '#d0d1c9',
        },
      },

      borderRadius: {
        xl2: '1.25rem', // rounded-xl2
      },

      boxShadow: {
        // besar, lembut (untuk card hero, referensi pink)
        soft: '0 30px 60px rgba(244,63,94,.12)',
        // versi kecil (untuk kartu-kartu grid)
        'soft-sm': '0 8px 24px rgba(54,35,32,0.12)',
      },

      backgroundImage: {
        'bcake-gradient': 'linear-gradient(90deg, #362320, #57091d 40%, #890524)',
        grain: 'radial-gradient(rgba(0,0,0,.04) 1px, transparent 1px)',
      },
      backgroundSize: {
        grain: '12px 12px',
      },

      /* =========================
       * Animations
       * ========================= */
      keyframes: {
        sprinkle: {
          '0%':   { transform: 'translateY(-60px) rotate(0deg)',   opacity: 0 },
          '15%':  { opacity: 1 },
          '100%': { transform: 'translateY(60px) rotate(180deg)',  opacity: 0 },
        },
      },
      animation: {
        sprinkle: 'sprinkle 2.8s ease-in infinite',
      },
    },
  },

  plugins: [forms],
}
