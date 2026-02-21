@extends('admin.layouts.master')
@section('title', 'Edit Menu')

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Edit Menu Makanan</h3>
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
                        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $item->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" min="0"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $item->price) }}">
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
                                                {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
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
                                @if($item->image_path)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($item->image_path) }}"
                                            alt="{{ $item->name }}" id="image-preview"
                                            class="rounded" style="height:120px;object-fit:cover;">
                                        <div class="form-text">Gambar saat ini. Unggah baru untuk menggantinya.</div>
                                    </div>
                                @else
                                    <div class="mb-2" id="image-preview-wrapper" style="display:none;">
                                        <img id="image-preview" src="" alt="Preview"
                                            class="rounded" style="height:120px;object-fit:cover;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="form-control @error('image') is-invalid @enderror"
                                    onchange="previewImage(this)">
                                <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Maks 2MB. Kosongkan jika tidak ingin mengubah.</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_available"
                                        id="is_available" value="1"
                                        {{ old('is_available', $item->is_available) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">Tersedia</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Perbarui
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
            const preview = document.getElementById('image-preview');
            const wrapper = document.getElementById('image-preview-wrapper');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    if (preview) {
                        preview.src = e.target.result;
                        if (wrapper) wrapper.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
