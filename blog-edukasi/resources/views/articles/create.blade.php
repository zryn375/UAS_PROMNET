@extends('layouts.app')

@section('title', 'Tulis Artikel Baru - Blog Edukasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Tulis Artikel Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Judul yang menarik akan lebih banyak dibaca</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label">Kategori *</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Teknologi" {{ old('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                <option value="Ilmu Pengetahuan" {{ old('category') == 'Ilmu Pengetahuan' ? 'selected' : '' }}>Ilmu Pengetahuan</option>
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
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="summary" class="form-label">Ringkasan *</label>
                        <textarea class="form-control @error('summary') is-invalid @enderror" 
                                  id="summary" name="summary" rows="3" maxlength="500" required>{{ old('summary') }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal 500 karakter. Ringkasan akan ditampilkan di halaman artikel.</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="form-label">Konten Artikel *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">
                            <small>Tips: Gunakan HTML untuk format (h1, h2, p, strong, em, ul, ol, li, br, hr)</small>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="publish_now" name="publish_now" value="1">
                            <label class="form-check-label" for="publish_now">
                                Publikasikan Sekarang
                            </label>
                        </div>
                        <div class="form-text">Jika tidak dicentang, artikel akan disimpan sebagai draft</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Writing Tips -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips Menulis Artikel Edukasi</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Gunakan bahasa yang mudah dipahami</li>
                    <li>Tambahkan contoh konkret untuk penjelasan</li>
                    <li>Gunakan heading (h2, h3) untuk struktur yang jelas</li>
                    <li>Periksa fakta sebelum dipublikasikan</li>
                    <li>Tambahkan ringkasan di akhir artikel</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple text editor enhancement
    document.getElementById('content').addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            var start = this.selectionStart;
            var end = this.selectionEnd;
            this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
            this.selectionStart = this.selectionEnd = start + 4;
        }
    });
    
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