@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">

        {{-- UPDATE PROFILE --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Update Profile</h3>
            </div>
            <div class="card-body">

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
@if ($errors->any())
    <div class="alert alert-danger" style="color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <div class="form-group">
                        <label>WhatsApp</label>
                        <input  type="number" name="whatsapp" required
                               class="form-control"
                               value="{{ old('whatsapp', auth()->user()->whatsapp) }}">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input required type="email" name="email"
                               class="form-control"
                               value="{{ old('email', auth()->user()->email) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-success ml-2">
                            Saved.
                        </span>
                    @endif
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
