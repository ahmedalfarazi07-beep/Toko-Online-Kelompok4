/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'purple-deep': '#0D0A1A',
        'purple-card': '#1A1030',
        'purple-border': '#2D1B4E',
        'accent': '#7C3AED',
        'highlight': '#A855F7',
        'gold': '#F59E0B',
        'success': '#10B981',
        'danger': '#EF4444',
      }
    }
  },
  plugins: [],
}