import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      // Aquí le decimos al plugin exactamente dónde poner el manifest
      manifest: 'public/build/manifest.json',
      buildDirectory: 'build', // carpeta donde irán los assets
    }),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
  build: {
    outDir: 'public/build', // carpeta final de los assets
    emptyOutDir: true,
    rollupOptions: {
      input: {
        app: path.resolve(__dirname, 'resources/js/app.js'),
        style: path.resolve(__dirname, 'resources/css/app.css'),
      },
    },
  },
  server: {
    proxy: {
      '/api': 'https://magictourspv.com/',
    //   '/api': 'http://127.0.0.1:8000/',
    },
  },
});
