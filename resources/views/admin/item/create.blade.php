@extends('admin.layouts.master')
@section('title', 'Tambah Menu')

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Tambah Menu Makanan</h3>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Contoh: Nasi Goreng Spesial">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Deskripsi singkat menu...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" min="0"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}" placeholder="0">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">Gambar</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="form-control @error('image') is-invalid @enderror"
                                    onchange="previewImage(this)">
                                <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2" id="image-preview-wrapper" style="display:none;">
                                    <img id="image-preview" src="" alt="Preview"
                                        class="rounded" style="height:120px;object-fit:cover;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_available"
                                        id="is_available" value="1"
                                        {{ old('is_available', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">Tersedia</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('items.index') }}" class="btn btn-light">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        function previewImage(input) {
            const wrapper = document.getElementById('image-preview-wrapper');
            const preview = document.getElementById('image-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    wrapper.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                wrapper.style.display = 'none';
            }
        }
    </script>
@endsection
