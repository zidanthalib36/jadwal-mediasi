@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Change Password</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">Update Password</h3>
            </div>

            <div class="card-body">

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success ml-2">
                            Password Updated.
                        </span>
                    @endif

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
