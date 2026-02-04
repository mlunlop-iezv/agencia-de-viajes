@extends('template.base')

@section('content')
<div class="edit-page-wrapper">
    <div class="edit-card">
        
        <div class="edit-header">
            <h1 class="edit-title">Editar mi perfil</h1>
            <p class="edit-subtitle">Actualiza tu información personal y seguridad</p>
        </div>

        <div class="edit-body">
            <form method="POST" action="{{ route('home.update') }}">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" type="text" class="form-control-custom @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    
                    @error('name')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    
                    @error('email')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                    
                    <small class="form-hint">Nota: Si cambias tu email, deberás verificarlo de nuevo para acceder a todas las funciones.</small>
                </div>

                <div class="form-section-divider">
                    <span>Seguridad (Opcional)</span>
                </div>

                <div class="form-group">
                    <label for="current-password" class="form-label">Contraseña Actual</label>
                    <input id="current-password" type="password" class="form-control-custom @error('current-password') is-invalid @enderror" 
                           name="current-password" placeholder="Necesaria para establecer una nueva contraseña">
                    
                    @error('current-password')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" 
                           name="password">
                    
                    @error('password')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirmar Nueva Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control-custom" 
                           name="password_confirmation">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Guardar Cambios</button>
                    <a href="{{ route('home') }}" class="btn-cancel">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection