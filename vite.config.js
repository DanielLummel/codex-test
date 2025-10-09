import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "resources/js")
    }
  },
  root: "resources",
  publicDir: "public",
  build: {
    outDir: path.resolve(__dirname, "public/build"),
    emptyOutDir: true
  },
  server: {
    host: "0.0.0.0",
    port: 5173
  }
});
