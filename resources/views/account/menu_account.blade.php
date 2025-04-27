@extends('layouts.app')

@section('main')

<link rel="stylesheet" href="{{ asset('css/style_for_menu_account.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<div class="account-container">
    <div class="account-profile">
        @if (Auth::user()->image)
    <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="profile-pic" alt="Profile Picture">
@endif

        <div class="user-details">
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->email }}</p>
        </div>
        <form method="POST" action="{{ route('account.logout') }}" class="account-card logout-form">
            @csrf
            <button type="submit"> Logout</button>
        </form>
    </div>

    <div class="account-menu-grid">
        <a href="#" class="account-card" id="editProfileBtn">👤 Edit Profile</a>

        
        <a href="{{ route('account.profile') }}" class="account-card">📚 My Subscriptions</a>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <a href="{{ route('admin.dashboard') }}" class="account-card">📊Admin Dashboard</a>
        @else
        <a href="{{ route('books.index') }}" class="account-card">📊 Dashboard</a>
       @endif
        
        </form>
        <div class="edit-profile-form" id="editProfileForm" style="display: none;">
            <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nick Name</label>
                    <input type="text" value="{{ old('name', Auth::user()->name) }}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
        
                    @if (Auth::user()->image)
                        <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="img-fluid mt-4" alt="Profile Image">
                    @endif
                </div>
        
                <button type="submit" class="btn btn-primary mt-2">Update</button>
        
                @if (session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('editProfileBtn').addEventListener('click', function (e) {
        e.preventDefault();
        var form = document.getElementById('editProfileForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>

@endsection
