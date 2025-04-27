@extends('layouts.app')

@section('main')
<div class="container">
    @include('layouts.message')
    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('account.updatePassword') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Email Address:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label>New Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-success">Reset Password</button>
    </form>
</div>
@endsection
