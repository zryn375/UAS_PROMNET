@extends('layouts.app')

@section('title', 'Edit Artikel - Blog Edukasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Artikel</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $article->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label">Kategori *</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="Pendidikan" {{ old('category', $article->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Teknologi" {{ old('category', $article->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                <option value="Ilmu Pengetahuan" {{ old('category', $article->category) == 'Ilmu Pengetahuan' ? 'selected' : '' }}>Ilmu Pengetahuan</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cover_image" class="form-label">Gambar Cover</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                   id="cover_image" name="cover_image" accept="image/*">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($article->cover_image)
                            <div class="form-text">
                                Gambar saat ini: {{ basename($article->cover_image) }}
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="summary" class="form-label">Ringkasan *</label>
                        <textarea class="form-control @error('summary') is-invalid @enderror" 
                                  id="summary" name="summary" rows="3" maxlength="500" required>{{ old('summary', $article->summary) }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="form-label">Konten Artikel *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="publish_now" name="publish_now" value="1"
                                           {{ $article->published_at ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publish_now">
                                        {{ $article->published_at ? 'Sudah Dipublikasikan' : 'Publikasikan Sekarang' }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="badge bg-info">
                                    <i class="fas fa-history me-1"></i>
                                    Terakhir diupdate: {{ $article->updated_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <div>
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-eye me-2"></i>Preview
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Artikel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Article Stats -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik Artikel</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                        <div class="display-6 fw-bold">{{ $article->reading_time }}</div>
                        <small class="text-muted">Waktu Baca</small>
                    </div>
                    <div class="col-3">
                        <div class="display-6 fw-bold">{{ $article->view_count }}</div>
                        <small class="text-muted">Views</small>
                    </div>
                    <div class="col-3">
                        <div class="display-6 fw-bold">{{ $article->published_at ? 'Ya' : 'Tidak' }}</div>
                        <small class="text-muted">Dipublikasi</small>
                    </div>
                    <div class="col-3">
                        <div class="display-6 fw-bold">{{ $article->created_at->format('d/m/y') }}</div>
                        <small class="text-muted">Dibuat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Character counter for summary
    const summaryInput = document.getElementById('summary');
    const counter = document.createElement('div');
    counter.className = 'form-text text-end';
    summaryInput.parentNode.appendChild(counter);
    
    function updateCounter() {
        const length = summaryInput.value.length;
        counter.textContent = `${length}/500 karakter`;
        
        if (length > 450) {
            counter.className = 'form-text text-end text-warning';
        } else if (length > 490) {
            counter.className = 'form-text text-end text-danger';
        } else {
            counter.className = 'form-text text-end';
        }
    }
    
    summaryInput.addEventListener('input', updateCounter);
    updateCounter();
</script>
@endpush