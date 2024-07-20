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
    extend: {},
  },
  plugins: [],
}

