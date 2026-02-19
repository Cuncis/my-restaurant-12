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
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                                        Keranjang</a>
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