@extends('layouts.app')

@section('title', 'Register - Blog Edukasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0 text-center"><i class="fas fa-user-plus me-2"></i>Registrasi</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
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
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#" class="text-decoration-none">syarat dan ketentuan</a>
                        </label>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p class="mb-0">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-decoration-none">Login disini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="text-center text-muted">Dengan mendaftar, Anda dapat:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Membaca artikel lengkap</li>
                    <li><i class="fas fa-check text-success me-2"></i>Menyimpan artikel favorit</li>
                    <li><i class="fas fa-check text-success me-2"></i>Berkomentar pada artikel</li>
                    <li><i class="fas fa-check text-success me-2"></i>Mendapatkan notifikasi terbaru</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection