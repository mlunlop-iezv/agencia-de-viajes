@extends('template.base')

@section('title', 'Editar Oferta')

@section('content')

<div id="customDeleteModal" class="custom-modal-backdrop">
    <div class="custom-modal-window">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Confirmar eliminación</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body-custom">
            ¿Estás completamente seguro de que deseas eliminar la oferta <strong>"{{ $vacacion->titulo }}"</strong>? <br>
            Esta acción es irreversible.
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-cancel" onclick="closeModal()">Cancelar</button>
            <form action="{{ route('vacacion.destroy', $vacacion->id) }}" method="post">
                @csrf 
                @method('delete')
                <button type="submit" class="btn-danger-custom">Eliminar Definitivamente</button>
            </form>
        </div>
    </div>
</div>

<div class="form-page-wrapper">
    <div class="form-card">
        
        <div class="form-header" style="border-left: 5px solid #f59e0b;"> 
            <h1 class="form-title">Editar Oferta</h1>
            <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 0.25rem;">
                Editando: <strong>{{ $vacacion->titulo }}</strong>
            </p>
        </div>

        <div class="form-body">
            <form action="{{ route('vacacion.update', $vacacion->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                
                <div class="form-group">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $vacacion->titulo) }}" class="form-control-custom @error('titulo') is-invalid @enderror" required>
                    @error('titulo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo de Turismo</label>
                    <div style="position: relative;">
                        <select name="idtipo" class="form-control-custom" required>
                            @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('idtipo', $vacacion->idtipo) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6b7280;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">País</label>
                        <input type="text" name="pais" value="{{ old('pais', $vacacion->pais) }}" class="form-control-custom" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" value="{{ old('precio', $vacacion->precio) }}" class="form-control-custom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" rows="5" class="form-control-custom" required>{{ old('descripcion', $vacacion->descripcion) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Añadir Nueva Foto</label>
                    <input type="file" name="imagen" class="form-control-custom file-input-custom" accept="image/*">
                    <small style="color: var(--text-gray); font-size: 0.8rem; display: block; margin-top: 0.5rem;">
                        La foto se añadirá a la galería existente.
                    </small>
                </div>

                @if($vacacion->fotos->count() > 0)
                <div class="form-group">
                    <label class="form-label">Fotos actuales en galería:</label>
                    <div class="gallery-preview-row">
                        @foreach($vacacion->fotos as $foto)
                            <img src="{{ url('storage/' . $foto->ruta) }}" class="gallery-preview-img" alt="Foto galería">
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="form-actions-split">
                    <a href="{{ route('vacacion.index') }}" class="btn-cancel">Volver</a>
                    
                    <div class="actions-group">
                        <button type="button" class="btn-danger-custom" onclick="openModal()">Eliminar</button>
                        <button type="submit" class="btn-submit">Guardar Cambios</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal() {
        document.getElementById('customDeleteModal').classList.add('is-visible');
    }

    function closeModal() {
        document.getElementById('customDeleteModal').classList.remove('is-visible');
    }

    document.getElementById('customDeleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection