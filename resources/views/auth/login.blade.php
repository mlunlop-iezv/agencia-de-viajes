@extends('template.base')

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h2 class="auth-title">Iniciar Sesión</h2>
            <p class="auth-subtitle">Bienvenido de nuevo a Brújula de Papel</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nombre@ejemplo.com">

                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: baseline;">
                        <label for="password" class="form-label">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a class="auth-link" href="{{ route('password.request') }}" style="font-size: 0.8rem; font-weight: normal;">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password" placeholder="********">

                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="toggle-wrapper" style="font-size: 0.9rem;">
                        <input class="toggle-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} 
                               style="accent-color: var(--primary-color); width: 1rem; height: 1rem; cursor: pointer;">
                        <span style="color: var(--text-dark); margin-left: 0.5rem; cursor: pointer;">Recuérdame</span>
                    </label>
                </div>

                <button type="submit" class="btn-auth-submit">
                    Entrar
                </button>

                <div class="auth-footer">
                    ¿Aún no tienes cuenta? <a href="{{ route('register') }}" class="auth-link">Regístrate gratis</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection