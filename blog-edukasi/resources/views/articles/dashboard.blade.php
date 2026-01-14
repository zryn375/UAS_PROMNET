@extends('layouts.app')

@section('title', 'Dashboard Artikel - Blog Edukasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Artikel
    </h2>
    <a href="{{ route('articles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tulis Artikel Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Artikel</h6>
                        <h3 class="mb-0">{{ $articles->total() }}</h3>
                    </div>
                    <i class="fas fa-newspaper fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Dipublikasi</h6>
                        <h3 class="mb-0">{{ Auth::user()->articles()->whereNotNull('published_at')->count() }}</h3>
                    </div>
                    <i class="fas fa-globe fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Views</h6>
                        <h3 class="mb-0">{{ Auth::user()->articles()->sum('view_count') }}</h3>
                    </div>
                    <i class="fas fa-eye fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Draft</h6>
                        <h3 class="mb-0">{{ Auth::user()->articles()->whereNull('published_at')->count() }}</h3>
                    </div>
                    <i class="fas fa-file-alt fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Articles Table -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Daftar Artikel</h5>
    </div>
    <div class="card-body">
        @if($articles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td>
                                <a href="{{ route('articles.show', $article->slug) }}" class="text-decoration-none">
                                    {{ Str::limit($article->title, 50) }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $article->category }}</span>
                            </td>
                            <td>
                                @if($article->published_at)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>{{ $article->view_count }}</td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('articles.show', $article->slug) }}" 
                                       class="btn btn-outline-primary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('articles.edit', $article->id) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $article->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $article->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Hapus artikel "{{ $article->title }}"?
                                                <p class="text-danger small mt-2">Aksi ini tidak dapat dibatalkan!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h4>Belum ada artikel</h4>
                <p class="text-muted">Mulai menulis artikel pertama Anda!</p>
                <a href="{{ route('articles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tulis Artikel
                </a>
            </div>
        @endif
    </div>
</div>
@endsection