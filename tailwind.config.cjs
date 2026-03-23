module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue", // si usas Vue
    "./resources/**/*.css",
    "./resources/**/admin/**/*.vue", 
  ],
  theme: {
     container: {
      padding: {
        DEFAULT: '1rem',
        sm: '2rem',
        lg: '4rem',
        xl: '5rem',
        '2xl': '6rem',
      },
    },
    extend: {
        keyframes: {
          slideInLeft: {
            '0%': { transform: 'translateX(-50%)', opacity: '0' },
            '100%': { transform: 'translateX(0)', opacity: '1' },
          },
          slideInRight: {
            '0%': { transform: 'translateX(50%)', opacity: '0' },
            '100%': { transform: 'translateX(0)', opacity: '1' },
          },
        },
        animation: {
          slideInLeft: 'slideInLeft 0.8s ease-out forwards',
          slideInRight: 'slideInRight 0.8s ease-out forwards',
        },
        screens: {
        xs: '360px', // pantallas pequeñas
        // Small screens / Mobile
        mobile: '0px',       // opcional, representa todos los móviles
        sm: '640px',         // tablets pequeñas en orientación vertical

        // Medium screens / Tablets
        tablet: '768px',     // tablets grandes / laptops pequeños
        md: '768px',         // valor estándar de Tailwind, puedes usarlo como alias

        // Large screens / Desktop
        desktop: '1024px',   // laptops y desktops
        lg: '1024px',        // valor estándar Tailwind

        // Extra large / Large desktops
        xl: '1280px',        // desktops grandes
        '2xl': '1536px',     // pantallas muy grandes
      },
        listStyleType: {
            circle: 'circle',
        },
        colors: {

            primary: '#063971', // azul
            blue: {
                100: '#0A65C7',
            },
            brandBlue: {
                100: '#0A65C7',
                200: '#00B8D4', //Da un look premium y resalta perfecto en negro.
                300: '#3A8DFF', //Se ve moderno, brillante y profesional.
                400: '#00A8E8', //Sutil pero con mucho estilo.
                500: '#063971',
                600: '#4C6FFF', //Más sobrio, pero igual llamativo y refinado.
            }
        },
        fontSize: {
            h1: ['2.5rem', { lineHeight: '1.2', fontWeight: '700' }], // ≈ 40px
            h2: ['2rem', { lineHeight: '1.3', fontWeight: '600' }],   // ≈ 32px
            h3: ['1.2rem', { lineHeight: '1.4', fontWeight: '500' }], // ≈ 24px
      },
    },
  },
  safelist: [
    'list-disc'
  ],
  plugins: [],
};
