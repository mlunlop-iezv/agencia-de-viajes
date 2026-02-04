@extends('template.base')

@section('title', 'Gestión de Vacaciones')

@section('content')

<div id="customDeleteModal" class="custom-modal-backdrop">
    <div class="custom-modal-window">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Confirmar eliminación masiva</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body-custom">
            ¿Estás seguro de que deseas eliminar los elementos seleccionados? <br>
            <strong>Advertencia:</strong> Esta acción borrará permanentemente los viajes, sus reservas y los comentarios asociados.
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-cancel" onclick="closeModal()">Cancelar</button>
            <button form="form-delete-group" type="submit" class="btn-save" style="background-color: #dc2626;">Eliminar Definitivamente</button>
        </div>
    </div>
</div>

<div class="container admin-page-wrapper">
    
    <div class="admin-header">
        <h2 class="admin-title">Panel de Administración de Viajes</h2>
        <a href="{{ route('vacacion.create') }}" class="btn-add-new">
            <span>+</span> Nueva Oferta
        </a>
    </div>

    <form id="form-delete-group" action="{{ route('vacacion.delete.group') }}" method="post">
        @csrf
        @method('delete')
        <div class="admin-toolbar">
            <button type="button" class="btn-danger-action" onclick="openModal()">
                🗑 Eliminar seleccionados
            </button>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vacaciones as $vacacion)
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" name="ids[]" value="{{ $vacacion->id }}" class="item-checkbox">
                        </td>
                        <td>#{{ $vacacion->id }}</td>
                        <td style="font-weight: 500; color: var(--text-dark);">{{ $vacacion->titulo }}</td>
                        <td>
                            <span class="tag-pill">{{ $vacacion->tipo->nombre }}</span>
                        </td>
                        <td style="font-weight: 600;">{{ number_format($vacacion->precio, 2) }} €</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('vacacion.show', $vacacion->id) }}" class="btn-sm-action btn-sm-view">Ver</a>
                                <a href="{{ route('vacacion.edit', $vacacion->id) }}" class="btn-sm-action btn-sm-edit">Editar</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    <div class="pagination-wrapper">
        {{ $vacaciones->links() }}
    </div>

</div>

@endsection

@section('scripts')
<script>
    function openModal() {
        const checked = document.querySelectorAll('.item-checkbox:checked').length;
        if(checked === 0) {
            alert("Por favor, selecciona al menos un elemento para eliminar.");
            return;
        }
        document.getElementById('customDeleteModal').classList.add('is-visible');
    }

    function closeModal() {
        document.getElementById('customDeleteModal').classList.remove('is-visible');
    }

    document.getElementById('customDeleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
    });
</script>
@endsection