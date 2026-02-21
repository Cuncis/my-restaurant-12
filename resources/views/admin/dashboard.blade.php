@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/apexcharts/apexcharts.css') }}">
@endsection

@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>

<div class="page-content">

    {{-- Summary Cards --}}
    <section class="row">
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center px-4 py-4">
                    <div class="stats-icon blue me-3">
                        <i class="bi bi-tags-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Kategori</h6>
                        <h4 class="mb-0">{{ $totalCategories }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center px-4 py-4">
                    <div class="stats-icon green me-3">
                        <i class="bi bi-egg-fried fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Menu</h6>
                        <h4 class="mb-0">{{ $totalItems }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center px-4 py-4">
                    <div class="stats-icon purple me-3">
                        <i class="bi bi-receipt-cutoff fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Pesanan</h6>
                        <h4 class="mb-0">{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center px-4 py-4">
                    <div class="stats-icon red me-3">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Pengguna</h6>
                        <h4 class="mb-0">{{ $totalUsers }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Revenue Cards --}}
    <section class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body d-flex align-items-center px-4 py-4">
                    <div class="stats-icon green me-3">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Pendapatan</h6>
                        <h4 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body d-flex align-items-center px-4 py-4">
                    <div class="stats-icon blue me-3">
                        <i class="bi bi-calendar-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Pendapatan Hari Ini</h6>
                        <h4 class="mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Charts + Top Items --}}
    <section class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <div id="chart-order-status"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Menu Terlaris</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Menu</th>
                                <th>Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topItems as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td><span class="badge bg-primary">{{ $item->order_items_count }}x</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Monthly Revenue Chart --}}
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pendapatan 6 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    <div id="chart-monthly-revenue"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Recent Orders --}}
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Meja</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="fw-semibold text-primary">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->user->full_name ?? '-' }}</td>
                                <td>Meja {{ $order->table_number }}</td>
                                <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($order->status === 'cooked')
                                        <span class="badge bg-info text-dark">Dimasak</span>
                                    @else
                                        <span class="badge bg-success">Settlement</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pesanan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script>
    // Order Status Donut Chart
    new ApexCharts(document.getElementById('chart-order-status'), {
        chart: { type: 'donut', height: 250 },
        labels: ['Pending', 'Dimasak', 'Settlement'],
        series: [{{ $pendingOrders }}, {{ $cookedOrders }}, {{ $settledOrders }}],
        colors: ['#ffc107', '#0dcaf0', '#198754'],
        legend: { position: 'bottom' },
        noData: { text: 'Belum ada data' }
    }).render();

    // Monthly Revenue Bar Chart
    new ApexCharts(document.getElementById('chart-monthly-revenue'), {
        chart: { type: 'bar', height: 320, toolbar: { show: false } },
        series: [{
            name: 'Pendapatan (Rp)',
            data: @json($monthlyRevenue->pluck('total'))
        }],
        xaxis: {
            categories: @json($monthlyRevenue->map(fn($r) => \Carbon\Carbon::create($r->year, $r->month)->translatedFormat('M Y')))
        },
        colors: ['#435ebe'],
        dataLabels: { enabled: false },
        plotOptions: { bar: { borderRadius: 4, columnWidth: '50%' } },
        yaxis: {
            labels: {
                formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
            }
        },
        noData: { text: 'Belum ada data' }
    }).render();
</script>
@endsection
