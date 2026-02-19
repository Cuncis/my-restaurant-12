@extends('customer.layouts.master')

@push('styles')
    <style>
        .bg-pink {
            background-color: #e91e8c !important;
        }
    </style>
@endpush

@section('content')

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-3">
                        <div class="col-lg">
                            <div class="row g-4 justify-content-center">
                                @foreach ($items as $item)
                                    @php
                                        $categoryColors = [
                                            'Appetizers' => 'bg-warning text-dark',
                                            'Main Courses' => 'bg-danger text-white',
                                            'Desserts' => 'bg-primary text-white',
                                            'Beverages' => 'bg-info text-dark',
                                        ];
                                        $badgeClass = $categoryColors[$item->category->name] ?? 'bg-secondary text-white';
                                    @endphp
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{ $item->image_path }}" class="img-fluid w-100 rounded-top"
                                                    alt="{{ $item->name }}" style="height: 420px; object-fit: cover;">
                                            </div>
                                            <div class="{{ $badgeClass }} px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">{{ $item->category->name }}</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $item->name }}</h4>
                                                <p class="text-limited">{{ $item->description }}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                        {{ 'Rp' . number_format($item->price, 0, ',', '.') }}
                                                    </p>
                                                    <button onclick="addToCart({{ $item->id }})"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah Keranjang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Pagination -->
                                <!-- <div class="col-12">
                                                                                                                                <div class="pagination d-flex justify-content-center mt-5">
                                                                                                                                    <a href="#" class="rounded">&laquo;</a>
                                                                                                                                    <a href="#" class="active rounded">1</a>
                                                                                                                                    <a href="#" class="rounded">2</a>
                                                                                                                                    <a href="#" class="rounded">3</a>
                                                                                                                                    <a href="#" class="rounded">4</a>
                                                                                                                                    <a href="#" class="rounded">5</a>
                                                                                                                                    <a href="#" class="rounded">6</a>
                                                                                                                                    <a href="#" class="rounded">&raquo;</a>
                                                                                                                                </div>
                                                                                                                            </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection

@section('script')
    <script>
        function addToCart(menuId) {
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ menu_id: menuId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update cart badge
                        const badge = document.getElementById('cart-count');
                        if (badge) {
                            badge.textContent = data.cart_count;
                            badge.style.display = 'inline-block';
                        }
                        // Toast-style feedback
                        showToast('Menu berhasil ditambahkan ke keranjang!');
                    } else {
                        showToast('Gagal menambahkan menu ke keranjang.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menambahkan menu.', 'danger');
                });
        }

        function showToast(message, type = 'success') {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;';
                document.body.appendChild(container);
            }
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} shadow`;
            toast.style.cssText = 'min-width:260px;opacity:1;transition:opacity 0.5s;';
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; }, 2500);
            setTimeout(() => { toast.remove(); }, 3000);
        }
    </script>
@endsection