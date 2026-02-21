@extends('admin.layouts.master')
@section('title', 'Manajemen Role')

@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Manajemen Role</h3>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Role
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
                        <h4 class="card-title">Daftar Role</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="table-roles" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Role</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Jumlah Pengguna</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge bg-primary fs-6">{{ $role->name }}</span>
                                            </td>
                                            <td>{{ $role->description }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $role->users_count > 0 ? 'info' : 'secondary' }}">
                                                    {{ $role->users_count }} pengguna
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                    class="btn btn-sm btn-warning me-1" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus"
                                                        data-name="{{ $role->name }}" data-users="{{ $role->users_count }}">
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
            $('#table-roles').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25],
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
                columnDefs: [{ orderable: false, targets: [4] }]
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                const name = $(this).data('name');
                const users = $(this).data('users');
                if (users > 0) {
                    alert('Role "' + name + '" tidak dapat dihapus karena masih memiliki ' + users + ' pengguna.');
                    return;
                }
                if (confirm('Hapus role "' + name + '"?')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection