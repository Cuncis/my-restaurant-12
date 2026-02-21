@extends('admin.layouts.master')
@section('title', 'Edit Status Pesanan')

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Edit Status Pesanan</h3>
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="page-content">
        <section class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pesanan: {{ $order->order_number }}</h4>
                    </div>
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Pelanggan</small>
                                    <p class="mb-0 fw-semibold">{{ $order->user->full_name ?? '-' }}</p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Meja</small>
                                    <p class="mb-0 fw-semibold">Meja {{ $order->table_number }}</p>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-muted">Total</small>
                                    <p class="mb-0 fw-semibold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-muted">Tanggal</small>
                                    <p class="mb-0 fw-semibold">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">Status Pesanan <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                                    <option value="settlement" {{ $order->status === 'settlement' ? 'selected' : '' }}>Settlement</option>
                                    <option value="cooked"     {{ $order->status === 'cooked'     ? 'selected' : '' }}>Dimasak</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Simpan
                                </button>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-light">Batal</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
