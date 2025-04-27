@extends('layouts.app')

@section('main')
<section class="p-3 p-md-4 p-xl-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                <div class="card border border-light-subtle rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h4 class="text-center">Forgot Password</h4>
                                    <p class="text-center text-muted small">Enter your email and we'll send you a link to reset your password.</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('account.sendResetLink') }}" method="POST">

                            @csrf
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}">
                                        <label for="email" class="form-label">Email Address</label>
                                        @error('email')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary py-3" type="submit">Send Reset Link</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                    <a href="{{ route('account.login') }}" class="link-secondary text-decoration-none">Back to login</a>
                                </div>
                            </div>
                        </div>

                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>
</section>
@endsection
