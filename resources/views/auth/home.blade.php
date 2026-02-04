@extends('template.base')

@section('content')
<div class="container profile-page">

    @if (session('status'))
        <div class="flash-message">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="dashboard-grid">
        
        <aside class="profile-card">
            <div class="profile-avatar-placeholder">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            
            <h3 class="profile-name">{{ Auth::user()->name }}</h3>
            <p class="profile-email">{{ Auth::user()->email }}</p>

            <div class="profile-stats">
                <div class="stat-row">
                    <span class="stat-label">Rol</span>
                    @if(Auth::user()->rol == 'admin') 
                        <span class="status-pill pill-admin">Admin</span>
                    @else 
                        <span class="status-pill pill-user">Viajero</span> 
                    @endif
                </div>
                
                <div class="stat-row">
                    <span class="stat-label">Estado Email</span>
                    @if(Auth::user()->hasVerifiedEmail())
                        <span class="status-pill pill-success">Verificado</span>
                    @else
                        <span class="status-pill pill-warning">Pendiente</span>
                    @endif
                </div>

                <div class="stat-row">
                    <span class="stat-label">Miembro desde</span>
                    <span style="font-weight: 600;">{{ Auth::user()->created_at->format('Y') }}</span>
                </div>
            </div>

            <a href="{{ route('home.edit') }}" class="btn-dashboard-action">Editar Perfil</a>
        </aside>

        <section class="dashboard-content">
            <h2>Mis Reservas Confirmadas</h2>

            @if(isset($user) && $user->reservas->count() > 0)
                <div class="reservations-list">
                    @foreach($user->reservas as $reserva)
                    <div class="reservation-item">
                        <div class="res-info">
                            <a href="{{ route('vacacion.show', $reserva->idvacacion) }}" class="res-title">
                                {{ $reserva->vacacion->titulo }}
                            </a>
                            <div class="res-meta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Reservado el: {{ $reserva->created_at->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="res-actions">
                            <span class="res-price">{{ number_format($reserva->vacacion->precio, 0) }} €</span>
                            
                            <a href="{{ route('vacacion.show', $reserva->idvacacion) }}" class="btn-icon-view" title="Ver viaje">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <form action="{{ route('reserva.destroy', $reserva->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar esta reserva?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-cancel">Cancelar</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-reservations">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" style="margin-bottom: 1rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p>No tienes reservas confirmadas actualmente.</p>
                    <a href="{{ route('main.index') }}" style="color: var(--primary-color); font-weight: 600; margin-top: 0.5rem; display: inline-block;">Explorar ofertas</a>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection