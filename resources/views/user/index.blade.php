@extends('template.base')

@section('content')

{{-- Modal Personalizado de Eliminación --}}
<div id="customUserDeleteModal" class="custom-modal-backdrop">
    <div class="custom-modal-window">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Confirmar eliminación</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body-custom">
            ¿Estás seguro de que deseas borrar al usuario <strong id="modal-user-name">XXX</strong>? <br>
            Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-cancel" onclick="closeModal()">Cancelar</button>
            {{-- Botón que envía el formulario oculto --}}
            <button form="form-delete" type="submit" class="btn-danger-custom">Eliminar</button>
        </div>
    </div>
</div>

<div class="container admin-page-wrapper">

    {{-- Header Administración --}}
    <div class="admin-header">
        <h2 class="admin-title">Gestión de Usuarios</h2>
        <a href="{{ route('user.create') }}" class="btn-add-new">
            <span>+</span> Crear Nuevo Usuario
        </a>
    </div>

    {{-- Tabla de Datos --}}
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th style="text-align: center;">Verificado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td style="font-weight: 500; color: var(--text-dark);">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{-- Badges de Rol personalizados --}}
                        @if($user->rol == 'admin') 
                            <span class="status-pill pill-admin">Admin</span>
                        @elseif($user->rol == 'advanced') 
                            <span class="status-pill pill-advanced">Advanced</span>
                        @else 
                            <span class="status-pill pill-user">User</span> 
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($user->hasVerifiedEmail()) 
                            <span class="status-icon-check">✓</span> 
                        @else 
                            <span class="status-icon-cross">✗</span> 
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('user.show', $user->id) }}" class="btn-sm-action btn-sm-view">Ver</a>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn-sm-action btn-sm-edit">Editar</a>
                            
                            {{-- Botón Trigger para JS nativo --}}
                            <button type="button" 
                                    class="btn-sm-action" 
                                    style="background-color: #fee2e2; color: #991b1b; border: none; cursor: pointer;"
                                    onclick="openDeleteModal('{{ $user->name }}', '{{ route('user.destroy', $user->id) }}')">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total usuarios:</th>
                    <th>{{ count($users) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>

</div>

{{-- Formulario Oculto para Eliminación --}}
<form id="form-delete" action="" method="post">
    @csrf
    @method('delete')
</form>

@endsection

@section('scripts')
<script>
    function openDeleteModal(userName, deleteUrl) {
        document.getElementById('modal-user-name').textContent = userName;
        document.getElementById('form-delete').action = deleteUrl;
        document.getElementById('customUserDeleteModal').classList.add('is-visible');
    }

    function closeModal() {
        document.getElementById('customUserDeleteModal').classList.remove('is-visible');
    }

    document.getElementById('customUserDeleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection