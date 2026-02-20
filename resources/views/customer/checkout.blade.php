@extends('customer.layouts.master')

@section('content')

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h1 class="mb-4">Detail Pembayaran</h1>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row g-5">

                    <!-- LEFT: Customer Info + Order Items -->
                    <div class="col-md-12 col-lg-7">

                        <!-- Customer Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap <sup class="text-danger">*</sup></label>
                                <input type="text" name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    placeholder="Masukkan nama lengkap" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nomor WhatsApp</label>
                                <input type="text" name="customer_phone" class="form-control"
                                    placeholder="Contoh: 08123456789" value="{{ old('customer_phone') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Catatan Pesanan</label>
                                <textarea name="note" class="form-control" rows="3"
                                    placeholder="Catatan khusus untuk dapur (opsional)">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h4 class="mb-3">Detail Pesanan</h4>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Menu</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item['image_path'] }}" class="img-fluid rounded-circle"
                                                    style="width: 70px; height: 70px; object-fit: cover;"
                                                    alt="{{ $item['name'] }}">
                                            </td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ 'Rp' . number_format($item['price'], 0, ',', '.') }}</td>
                                            <td>{{ $item['qty'] }}</td>
                                            <td class="text-end">
                                                {{ 'Rp' . number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- RIGHT: Payment Summary -->
                    <div class="col-md-12 col-lg-5">
                        <div class="bg-light rounded p-4 sticky-top" style="top: 100px;">

                            <h3 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h3>

                            @if($tableNumber)
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="mb-0">Nomor Meja</h6>
                                    <span>
                                        <a href="{{ url('/menu?table_number=' . $tableNumber) }}"
                                            class="text-decoration-none fw-semibold">
                                            Meja {{ $tableNumber }}
                                        </a>
                                    </span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="mb-0">Subtotal</h6>
                                <span>{{ 'Rp' . number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Pajak (10%)</span>
                                <span class="text-muted">{{ 'Rp' . number_format($tax, 0, ',', '.') }}</span>
                            </div>

                            <div class="border-top border-bottom py-3 mb-4 d-flex justify-content-between">
                                <h5 class="mb-0">Total</h5>
                                <h5 class="mb-0 text-primary">{{ 'Rp' . number_format($total, 0, ',', '.') }}</h5>
                            </div>

                            <!-- Payment Method -->
                            <h6 class="fw-semibold mb-3">Metode Pembayaran</h6>

                            <div class="d-flex gap-3 mb-4">
                                <!-- Cash -->
                                <label for="pay_cash" class="payment-option flex-fill text-center border rounded p-3"
                                    style="cursor: pointer; border-color: #0d6efd !important; background-color: #f0f5ff;">
                                    <input type="radio" name="payment_method" id="pay_cash" value="cash" class="d-none"
                                        checked>
                                    <div class="fs-3 mb-1">💵</div>
                                    <div class="fw-semibold">Tunai</div>
                                    <small class="text-muted">Bayar di kasir</small>
                                </label>

                                <!-- Cashless / E-Wallet -->
                                <label for="pay_ewallet" class="payment-option flex-fill text-center border rounded p-3"
                                    style="cursor: pointer;">
                                    <input type="radio" name="payment_method" id="pay_ewallet" value="e_wallet"
                                        class="d-none">
                                    <div class="fs-3 mb-1">📱</div>
                                    <div class="fw-semibold">Cashless</div>
                                    <small class="text-muted">QRIS / E-Wallet</small>
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-3 text-uppercase fw-semibold">
                                    Konfirmasi Pesanan
                                </button>
                            </div>

                            <div class="mt-3 text-center">
                                <a href="{{ route('cart') }}" class="text-muted small">
                                    <i class="fa fa-arrow-left me-1"></i> Kembali ke Keranjang
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
    <!-- Checkout Page End -->

@endsection

@section('script')
    <script>
        document.querySelectorAll('.payment-option').forEach(label => {
            label.addEventListener('click', function () {
                document.querySelectorAll('.payment-option').forEach(l => {
                    l.style.borderColor = '';
                    l.style.backgroundColor = '';
                });
                this.style.borderColor = '#0d6efd';
                this.style.backgroundColor = '#f0f5ff';
            });
        });
    </script>
@endsection