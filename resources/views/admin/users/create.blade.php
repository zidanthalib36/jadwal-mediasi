@extends('adminlte::page')

@section('title', 'Tambah User')

@section('content_header')
    <h1>Tambah User</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Form Tambah User
        </h3>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">

        @csrf

        <div class="card-body">

            {{-- NAMA --}}
            <div class="form-group">
                <label for="name">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    required
                >

                @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>


            {{-- EMAIL --}}
            <div class="form-group">
                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
                >

                @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- USERNAME --}}
<div class="form-group">
    <label for="username">
        Username
    </label>

    <input
        type="text"
        name="username"
        id="username"
        class="form-control @error('username') is-invalid @enderror"
        value="{{ old('username') }}"
        placeholder="Masukkan username"
        required
    >

    @error('username')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

            {{-- WHATSAPP --}}
            <div class="form-group">
                <label for="whatsapp">
                    WhatsApp Number
                </label>

                <input
                    type="number"
                    name="whatsapp"
                    id="whatsapp"
                    class="form-control @error('whatsapp') is-invalid @enderror"
                    placeholder="Contoh: 6289xxxxxxxx"
                    value="{{ old('whatsapp') }}"
                    required
                >

                @error('whatsapp')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>




            {{-- PASSWORD --}}
            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >

                @error('password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>


            {{-- KONFIRMASI PASSWORD --}}
            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    required
                >
            </div>

        </div>


        <div class="card-footer">

            <a
                href="{{ route('admin.users.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan User
            </button>

        </div>

    </form>

</div>

@stop
