@extends('customer.layouts.master')

@section('content')

    <!-- Order Success Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center mb-5">
                    <div class="text-success mb-3" style="font-size: 5rem;">✅</div>
                    <h2 class="fw-bold">Pesanan Berhasil!</h2>
                    <p class="text-muted">Terima kasih, <strong>{{ $order->user->full_name }}</strong>.
                        Pesanan Anda sedang diproses.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Nomor Pesanan</p>
                                    <h6 class="fw-bold">{{ $order->order_number }}</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-1 small">Nomor Meja</p>
                                    <h6 class="fw-bold">
                                        <a href="{{ url('/menu?table_number=' . $order->table_number) }}"
                                            class="text-decoration-none">
                                            Meja {{ $order->table_number }}
                                        </a>
                                    </h6>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Metode Pembayaran</p>
                                    <span
                                        class="badge {{ $order->payment_method === 'cash' ? 'bg-success' : 'bg-info' }} fs-6">
                                        {{ $order->payment_method === 'cash' ? '💵 Tunai' : '📱 Cashless' }}
                                    </span>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-1 small">Status</p>
                                    <span class="badge bg-warning text-dark fs-6">⏳ Pending</span>
                                </div>
                            </div>

                            @if ($order->note)
                                <div class="alert alert-light border mb-4">
                                    <small class="text-muted">Catatan:</small>
                                    <p class="mb-0">{{ $order->note }}</p>
                                </div>
                            @endif

                            <h6 class="fw-semibold mb-3">Item Pesanan</h6>
                            <table class="table align-middle mb-4">
                                <tbody>
                                    @foreach ($order->orderItems as $orderItem)
                                        <tr>
                                            <td>
                                                <img src="{{ $orderItem->item->image_path }}" class="rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                    alt="{{ $orderItem->item->name }}">
                                            </td>
                                            <td>{{ $orderItem->item->name }}</td>
                                            <td class="text-muted">× {{ $orderItem->quantity }}</td>
                                            <td class="text-end">
                                                {{ 'Rp' . number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Subtotal</span>
                                    <span>{{ 'Rp' . number_format($order->subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Pajak (10%)</span>
                                    <span>{{ 'Rp' . number_format($order->tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0">Total</h5>
                                    <h5 class="mb-0 text-primary">
                                        {{ 'Rp' . number_format($order->grand_total, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-4">
                        @if (!empty($snapToken))
                            <button id="pay-button" class="btn btn-success px-5 py-3 me-2">
                                <i class="fa fa-credit-card me-2"></i> Bayar Sekarang
                            </button>
                        @endif
                        <a href="{{ route('menu') }}" class="btn btn-primary px-5 py-3">
                            <i class="fa fa-utensils me-2"></i> Kembali ke Menu
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Order Success Page End -->

@endsection

@if (!empty($snapToken))
    @section('script')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.getElementById('pay-button').addEventListener('click', function () {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function (result) {
                        window.location.href = '{{ route('menu') }}';
                    },
                    onPending: function (result) {
                        console.log('Payment pending', result);
                    },
                    onError: function (result) {
                        alert('Pembayaran gagal, silakan coba lagi.');
                        console.error('Payment error', result);
                    },
                    onClose: function () {
                        console.log('Payment popup closed without finishing.');
                    }
                });
            });
        </script>
    @endsection
@endif