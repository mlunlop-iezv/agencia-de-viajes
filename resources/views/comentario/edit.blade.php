@extends('template.base')

@section('title', 'Editar Comentario')

@section('content')
<div class="form-page-wrapper">
    <div class="form-card">
        
        <div class="form-header" style="border-left: 5px solid #f59e0b;">
            <h1 class="form-title">Editar Comentario</h1>
            <p class="edit-subtitle">
                Sobre el viaje: <strong>{{ $comentario->vacacion->titulo }}</strong>
            </p>
        </div>

        <div class="form-body">
            <form action="{{ route('comentario.update', $comentario->id) }}" method="post">
                @csrf
                @method('put')

                <input type="hidden" name="idvacacion" value="{{ $comentario->idvacacion }}">

                <div class="form-group">
                    <label class="form-label">Tu valoración:</label>
                    <div class="star-rating-form">
                        <input type="radio" name="estrellas" id="star5" value="5" {{ old('estrellas', $comentario->estrellas) == 5 ? 'checked' : '' }} required>
                        <label for="star5" title="Excelente"></label>
                        
                        <input type="radio" name="estrellas" id="star4" value="4" {{ old('estrellas', $comentario->estrellas) == 4 ? 'checked' : '' }}>
                        <label for="star4" title="Muy bueno"></label>
                        
                        <input type="radio" name="estrellas" id="star3" value="3" {{ old('estrellas', $comentario->estrellas) == 3 ? 'checked' : '' }}>
                        <label for="star3" title="Bueno"></label>
                        
                        <input type="radio" name="estrellas" id="star2" value="2" {{ old('estrellas', $comentario->estrellas) == 2 ? 'checked' : '' }}>
                        <label for="star2" title="Regular"></label>
                        
                        <input type="radio" name="estrellas" id="star1" value="1" {{ old('estrellas', $comentario->estrellas) == 1 ? 'checked' : '' }}>
                        <label for="star1" title="Malo"></label>
                    </div>
                    @error('estrellas')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tu opinión</label>
                    <textarea name="texto" class="form-control-custom" rows="5" required>{{ old('texto', $comentario->texto) }}</textarea>
                    
                    @error('texto')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Actualizar Comentario</button>
                    <a href="{{ route('vacacion.show', $comentario->idvacacion) }}" class="btn-cancel">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection