@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#E04545',
                confirmButtonText: 'Aceptar',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                background: '#ffffff',
                iconColor: '#E04545'
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#E04545',
                confirmButtonText: 'Entendido',
                background: '#ffffff'
            });
        });
    </script>
@endif

@if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: '{{ session('warning') }}',
                confirmButtonColor: '#E04545',
                confirmButtonText: 'Aceptar',
                background: '#ffffff'
            });
        });
    </script>
@endif

@if(session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: '{{ session('info') }}',
                confirmButtonColor: '#E04545',
                confirmButtonText: 'OK',
                background: '#ffffff'
            });
        });
    </script>
@endif