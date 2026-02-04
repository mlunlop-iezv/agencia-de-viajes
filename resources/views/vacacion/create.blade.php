@extends('template.base')

@section('title', 'Crear Oferta')

@section('content')
<div class="form-page-wrapper">
    <div class="form-card">
        
        <div class="form-header">
            <h1 class="form-title">Crear Nueva Oferta de Viaje</h1>
        </div>
        <div class="form-body">
            <form action="{{ route('vacacion.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Título del viaje</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control-custom @error('titulo') is-invalid @enderror" placeholder="Ej: Escapada a París" required>
                    @error('titulo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo de turismo</label>
                    <div style="position: relative;">
                        <select name="idtipo" class="form-control-custom @error('idtipo') is-invalid @enderror" required>
                            <option value="" disabled selected>Seleccione una categoría...</option>
                            @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('idtipo') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6b7280;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    @error('idtipo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">País de destino</label>
                        <input type="text" name="pais" value="{{ old('pais') }}" class="form-control-custom @error('pais') is-invalid @enderror" placeholder="Ej: Francia" required>
                        @error('pais') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" class="form-control-custom @error('precio') is-invalid @enderror" placeholder="0.00" required>
                        @error('precio') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descripción detallada</label>
                    <textarea name="descripcion" rows="5" class="form-control-custom @error('descripcion') is-invalid @enderror" placeholder="Describe la experiencia..." required>{{ old('descripcion') }}</textarea>
                    @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Imagen Principal (Opcional)</label>
                    <input type="file" name="imagen" class="form-control-custom file-input-custom" accept="image/*">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar Oferta</button>
                    <a href="{{ route('vacacion.index') }}" class="btn-cancel">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection