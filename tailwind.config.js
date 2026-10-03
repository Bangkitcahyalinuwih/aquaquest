/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html", // Membaca file HTML di folder utama
    "./src/**/*.{html,js}", // Membaca file di dalam folder src (kalau nanti ada)
    "./node_modules/flowbite/**/*.js" // Wajib ada biar komponen Flowbite terbaca
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin') // Memanggil plugin Flowbite
  ],
}