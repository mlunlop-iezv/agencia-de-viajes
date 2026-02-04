@extends('template.base')

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h2 class="auth-title">Cambiar Contraseña</h2>
            <p class="auth-subtitle">Introduce tu nueva contraseña segura</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control-custom" 
                           name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn-auth-submit">
                    Restablecer Contraseña
                </button>

            </form>
        </div>
    </div>
</div>
@endsection