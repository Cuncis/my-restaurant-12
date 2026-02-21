@extends('admin.layouts.master')
@section('title', 'Edit Pengguna')

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Edit Pengguna</h3>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label fw-semibold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="full_name" id="full_name"
                                        class="form-control @error('full_name') is-invalid @enderror"
                                        value="{{ old('full_name', $user->full_name) }}">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label fw-semibold">
                                        Username <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="username" id="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username', $user->username) }}">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label fw-semibold">
                                        No. Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        value="{{ old('phone_number', $user->phone_number) }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label fw-semibold">
                                    Role <span class="text-danger">*</span>
                                </label>
                                <select name="role_id" id="role_id"
                                    class="form-select @error('role_id') is-invalid @enderror">
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card bg-light border-0 mb-4 p-3">
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Kosongkan kolom password jika tidak ingin mengubahnya.
                                </p>
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Minimal 8 karakter">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold">
                                            Konfirmasi Password Baru
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Perbarui
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection