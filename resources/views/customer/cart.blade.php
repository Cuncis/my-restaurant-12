@extends('customer.layouts.master')

@section('content')

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (empty($cart))
                <div class="alert alert-info text-center" role="alert">
                    Keranjang Anda kosong. <a href="{{ route('menu') }}" class="alert-link">Kembali ke Menu</a>
                </div>
            @else
                @php
                    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
                    $tax = $subtotal * 0.1;
                    $total = $subtotal + $tax;
                @endphp

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Gambar</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $id => $item)
                                <tr data-id="{{ $id }}">
                                    <td>
                                        <img src="{{ $item['image_path'] }}" class="img-fluid rounded-circle"
                                            style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $item['name'] }}">
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ 'Rp' . number_format($item['price'], 0, ',', '.') }}</td>
                                    <td>
                                        <div class="input-group quantity" style="width: 110px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="number" class="form-control form-control-sm text-center border-0 qty-input"
                                                value="{{ $item['qty'] }}" min="1">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="item-subtotal">
                                        {{ 'Rp' . number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-md rounded-circle bg-light border">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end mt-1">
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h2 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h2>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal</h5>
                                    <p class="mb-0" id="summary-subtotal">
                                        {{ 'Rp' . number_format($subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0 me-4">Pajak (10%)</p>
                                    <p class="mb-0" id="summary-tax">
                                        {{ 'Rp' . number_format($tax, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top d-flex justify-content-between">
                                <h4 class="mb-0 ps-4 me-4">Total</h4>
                                <h5 class="mb-0 pe-4" id="summary-total">
                                    {{ 'Rp' . number_format($total, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('checkout') }}" class="btn border-secondary py-3 text-primary text-uppercase">
                                Lanjut ke Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- Cart Page End -->

@endsection

@section('script')
    <script>
        document.querySelectorAll('tr[data-id]').forEach(row => {
            const id = row.dataset.id;
            const input = row.querySelector('.qty-input');
            const subtotal = row.querySelector('.item-subtotal');

            function getPrice() {
                const priceText = row.querySelector('td:nth-child(3)').innerText;
                return parseInt(priceText.replace(/[^0-9]/g, ''));
            }

            function updateRow(qty) {
                if (qty < 1) qty = 1;
                input.value = qty;
                const price = getPrice();
                subtotal.innerText = 'Rp' + (price * qty).toLocaleString('id-ID');
                recalcSummary();

                fetch(`/cart/update/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ qty })
                });
            }

            row.querySelector('.btn-plus').addEventListener('click', () => updateRow(parseInt(input.value) + 1));
            row.querySelector('.btn-minus').addEventListener('click', () => updateRow(parseInt(input.value) - 1));
            input.addEventListener('change', () => updateRow(parseInt(input.value)));
        });

        function recalcSummary() {
            let subtotal = 0;
            document.querySelectorAll('tr[data-id]').forEach(row => {
                const priceText = row.querySelector('td:nth-child(3)').innerText;
                const price = parseInt(priceText.replace(/[^0-9]/g, ''));
                const qty = parseInt(row.querySelector('.qty-input').value);
                subtotal += price * qty;
            });
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            document.getElementById('summary-subtotal').innerText = 'Rp' + subtotal.toLocaleString('id-ID');
            document.getElementById('summary-tax').innerText = 'Rp' + tax.toLocaleString('id-ID');
            document.getElementById('summary-total').innerText = 'Rp' + total.toLocaleString('id-ID');
        }
    </script>
@endsection