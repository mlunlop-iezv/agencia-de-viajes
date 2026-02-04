@extends('template.base')

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h2 class="auth-title">Verificar Email</h2>
            <p class="auth-subtitle">Es necesario confirmar tu dirección para continuar</p>
        </div>

        <div class="auth-body">
            
            @if (session('resent'))
                <div class="verification-alert">
                    <svg class="verification-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                    </span>
                </div>
            @endif

            <p class="verification-text">
                {{ __('Antes de continuar, por favor revise su correo electrónico para obtener un enlace de verificación.') }}
            </p>

            <div class="resend-container">
                {{ __('¿No recibiste el correo electrónico?') }}
                <form method="POST" action="{{ route('verification.resend') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-link-action">
                        {{ __('haga clic aquí para solicitar otro') }}
                    </button>.
                </form>
            </div>

        </div>
    </div>
</div>
@endsection