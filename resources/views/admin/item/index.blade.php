@extends('admin.layouts.master')
@section('title', 'Menu Makanan')

@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <style>
        #table-items img { object-fit: cover; border-radius: 6px; }
        .dt-search { margin-bottom: 0; }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Menu Makanan</h3>
            <a href="{{ route('items.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Menu
            </a>
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
                        <h4 class="card-title">Daftar Menu Makanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="table-items"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Gambar</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Tersedia</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($item->image_path)
                                                    <img src="{{ Storage::url($item->image_path) }}"
                                                        alt="{{ $item->name }}" width="60" height="60">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                                        style="width:60px;height:60px;">
                                                        <i class="bi bi-image text-muted fs-4"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->category->name ?? '-' }}</td>
                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>
                                                @if($item->is_available)
                                                    <span class="badge bg-success">Tersedia</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('items.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning me-1"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                        title="Hapus" data-name="{{ $item->name }}">
                                                        <i class="bi bi-trash-fill"></i>
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
    <script
        src="{{ asset('assets/admin/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table-items').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [1, 6] }
                ]
            });

            // Confirm before delete
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                const name = $(this).data('name');
                if (confirm('Hapus menu "' + name + '"? Tindakan ini tidak dapat dibatalkan.')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection