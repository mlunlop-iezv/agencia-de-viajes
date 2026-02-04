@extends('template.base')

@section('content')
<div class="edit-page-wrapper">
    <div class="edit-card">
        
        <div class="edit-header">
            <h1 class="edit-title">Editar Usuario</h1>
            <p class="edit-subtitle">Modificando perfil de: <strong>{{ $user->name }}</strong></p>
        </div>

        <div class="edit-body">
            <form method="POST" action="{{ route('user.update', $user->id) }}">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name" class="form-label">Nombre Completo</label>
                    <input id="name" type="text" class="form-control-custom @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name', $user->name) }}" required autofocus>
                    
                    @error('name')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email', $user->email) }}" required>
                    
                    @error('email')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" 
                           name="password">
                    <small class="form-hint">Deja este campo vacío si no quieres cambiar la contraseña actual.</small>
                    
                    @error('password')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rol" class="form-label">Rol del Usuario</label>
                    <div style="position: relative;">
                        <select required name="rol" id="rol" class="form-control-custom">
                            @foreach($rols as $rol)
                                <option value="{{ $rol }}" @if($rol == old('rol', $user->rol)) selected @endif>{{ ucfirst($rol) }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6b7280;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Estado de Verificación</label>
                    <label class="toggle-wrapper" for="verified-toggle">
                        <input type="checkbox" id="verified-toggle" name="verified" value="1" class="toggle-input"
                               @if($user->email_verified_at != null) checked @endif>
                        <span class="toggle-slider"></span>
                        <span class="toggle-label-text">Email Verificado</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Guardar Cambios</button>
                    <a href="{{ route('user.index') }}" class="btn-cancel">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection