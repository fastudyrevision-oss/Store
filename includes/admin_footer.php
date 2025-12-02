  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true,
      easing: 'ease-in-out',
    });

    // Theme Toggle
    const toggle = document.getElementById('theme-toggle');
    toggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');
      toggle.classList.toggle('fa-sun');
    });
  </script>
</body>
</html>
