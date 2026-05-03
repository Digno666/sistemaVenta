@extends('layouts.encargado-layout')

@section('title', 'Mi Perfil - BODY FIT Encargado')

@section('content')
<div class="perfil-container">
    <div class="page-header">
        <h1 class="page-title">Mi Perfil</h1>
        <p class="page-description">Información personal de tu cuenta</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-content">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="perfil-card">
        <div class="perfil-avatar">
            @if($encargado && $encargado->foto_url)
                <div class="avatar-image">
                    <img src="{{ $encargado->foto_url }}" alt="Foto de perfil">
                </div>
            @else
                <div class="avatar-circle">
                    <span>{{ strtoupper(substr(Auth::user()->name ?? 'EC', 0, 2)) }}</span>
                </div>
            @endif
            <button class="btn-edit-avatar" id="editAvatarBtn" onclick="document.getElementById('foto_input').click();">
                <i class="fas fa-camera"></i>
            </button>
            <input type="file" id="foto_input" style="display: none;" accept="image/*" onchange="uploadPhoto(this)">
        </div>

        <div class="perfil-tabs">
            <button class="tab-btn active" data-tab="info">Información Personal</button>
            <button class="tab-btn" data-tab="edit">Editar Perfil</button>
        </div>

        <!-- Pestaña de Información (Vista) -->
        <div id="tab-info" class="tab-content active">
            <div class="perfil-info">
                <div class="info-group">
                    <label>Nombre de usuario</label>
                    <p>{{ Auth::user()->name ?? 'No registrado' }}</p>
                </div>

                <div class="info-group">
                    <label>Correo electrónico</label>
                    <p>{{ Auth::user()->email ?? 'No registrado' }}</p>
                </div>

                @if($encargado)
                <div class="info-group">
                    <label>Nombre completo</label>
                    <p>{{ $encargado->nombre }} {{ $encargado->apellidoPaterno }} {{ $encargado->apellidoMaterno }}</p>
                </div>

                <div class="info-group">
                    <label>Carnet de Identidad</label>
                    <p>{{ number_format($encargado->carnetIdentidad, 0, '', '.') }}</p>
                </div>

                <div class="info-group">
                    <label>Sexo</label>
                    <p>{{ $encargado->sexo == 'M' ? 'Masculino' : 'Femenino' }}</p>
                </div>

                <div class="info-group">
                    <label>Teléfono</label>
                    <p>{{ $encargado->telefono }}</p>
                </div>
                @else
                <div class="info-group incomplete">
                    <label>Perfil incompleto</label>
                    <p>Debes completar tu información personal</p>
                    <a href="{{ route('encargado.perfil.completar') }}" class="btn-completar">
                        Completar perfil <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Pestaña de Edición (Formulario) -->
        <div id="tab-edit" class="tab-content">
            <form method="POST" action="{{ route('encargado.perfil.update') }}" id="perfilForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="form-section-title">Datos de Cuenta</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nombre de usuario <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" id="name" class="form-control" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo electrónico <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Datos Personales</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <div class="input-icon">
                                <i class="fas fa-mobile-alt"></i>
                                <input type="text" name="telefono" id="telefono" class="form-control" 
                                       value="{{ old('telefono', $encargado->telefono ?? '') }}" placeholder="Ej: 71234567">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Foto de Perfil</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="foto">Cambiar foto</label>
                            <div class="input-icon">
                                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                            </div>
                            <div class="input-help">
                                <i class="fas fa-info-circle"></i> Formatos: JPG, PNG, GIF. Máximo 2MB
                            </div>
                            @if($encargado && $encargado->foto_url)
                                <div class="current-photo">
                                    <img src="{{ $encargado->foto_url }}" alt="Foto actual" class="current-photo-img">
                                    <span class="current-photo-label">Foto actual</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" id="cancelEditBtn">Cancelar</button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .perfil-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .page-description {
        color: #6B7280;
        font-size: 0.9rem;
    }

    .alert-success, .alert-error {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #ECFDF5;
        color: #065F46;
        border-left: 4px solid #10B981;
    }

    .alert-error {
        background: #FEF2F2;
        color: #991B1B;
        border-left: 4px solid #E04545;
    }

    .alert-content ul {
        margin: 8px 0 0 20px;
        font-size: 0.8rem;
    }

    .perfil-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E8ECEF;
    }

    /* Avatar con foto */
    .perfil-avatar {
        position: relative;
        margin-bottom: 24px;
        text-align: center;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #E04545, #c93a3a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .avatar-circle span {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
    }

    .avatar-image {
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }

    .avatar-image img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #E04545;
    }

    .btn-edit-avatar {
        position: absolute;
        bottom: 0;
        right: calc(50% - 50px);
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6B7280;
    }

    .btn-edit-avatar:hover {
        background: #E04545;
        color: white;
        border-color: #E04545;
    }

    .current-photo {
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #F9FAFB;
        border-radius: 12px;
    }

    .current-photo-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .current-photo-label {
        font-size: 0.75rem;
        color: #6B7280;
    }

    .perfil-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        border-bottom: 1px solid #E8ECEF;
        padding-bottom: 12px;
    }

    .tab-btn {
        background: none;
        border: none;
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 20px;
    }

    .tab-btn:hover {
        color: #E04545;
        background: #FEF2F2;
    }

    .tab-btn.active {
        background: #E04545;
        color: white;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .perfil-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-group label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-group p {
        font-size: 1rem;
        font-weight: 500;
        color: #1F2937;
    }

    .info-group.incomplete p {
        color: #E04545;
        margin-bottom: 12px;
    }

    .btn-completar {
        display: inline-block;
        background: #E04545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-completar:hover {
        background: #c93a3a;
        transform: translateY(-1px);
    }

    .form-section {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #F3F4F6;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 16px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        color: #374151;
    }

    .required {
        color: #E04545;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 1rem;
        pointer-events: none;
    }

    input[type="file"].form-control {
        padding: 10px 14px;
        cursor: pointer;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px 10px 42px;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .input-help {
        margin-top: 6px;
        font-size: 0.7rem;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #F3F4F6;
    }

    .btn-cancel {
        background: #F3F4F6;
        color: #4B5563;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #E5E7EB;
    }

    .btn-submit {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #c93a3a;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .perfil-card {
            padding: 24px;
        }
        .perfil-info {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .perfil-tabs {
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.dataset.tab;
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(`tab-${tabId}`).classList.add('active');
        });
    });

    const cancelBtn = document.getElementById('cancelEditBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            document.querySelector('.tab-btn[data-tab="info"]').click();
        });
    }

    // Función para subir foto directamente
    function uploadPhoto(input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('foto', input.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            
            Swal.fire({
                title: 'Subiendo foto...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch('{{ route("encargado.perfil.upload-photo") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonColor: '#E04545'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al subir la foto',
                    confirmButtonColor: '#E04545'
                });
            });
        }
    }
</script>
@endpush
@endsection