@extends('template.base')

@section('title', 'Ofertas de Viaje')

@section('content')

<div class="hero-section">
    <h1 class="hero-title">Descubre tu próxima aventura</h1>
    <p class="hero-subtitle">Viajes únicos diseñados para exploradores. Desde playas paradisíacas hasta cumbres nevadas.</p>
</div>

<div class="container">
    <div class="filter-bar-container">
        <form action="{{ route('main.index') }}" method="get" class="filter-form">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif

            <div class="filter-group">
                <label class="filter-label">Tipo</label>
                <select name="idtipo" class="filter-select">
                    <option value="" @if($idtipo==null) selected @endif>Todos</option>
                    @foreach($tipos as $id => $nombre)
                    <option value="{{ $id }}" @if($id==$idtipo) selected @endif>{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Precio Mín</label>
                <input type="number" name="precioMin" value="{{ $precioMin }}" class="filter-input" placeholder="0 €">
            </div>

            <div class="filter-group">
                <label class="filter-label">Precio Máx</label>
                <input type="number" name="precioMax" value="{{ $precioMax }}" class="filter-input" placeholder="5000 €">
            </div>

            <div class="filter-group">
                <label class="filter-label">Ordenar</label>
                <select name="orden_combinado" class="filter-select" onchange="this.form.submit()">
                    <option value="">Destacados</option>
                    <option value="precio_asc" @if(request('campo')=='precio' && request('orden')=='asc') selected @endif>Precio: Bajo a Alto</option>
                    <option value="precio_desc" @if(request('campo')=='precio' && request('orden')=='desc') selected @endif>Precio: Alto a Bajo</option>
                    <option value="pais_asc" @if(request('campo')=='pais') selected @endif>Destino (A-Z)</option>
                </select>
                @if(request('campo') && !request('orden_combinado'))
                    <input type="hidden" name="campo" value="{{ request('campo') }}">
                    <input type="hidden" name="orden" value="{{ request('orden') }}">
                @endif
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">Buscar</button>
                @if($precioMin || $precioMax || $idtipo || $q)
                    <a href="{{ route('main.index') }}" class="btn-clear">Limpiar</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="container main-content">
    
    @if($vacaciones->count() == 0)
        <div class="alert alert-warning" style="text-align: center; margin-top: 2rem;">
            No se encontraron viajes con estos criterios de búsqueda.
        </div>
    @endif

    <div class="cards-grid">
        @foreach($vacaciones as $vacacion)
        <div class="travel-card">
            <div class="card-image-wrapper">
                <img src="{{ $vacacion->getPrimeraFoto() }}" class="card-img" alt="{{ $vacacion->titulo }}">
                
                <div class="card-badges">
                    <span class="badge badge-type">{{ $vacacion->tipo->nombre }}</span>
                </div>
            </div>
            
            <div class="card-content">
                <h2 class="card-title">{{ $vacacion->titulo }}</h2>
                
                <div class="card-location">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $vacacion->pais }}</span>
                </div>

                <div class="card-rating" style="margin-top: 0.5rem; margin-bottom: 0.5rem; display: flex; align-items: center; font-size: 0.9rem;">
                    @php
                        $media = $vacacion->comentarios->avg('estrellas') ?? 0;
                        $mediaEntera = round($media);
                        $count = $vacacion->comentarios->count();
                    @endphp
                    
                    <span style="margin-right: 5px; color: #f59e0b; font-weight: bold;">{{ number_format($media, 1) }}</span>
                    
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= $mediaEntera ? '#f59e0b' : '#cbd5e1' }}">★</span>
                    @endfor
                    
                    <span style="color: #6b7280; font-size: 0.8rem; margin-left: 5px;">({{ $count }})</span>
                </div>

                <p class="card-desc">{{ Str::limit($vacacion->descripcion, 80) }}</p>
                
                <div class="card-footer">
                    <div class="price-container">
                        <span class="price-current">{{ number_format($vacacion->precio, 0) }}€</span>
                    </div>
                    <a href="{{ route('vacacion.show', $vacacion->id) }}" class="btn-details">Ver Detalles</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

<div class="pagination-wrapper">
    {{ $vacaciones->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>
</div>
@endsection