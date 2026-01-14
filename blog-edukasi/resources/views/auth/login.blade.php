@extends('layouts.app')

@section('title', 'Login - Blog Edukasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center"><i class="fas fa-sign-in-alt me-2"></i>Login</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p class="mb-0">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-decoration-none">Daftar disini</a>
                        </p>
                    </div>
                </form>
                
                <!-- Demo Accounts -->
                <div class="mt-4 pt-3 border-top">
                    <h6 class="text-muted mb-2">Akun Demo:</h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="card bg-light mb-2">
                                <div class="card-body p-2">
                                    <small class="d-block"><strong>Admin</strong></small>
                                    <small class="d-block">admin@edublog.test</small>
                                    <small class="d-block">password123</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light mb-2">
                                <div class="card-body p-2">
                                    <small class="d-block"><strong>Author</strong></small>
                                    <small class="d-block">author@edublog.test</small>
                                    <small class="d-block">password123</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection