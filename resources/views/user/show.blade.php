@extends('template.base')

@section('content')
<div class="show-page-wrapper">
    <div class="show-card">
        
        <div class="show-header">
            <h1 class="show-title">Detalle Usuario #{{ $user->id }}</h1>
        </div>

        <div class="show-body">
            
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nombre</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Rol</span>
                    <span class="info-value">
                        @if($user->rol == 'admin') 
                            <span class="status-pill pill-admin">Admin</span>
                        @elseif($user->rol == 'advanced') 
                            <span class="status-pill pill-advanced">Advanced</span>
                        @else 
                            <span class="status-pill pill-user">User</span> 
                        @endif
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Fecha Registro</span>
                    <span class="info-value">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="list-section">
                <h3 class="list-title">Reservas realizadas ({{ $user->reservas->count() }})</h3>
                
                @if($user->reservas->count() > 0)
                    <ul class="custom-list">
                        @foreach($user->reservas as $reserva)
                        <li class="custom-list-item">
                            <svg class="list-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <div>
                                <span style="font-weight: 600; color: var(--text-dark);">Reserva #{{ $reserva->id }}</span>
                                <span style="color: var(--text-gray); margin: 0 0.5rem;">en</span>
                                <strong style="color: var(--primary-color);">{{ $reserva->vacacion->titulo }}</strong>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="empty-state">
                        Este usuario no ha realizado ninguna reserva todavía.
                    </div>
                @endif
            </div>

            <a href="{{ route('user.index') }}" class="btn-back">← Volver al listado</a>
        </div>
    </div>
</div>
@endsection