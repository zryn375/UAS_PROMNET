@extends('layouts.app')

@section('title', $article->title . ' - Blog Edukasi')

@section('content')
<div class="row">
    <!-- Main Article Content -->
    <div class="col-lg-8">
        <!-- Article Header -->
        <div class="card mb-4">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel</a></li>
                        <li class="breadcrumb-item active">{{ $article->category }}</li>
                    </ol>
                </nav>
                
                <h1 class="card-title display-6">{{ $article->title }}</h1>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold">{{ substr($article->user->name, 0, 1) }}</span>
                        </div>
                        <div class="ms-3">
                            <div class="fw-bold">{{ $article->user->name }}</div>
                            <div class="text-muted small">
                                Dipublikasikan {{ $article->getFormattedPublishedAtAttribute() }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <span class="category-badge">{{ $article->category }}</span>
                        <div class="mt-2">
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-clock me-1"></i>{{ $article->reading_time }}
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-eye me-1"></i>{{ $article->view_count }} views
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($article->cover_image)
                <img src="{{ asset('storage/' . $article->cover_image) }}" class="img-fluid rounded mb-4" alt="{{ $article->title }}">
                @endif
                
                <!-- Article Content -->
                <div class="article-content">
                    {!! $article->content !!}
                </div>
                
                <!-- Article Actions -->
                @auth
                    @if(Auth::id() == $article->user_id || Auth::user()->isAdmin())
                    <div class="mt-4 pt-4 border-top">
                        <div class="btn-group">
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </div>
                    </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- About Author -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Tentang Penulis</h5>
            </div>
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; font-size: 2rem;">
                    <span class="text-white fw-bold">{{ substr($article->user->name, 0, 1) }}</span>
                </div>
                <h5>{{ $article->user->name }}</h5>
                <p class="text-muted small mb-3">{{ $article->user->bio ?? 'Penulis aktif di Blog Edukasi' }}</p>
                <div class="d-flex justify-content-center">
                    <span class="badge bg-info me-2">{{ ucfirst($article->user->role) }}</span>
                    <span class="badge bg-secondary">
                        {{ $article->user->articles()->whereNotNull('published_at')->count() }} Artikel
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Related Articles -->
        @if($relatedArticles->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-link me-2"></i>Artikel Terkait</h5>
            </div>
            <div class="card-body">
                @foreach($relatedArticles as $related)
                <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <h6 class="card-title">
                        <a href="{{ route('articles.show', $related->slug) }}" class="text-decoration-none">
                            {{ Str::limit($related->title, 60) }}
                        </a>
                    </h6>
                    <div class="small text-muted">
                        {{ $related->getFormattedPublishedAtAttribute() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Article Stats -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="display-6 fw-bold">{{ $article->reading_time }}</div>
                        <small class="text-muted">Waktu Baca</small>
                    </div>
                    <div class="col-6">
                        <div class="display-6 fw-bold">{{ $article->view_count }}</div>
                        <small class="text-muted">Dilihat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@auth
    @if(Auth::id() == $article->user_id || Auth::user()->isAdmin())
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus artikel "{{ $article->title }}"?
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
    @endif
@endauth
@endsection

@push('scripts')
<script>
    // Highlight code blocks if any
    document.addEventListener('DOMContentLoaded', function() {
        const preElements = document.querySelectorAll('.article-content pre');
        preElements.forEach(pre => {
            pre.classList.add('bg-light', 'p-3', 'rounded');
        });
    });
</script>
@endpush