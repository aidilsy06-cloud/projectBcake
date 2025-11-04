import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/views/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        // gunakan Poppins untuk body (atau biarkan Figtree kalau mau default Breeze)
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
        // ✅ ini yang bikin utility `font-display`
        display: ['"Playfair Display"', 'serif'],
      },

      /* 🎨 B’cake Design System */
      colors: {
        bcake: {
          bitter:  '#362320',
          wine:    '#57091d',
          cherry:  '#890524',
          truffle: '#6a4e4a',
          icing:   '#d0d1c9',
        },
      },
      borderRadius: {
        xl2: '1.25rem',
      },
      boxShadow: {
        soft: '0 8px 24px rgba(54,35,32,0.12)',
      },
      backgroundImage: {
        'bcake-gradient': 'linear-gradient(90deg, #362320, #57091d 40%, #890524)',
        grain: 'radial-gradient(rgba(0,0,0,.04) 1px, transparent 1px)',
      },
      backgroundSize: {
        grain: '12px 12px',
      },
      keyframes: {
        sprinkle: {
          '0%':   { transform: 'translateY(-60px) rotate(0deg)',  opacity: 0 },
          '15%':  { opacity: 1 },
          '100%': { transform: 'translateY(60px) rotate(180deg)', opacity: 0 },
        },
      },
      animation: {
        sprinkle: 'sprinkle 2.8s ease-in infinite',
      },
    },
  },

  plugins: [forms],
}
