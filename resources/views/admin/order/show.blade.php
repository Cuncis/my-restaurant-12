@extends('admin.layouts.master')
@section('title', 'Detail Pesanan')

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Detail Pesanan</h3>
            <div>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning text-white me-2">
                    <i class="bi bi-pencil-square me-1"></i> Edit Status
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="row">

            {{-- Order Info --}}
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Informasi Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180">No. Pesanan</th>
                                <td>: <span class="fw-semibold">{{ $order->order_number }}</span></td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>: {{ $order->user->full_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Meja</th>
                                <td>: Meja {{ $order->table_number }}</td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>: {{ $order->note ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>: {{ $order->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Item Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->item->name ?? '-' }}</td>
                                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Summary --}}
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ringkasan Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pajak</span>
                            <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Metode Bayar</span>
                            <span>
                                @if($order->payment_method === 'cash')
                                    <span class="badge bg-light text-dark border">Tunai</span>
                                @elseif($order->payment_method === 'e_wallet')
                                    <span class="badge bg-info text-dark">E-Wallet</span>
                                @else
                                    <span class="badge bg-primary">Midtrans</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status</span>
                            <span>
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status === 'settlement')
                                    <span class="badge bg-success">Settlement</span>
                                @else
                                    <span class="badge bg-info text-dark">Dimasak</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
