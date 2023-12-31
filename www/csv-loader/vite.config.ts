import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@import "@/assets/scss/_reset.scss";
                        @import "@/assets/scss/_variables.scss";
                        @import "@/assets/scss/_mixins.scss";
                        @import "@/assets/scss/_colours.scss";
                        @import "@/assets/scss/_breakpoints.scss";
                        @import "@/assets/scss/_spaces.scss";
                        @import "@/assets/scss/global.scss";`
      }
    }
  },
  server: {
    hmr: {
      host: 'localhost'
    }
  }
})
