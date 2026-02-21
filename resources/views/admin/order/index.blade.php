@extends('admin.layouts.master')
@section('title', 'Pesanan')

@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <style>
        .dt-search { margin-bottom: 0; }
        .badge-status { font-size: 0.8rem; }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Pesanan</h3>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="table-orders" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Pesanan</th>
                                        <th>Pelanggan</th>
                                        <th>Meja</th>
                                        <th>Item</th>
                                        <th>Total</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><span class="fw-semibold">{{ $order->order_number }}</span></td>
                                            <td>{{ $order->user->full_name ?? '-' }}</td>
                                            <td>Meja {{ $order->table_number }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $order->order_items_count }} item</span>
                                            </td>
                                            <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                            <td>
                                                @if($order->payment_method === 'cash')
                                                    <span class="badge bg-light text-dark border">Tunai</span>
                                                @elseif($order->payment_method === 'e_wallet')
                                                    <span class="badge bg-info text-dark">E-Wallet</span>
                                                @else
                                                    <span class="badge bg-primary">Midtrans</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status === 'pending')
                                                    <span class="badge bg-warning text-dark badge-status">Pending</span>
                                                @elseif($order->status === 'settlement')
                                                    <span class="badge bg-success badge-status">Settlement</span>
                                                @else
                                                    <span class="badge bg-info text-dark badge-status">Dimasak</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                   class="btn btn-sm btn-info text-white" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('orders.edit', $order->id) }}"
                                                   class="btn btn-sm btn-warning text-white" title="Edit Status">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Hapus pesanan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table-orders').DataTable({
                order: [[8, 'desc']],
                columnDefs: [{ orderable: false, targets: [9] }],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@endsection
