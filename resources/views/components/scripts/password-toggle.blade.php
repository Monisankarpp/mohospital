<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle-password]').forEach(group => {
      const input = group.querySelector('input');
      const icon = group.querySelector('i');

      group.addEventListener('click', function () {
        const isVisible = input.type === 'text';
        input.type = isVisible ? 'password' : 'text';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    });
  });
</script>