module.exports = {
  purge: ['./resources/views/**/*.blade.php'],
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',

      black: '#000000',
      white: '#ffffff',

      gray: {
        50: '#f9fafb',
        100: '#f4f5f7',
        200: '#e5e7eb',
        // 200: '#ebecf0',
        300: '#d2d6dc',
        400: '#9fa6b2',
        500: '#6b7280',
        600: '#4b5563',
        700: '#374151',
        800: '#252f3f',
        900: '#161e2e'
      },
      'cool-gray': {
        50: '#fbfdfe',
        100: '#f1f5f9',
        200: '#e2e8f0',
        300: '#cfd8e3',
        400: '#97a6ba',
        500: '#64748b',
        600: '#475569',
        700: '#364152',
        800: '#27303f',
        900: '#1a202e'
      },
      red: {
        100: '#fff5f5',
        200: '#fed7d7',
        300: '#feb2b2',
        400: '#fc8181',
        500: '#f56565',
        600: '#e53e3e',
        700: '#c53030',
        800: '#9b2c2c',
        900: '#742a2a'
      },
      yellow: {
        100: '#fffff0',
        200: '#fefcbf',
        300: '#faf089',
        400: '#f6e05e',
        500: '#ecc94b',
        600: '#d69e2e',
        700: '#b7791f',
        800: '#975a16',
        900: '#744210'
      },
      green: {
        100: '#f0fff4',
        200: '#c6f6d5',
        300: '#9ae6b4',
        400: '#68d391',
        500: '#48bb78',
        600: '#38a169',
        700: '#2f855a',
        800: '#276749',
        900: '#22543d'
      },
      blue: {
        100: '#ebf8ff',
        200: '#bee3f8',
        300: '#90cdf4',
        400: '#63b3ed',
        500: '#4299e1',
        600: '#3182ce',
        700: '#2b6cb0',
        800: '#2c5282',
        900: '#2a4365'
      }
    },
    columnCount: [1, 2, 3, 4, 5, 6, 7, 8],
    screens: {
      xs: '420px',
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px'
    },
    extend: {
      fontFamily: {
        sans: [
          'Inter',
          'ui-sans-serif',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          '"Segoe UI"',
          'Roboto',
          '"Helvetica Neue"',
          'Arial',
          '"Noto Sans"',
          'sans-serif'
        ]
      },
      spacing: {
        112: '28rem',
        128: '32rem'
      },
      strokeWidth: { 3: '3' }
    }
  },
  variants: {
    extend: {
        backgroundColor: ['active'],
        borderColor: ['active'],
        ringColor: ['active'],
        ringOpacity: ['active'],
        ringWidth: ['active'],
        textColor: ['active']
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('tailwindcss-multi-column')()
  ],
}
