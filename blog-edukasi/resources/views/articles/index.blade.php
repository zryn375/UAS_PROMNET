@extends('layouts.app')

@section('title', 'Semua Artikel - Blog Edukasi')

@section('content')
<div class="row">
    <!-- Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter</h5>
            </div>
            <div class="card-body">
                <h6>Kategori</h6>
                <div class="list-group">
                    <a href="{{ route('articles.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('articles.index', ['category' => $category]) }}" 
                       class="list-group-item list-group-item-action {{ request('category') == $category ? 'active' : '' }}">
                        {{ $category }}
                    </a>
                    @endforeach
                </div>
                
                <hr>
                
                <h6>Statistik</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-book me-2"></i>Total Artikel: {{ $articles->total() }}</li>
                    <li><i class="fas fa-clock me-2"></i>Waktu Baca Rata-rata: 5 menit</li>
                </ul>
            </div>
        </div>
        
        @auth
            @if(Auth::user()->isAuthor())
            <div class="card mt-3">
                <div class="card-body text-center">
                    <a href="{{ route('articles.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tulis Artikel Baru
                    </a>
                </div>
            </div>
            @endif
        @endauth
    </div>
    
    <!-- Articles List -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                @if(request('category'))
                    Artikel: {{ request('category') }}
                @else
                    Semua Artikel
                @endif
            </h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-sort me-2"></i>Urutkan
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Terbaru</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">Populer</a></li>
                </ul>
            </div>
        </div>
        
        @if($articles->count() > 0)
            <div class="row">
                @foreach($articles as $article)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="category-badge">{{ $article->category }}</span>
                                <small class="text-muted">{{ $article->getFormattedPublishedAtAttribute() }}</small>
                            </div>
                            
                            <h5 class="card-title">{{ Str::limit($article->title, 70) }}</h5>
                            <p class="card-text">{{ Str::limit($article->summary, 120) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $article->user->name }}
                                    </small>
                                    <span class="mx-2">•</span>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>{{ $article->reading_time }}
                                    </small>
                                </div>
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Baca <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h3>Belum ada artikel</h3>
                <p class="text-muted">Artikel akan segera tersedia</p>
                @auth
                    @if(Auth::user()->isAuthor())
                    <a href="{{ route('articles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tulis Artikel Pertama
                    </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection