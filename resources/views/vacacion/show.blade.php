@extends('template.base')

@section('title', $vacacion->titulo)

@section('content')
<div class="container details-page">
    
    <a href="{{ route('main.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a Ofertas
    </a>

    <div class="details-grid">
        
        <div class="details-content">
            
            <div class="gallery-section">
                @if($vacacion->fotos->count() > 0)
                    <img src="{{ url('storage/' . $vacacion->fotos->first()->ruta) }}" class="main-image" alt="{{ $vacacion->titulo }}">
                    
                    <div class="gallery-thumbs">
                        @foreach($vacacion->fotos as $foto)
                        <a href="{{ url('storage/' . $foto->ruta) }}" target="_blank">
                            <img src="{{ url('storage/' . $foto->ruta) }}" class="thumb-img" alt="Thumbnail">
                        </a>
                        @endforeach
                    </div>
                @else
                    <div style="width: 100%; height: 400px; background: #eee; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #999;">Sin Imagen</div>
                @endif
            </div>

            <div class="content-section">
                <h3 class="section-title">Sobre este viaje</h3>
                <p class="text-content">{{ $vacacion->descripcion }}</p>
            </div>

            <div class="content-section">
                <h3 class="section-title">Opiniones de viajeros ({{ $vacacion->comentarios->count() }})</h3>
                
                <div class="review-list">
                    @if($vacacion->comentarios->count() == 0)
                        <p class="text-content" style="font-style: italic;">Aún no hay opiniones para este viaje.</p>
                    @endif

                    @foreach($vacacion->comentarios as $comentario)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-author">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="color: #cbd5e1;">
                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                                </svg>
                                {{ $comentario->user->name }}
                            </div>
                            <span class="review-date">{{ $comentario->created_at->format('d M Y') }}</span>
                        </div>
                        
                        <div class="stars-display">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $comentario->estrellas ? '' : 'stars-gray' }}">★</span>
                            @endfor
                        </div>

                        <p class="review-text">{{ $comentario->texto }}</p>

                        @auth
                            @if(Auth::user()->id == $comentario->iduser || Auth::user()->isAdmin())
                            <div class="review-actions">
                                <a href="{{ route('comentario.edit', $comentario->id) }}" class="btn-text-action" style="color: #d97706;">Editar</a>
                                <form action="{{ route('comentario.destroy', $comentario->id) }}" method="post" style="display:inline;">
                                    @csrf @method('delete')
                                    <button type="submit" class="btn-text-action" style="color: #dc2626;">Borrar</button>
                                </form>
                            </div>
                            @endif
                        @endauth
                    </div>
                    @endforeach
                </div>

                @auth
                    @if(Auth::user()->tieneReserva($vacacion->id))
                    <div class="comment-form-box">
                        <h4 style="margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600;">Comparte tu experiencia</h4>
                        
                        <form action="{{ route('comentario.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                            
                            <div style="margin-bottom: 0.5rem; font-weight: 600;">Tu valoración:</div>
                            <div class="star-rating-form">
                                <input type="radio" name="estrellas" id="star5" value="5" required><label for="star5" title="Excelente"></label>
                                <input type="radio" name="estrellas" id="star4" value="4"><label for="star4" title="Muy bueno"></label>
                                <input type="radio" name="estrellas" id="star3" value="3"><label for="star3" title="Bueno"></label>
                                <input type="radio" name="estrellas" id="star2" value="2"><label for="star2" title="Regular"></label>
                                <input type="radio" name="estrellas" id="star1" value="1"><label for="star1" title="Malo"></label>
                            </div>

                            <textarea name="texto" class="form-textarea" rows="4" placeholder="¿Qué fue lo que más te gustó del viaje?" required></textarea>
                            <button type="submit" class="btn-submit-comment">Publicar Opinión</button>
                        </form>
                    </div>
                    @endif
                @endauth
            </div>
        </div>

        <div class="details-sidebar">
            <div class="booking-card">
                
                <div class="tags-row">
                    <span class="tag-pill">{{ $vacacion->tipo->nombre }}</span>
                </div>

                <h1 class="booking-title">{{ $vacacion->titulo }}</h1>
                
                <div class="booking-location">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $vacacion->pais }}
                </div>

                <div style="color: #f59e0b; font-size: 0.9rem; margin-bottom: 1rem;">
                    @php
                        $media = $vacacion->comentarios->avg('estrellas') ?? 0;
                        $mediaEntera = round($media);
                    @endphp
                    
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= $mediaEntera ? '#f59e0b' : '#cbd5e1' }}">★</span>
                    @endfor
                    
                    <span style="color: #6b7280; margin-left: 5px;">
                        ({{ number_format($media, 1) }}/5 - {{ $vacacion->comentarios->count() }} opiniones)
                    </span>
                </div>

                <div class="booking-price-section">
                    <div style="display: flex; align-items: baseline; margin-bottom: 1.5rem;">
                        <span class="price-big">{{ number_format($vacacion->precio, 0) }}€</span>
                    </div>

                    @auth
                        @if(Auth::user()->hasVerifiedEmail())
                            @if(!Auth::user()->tieneReserva($vacacion->id))
                                <form action="{{ route('reserva.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                                    <button type="submit" class="btn-reserve-lg">¡Reservar ahora!</button>
                                </form>
                                <div style="text-align: center; color: #6b7280; font-size: 0.8rem;">Sin cargos hasta la confirmación</div>
                            @else
                                <div class="booking-alert info">
                                    ✓ Ya tienes una reserva confirmada.
                                </div>
                            @endif
                        @else
                            <div class="booking-alert warning">
                                Verifica tu email para reservar. <br>
                                <a href="{{ route('verification.notice') }}" style="text-decoration: underline;">Reenviar correo</a>
                            </div>
                        @endif
                    @else
                        <div class="booking-login-prompt">
                            <a href="{{ route('login') }}" class="link-accent">Inicia sesión</a> para reservar este viaje.
                        </div>
                    @endauth
                </div>

                <div class="secure-info">
                    <span class="secure-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#10b981;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pago seguro
                    </span>
                    <span class="secure-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#10b981;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Mejor precio
                    </span>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection