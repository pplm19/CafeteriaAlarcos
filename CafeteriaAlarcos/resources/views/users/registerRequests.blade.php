@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js', 'resources/js/disabledUserModal.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Solicitudes de registro</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <th scope="col" class="text-center align-middle">Nombre de usuario</th>
                    <th scope="col" class="text-center align-middle">Email</th>
                    <th scope="col" class="text-center align-middle">Nombre</th>
                    <th scope="col" class="text-center align-middle">Apellido</th>
                    <th scope="col" class="text-center align-middle">Teléfono</th>
                    <th scope="col" class="text-center align-middle w-10">Acciones</th>
                </thead>

                <tbody>
                    @if (count($users) === 0)
                        <tr>
                            <td colspan="6" class="text-center">
                                No se ha encontrado ningún usuario pendiente de verificación
                            </td>
                        </tr>
                    @else
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user['username'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>@ifNull($user['lastname'])</td>
                                <td>@ifNull($user['phone'])</td>
                                <td class="d-flex justify-content-center flex-wrap gap-2">
                                    @if ($user['disabled'])
                                        <form action="{{ route('users.toggleDisable') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-toggle-on"></i> Habilitar
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.accept', $user['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle"></i> Aceptar
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-disable-user"
                                            data-bs-toggle="modal" data-bs-target="#declineModal"
                                            data-user-id="{{ $user['id'] }}">
                                            <i class="bi bi-x-circle"></i> Rechazar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $users->links() }}
        </div>

        <div class="modal fade" id="declineModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="declineModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="declineModalLabel">Motivo de rechazo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('users.toggleDisable') }}" method="POST" class="needs-validation m-0"
                        novalidate>
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="user_id">
                            <textarea type="text" name="disable_reason" id="disable_reason"
                                class="form-control @error('disable_reason') is-invalid @enderror"
                                placeholder="Tu cuenta ha sido rechazada, contacta con un administrador para obtener más información"
                                maxlength="255" style="resize: none"></textarea>

                            @error('disable_reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-theme">Rechazar usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
