@extends('template.base')

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h2 class="auth-title">{{ __('Restablecer Contraseña') }}</h2>
            <p class="auth-subtitle">Ingresa tu email para recibir un enlace de recuperación</p>
        </div>

        <div class="auth-body">
            
            @if (session('status'))
                <div class="verification-alert" style="margin-bottom: 1.5rem;">
                    <svg class="verification-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nombre@ejemplo.com">

                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-auth-submit">
                    {{ __('Enviar enlace de recuperación') }}
                </button>
                
                <div class="auth-footer">
                    <a href="{{ route('login') }}" class="auth-link">Volver al inicio de sesión</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection