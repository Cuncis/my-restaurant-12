@extends('admin.layouts.master')
@section('title', 'Edit Role')

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Edit Role</h3>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Nama Role <span class="text-danger">*</span>
                                </label>
                                <select name="name" id="name" class="form-select @error('name') is-invalid @enderror">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="Admin" {{ old('name', $role->name) == 'Admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="Cashier" {{ old('name', $role->name) == 'Cashier' ? 'selected' : '' }}>
                                        Cashier</option>
                                    <option value="Chef" {{ old('name', $role->name) == 'Chef' ? 'selected' : '' }}>Chef
                                    </option>
                                    <option value="Customer" {{ old('name', $role->name) == 'Customer' ? 'selected' : '' }}>
                                        Customer</option>
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">
                                    Deskripsi <span class="text-danger">*</span>
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $role->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Perbarui
                                </button>
                                <a href="{{ route('roles.index') }}" class="btn btn-light">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection