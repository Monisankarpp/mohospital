<style>
  .alert-wrapper {
    position: fixed;
    top: 5.5rem;
    right: 1.5rem;
    z-index: 1055;
    width: 100%;
    max-width: 400px;
  }

  .custom-alert {
    animation: slideInRight 0.5s ease-in-out;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    border-left: 5px solid transparent;
    border-radius: 1rem;
  }

  .custom-alert i {
    font-size: 1.5rem;
    margin-right: 1rem;
  }

  @keyframes slideInRight {
    from {
      opacity: 0;
      transform: translateX(100%);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border-left-color: #28a745;
  }

  .alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    border-left-color: #dc3545;
  }

  .alert-info {
    background: linear-gradient(135deg, #d1ecf1, #bee5eb);
    border-left-color: #17a2b8;
  }

  .alert-warning {
    background: linear-gradient(135deg, #fff3cd, #ffeeba);
    border-left-color: #ffc107;
  }
</style>

<div class="alert-wrapper">
  {{-- Success Alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show custom-alert d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-check-circle-fill text-success"></i>
    <div class="flex-grow-1">{{ session('success') }}</div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Error Alert --}}
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show custom-alert d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-x-circle-fill text-danger"></i>
    <div class="flex-grow-1">{{ session('error') }}</div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Info Alert --}}
  @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show custom-alert d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-info-circle-fill text-info"></i>
    <div class="flex-grow-1">{{ session('info') }}</div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Warning Alert --}}
  @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show custom-alert d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
    <div class="flex-grow-1">{{ session('warning') }}</div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
</div>

<script>
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
</script>