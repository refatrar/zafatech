/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./index.html', './js/**/*.js'],
  theme: {
    screens: {
      xs: '400px',
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
      '2xl': '1440px',
    },
    extend: {
      colors: {
        brand: {
          50: '#EEF3FF',
          100: '#DCE6FF',
          200: '#B9CCFE',
          300: '#8AA8FA',
          400: '#557CF2',
          500: '#2F5CE6',
          600: '#1D4ED8', // fleur-de-lis royal blue — primary
          700: '#1A3FB3',
          800: '#16348F',
        },
        navy: {
          700: '#13306A',
          800: '#0F2757',
          900: '#0A1F44', // shop-front navy — secondary
          950: '#06142E',
        },
        crimson: {
          50: '#FFF0F3',
          100: '#FFE4EA',
          400: '#F0476F',
          500: '#D6204E', // wordmark crimson — accent
          600: '#B5173F',
        },
        signal: '#22D3EE',
        paper: '#F5F7FC',
        line: '#E3E8F2',
        ink: '#0B1733',
        muted: '#52607A',
      },
      fontFamily: {
        display: ['"Bricolage Grotesque"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'monospace'],
        brand: ['Cinzel', 'Georgia', 'serif'],
      },
      maxWidth: {
        site: '1320px',
      },
      boxShadow: {
        soft: '0 1px 2px rgba(11,23,51,.04), 0 8px 24px -8px rgba(11,23,51,.10)',
        lift: '0 2px 4px rgba(11,23,51,.05), 0 24px 48px -16px rgba(29,78,216,.28)',
        glow: '0 0 0 1px rgba(34,211,238,.25), 0 0 40px -8px rgba(34,211,238,.45)',
      },
      borderRadius: {
        '4xl': '2rem',
      },
    },
  },
  plugins: [],
};
