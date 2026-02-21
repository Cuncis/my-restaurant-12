@extends('admin.layouts.master')
@section('title', 'Kategori')

@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <style>
        .dt-search { margin-bottom: 0; }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Kategori</h3>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
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
                        <h4 class="card-title">Daftar Kategori</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="table-categories" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Menu</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $category->items_count }} item</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                   class="btn btn-sm btn-warning text-white" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirmDelete(this, {{ $category->items_count }})">
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
        function confirmDelete(form, itemCount) {
            if (itemCount > 0) {
                alert('Kategori tidak dapat dihapus karena masih memiliki ' + itemCount + ' menu makanan.');
                return false;
            }
            return confirm('Yakin ingin menghapus kategori ini?');
        }

        $(document).ready(function () {
            $('#table-categories').DataTable({
                columnDefs: [{ orderable: false, targets: [4] }],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@endsection
