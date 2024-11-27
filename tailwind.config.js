/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './vendor/**/*.php'
  ],
  theme: {
    fontFamily: {
      sans: [
        'Montserrat',
        // 'Roboto',
        'sans-serif',
      ],
    },
    extend: {
      colors:{
        'primary' : '#7e246e',
        'secondary' : '#9a256b'
      }
    },
  },
  plugins: [],
}

