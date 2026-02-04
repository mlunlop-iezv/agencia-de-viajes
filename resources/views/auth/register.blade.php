@extends('template.base')

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h2 class="auth-title">Crear Cuenta</h2>
            <p class="auth-subtitle">Únete a Brújula de Papel y comienza tu viaje</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nombre Completo</label>
                    <input id="name" type="text" class="form-control-custom @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ej: Juan Pérez">

                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nombre@ejemplo.com">

                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="new-password" placeholder="********">

                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control-custom" 
                           name="password_confirmation" required autocomplete="new-password" placeholder="********">
                </div>

                <button type="submit" class="btn-auth-submit">
                    Registrarse
                </button>

                <div class="auth-footer">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="auth-link">Inicia sesión</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection