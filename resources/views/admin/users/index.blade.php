@extends('adminlte::page')

@section('title', 'Manajemen User')

@section('content_header')
    <h1>Manajemen User</h1>
@stop

@section('content')

{{-- PESAN SUKSES --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}

        <button type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- PESAN ERROR --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}

        <button type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="card">

    {{-- HEADER --}}
    <div class="card-header">

        <h3 class="card-title">
            Daftar User
        </h3>

        <div class="card-tools">

            <a
                href="{{ route('admin.users.create') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-user-plus"></i>
                Tambah User
            </a>

        </div>

    </div>


    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($users as $user)

                    <tr>

                        {{-- NO --}}
                        <td>
                            {{ $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td>
                            {{ $user->name }}
                        </td>

                        {{-- USERNAME --}}
                        <td>
                            {{ $user->username }}
                        </td>

                        {{-- EMAIL --}}
                        <td>
                            {{ $user->email }}
                        </td>

                        {{-- WHATSAPP --}}
                        <td>
                            {{ $user->whatsapp }}
                        </td>

                        {{-- ROLE --}}
                        <td>

                            @if ($user->role === 'admin')

                                <span class="badge badge-danger">
                                    Admin
                                </span>

                            @else

                                <span class="badge badge-primary">
                                    User
                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td>

                            @if ($user->id !== auth()->id())

                                <form
                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>

                                </form>

                            @else

                                <span class="badge badge-secondary">
                                    Akun Anda
                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada user.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@stop
