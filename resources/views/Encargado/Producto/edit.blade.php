@extends('layouts.encargado-layout')

@section('title', 'Editar Producto - BODY FIT Admin')

@section('content')
<div class="form-container">
    <div class="form-header">
        <a href="{{ route('producto.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="form-title">Editar Producto</h1>
        <p class="form-subtitle">Modifica los datos del producto</p>
    </div>

    @if($errors->any())
        <div class="alert-general">
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

    <div class="form-card">
        <form method="POST" action="{{ route('producto.update', $producto->codProducto) }}" enctype="multipart/form-data" id="productoForm">
            @csrf
            @method('PUT')

            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-box"></i>
                    <h3>Datos del Producto</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="codProducto">Código de Producto</label>
                        <div class="input-icon">
                            <i class="fas fa-barcode"></i>
                            <input type="text" class="form-control" value="{{ $producto->codProducto }}" disabled>
                        </div>
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> El código no se puede modificar
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre del Producto <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-tag"></i>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', $producto->nombre) }}" required>
                        </div>
                        @error('nombre')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-align-left"></i>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>
                        @error('descripcion')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="precio">Precio (Bs) <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-dollar-sign"></i>
                            <input type="number" step="0.01" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" 
                                   value="{{ old('precio', $producto->precio) }}" required min="0">
                        </div>
                        @error('precio')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="codCategoria">Categoría <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-tags"></i>
                            <select name="codCategoria" id="codCategoria" class="form-control @error('codCategoria') is-invalid @enderror" required>
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->codCategoria }}" {{ old('codCategoria', $producto->codCategoria) == $categoria->codCategoria ? 'selected' : '' }}>
                                        {{ $categoria->codCategoria }} - {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('codCategoria')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="imagen">Imagen del Producto</label>
                        @if($producto->imagen)
                            <div class="current-image">
                                <img src="{{ $producto->imagen_url }}" alt="Imagen actual" class="current-img">
                                <small class="image-note">Imagen actual</small>
                            </div>
                        @endif
                        <div class="input-icon">
                            <i class="fas fa-image"></i>
                            <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                        </div>
                        @error('imagen')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Formatos: JPG, PNG, GIF. Máximo 2MB. Dejar en blanco para mantener la imagen actual.
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('producto.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-header {
        margin-bottom: 28px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6B7280;
        text-decoration: none;
        font-size: 0.85rem;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #E04545;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 6px;
    }

    .form-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
    }

    .alert-general {
        background: #FEF2F2;
        border-left: 4px solid #E04545;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .alert-general i {
        color: #E04545;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content strong {
        color: #991B1B;
        font-size: 0.85rem;
        display: block;
        margin-bottom: 8px;
    }

    .alert-content ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-content li {
        color: #991B1B;
        font-size: 0.8rem;
        margin: 4px 0;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E8ECEF;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .form-section {
        margin-bottom: 32px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }

    .section-title i {
        font-size: 1.3rem;
        color: #E04545;
    }

    .section-title h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin: 0;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 0.85rem;
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

    .input-icon textarea ~ i {
        top: 18px;
        transform: none;
    }

    .input-icon input[type="file"] ~ i {
        top: 18px;
        transform: none;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1.5px solid #E5E7EB;
        border-radius: 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
        background: white;
    }

    .form-control:disabled {
        background: #F9FAFB;
        color: #6B7280;
        cursor: not-allowed;
    }

    input[type="file"].form-control {
        padding: 10px 14px 10px 42px;
    }

    textarea.form-control {
        padding: 12px 14px 12px 42px;
        resize: vertical;
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .form-control.is-invalid {
        border-color: #E04545;
        background: #FEF2F2;
    }

    .current-image {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .current-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #E5E7EB;
    }

    .image-note {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .error-text {
        display: block;
        margin-top: 6px;
        font-size: 0.75rem;
        color: #E04545;
    }

    .error-text i {
        font-size: 0.7rem;
        margin-right: 4px;
    }

    .input-help {
        margin-top: 8px;
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
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #F3F4F6;
    }

    .btn-cancel {
        background: #F3F4F6;
        color: #4B5563;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
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
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #c93a3a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(224, 69, 69, 0.3);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }
        .form-title {
            font-size: 1.5rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn-cancel, .btn-submit {
            text-align: center;
            justify-content: center;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .current-image {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const form = document.getElementById('productoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const precio = document.getElementById('precio');
            if (precio && parseFloat(precio.value) <= 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Precio inválido',
                    text: 'El precio debe ser mayor a 0.',
                    confirmButtonColor: '#E04545'
                });
                return false;
            }
            return true;
        });
    }
</script>
@endpush
@endsection