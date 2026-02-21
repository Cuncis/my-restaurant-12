@extends('admin.layouts.master')
@section('title', 'Manajemen Pengguna')

@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Manajemen Pengguna</h3>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
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

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="table-users"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>No. Telepon</th>
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->username ?? '-' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                            <td>
                                                @php
                                                    $roleColors = [
                                                        'Admin'    => 'danger',
                                                        'Cashier'  => 'warning',
                                                        'Chef'     => 'success',
                                                        'Customer' => 'info',
                                                    ];
                                                    $color = $roleColors[$user->role->name ?? ''] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ $user->role->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning me-1" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                        title="Hapus" data-name="{{ $user->full_name }}">
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
    <script src="{{ asset('assets/admin/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table-users').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "Pertama", last: "Terakhir",
                        next: "Berikutnya", previous: "Sebelumnya"
                    }
                },
                columnDefs: [{ orderable: false, targets: [6] }]
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                const name = $(this).data('name');
                if (confirm('Hapus pengguna "' + name + '"?')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
