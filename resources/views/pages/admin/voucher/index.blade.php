@extends('layouts.layout-admin')

@section('content')
    <style>
        .no-sort::after {
            display: none !important;
        }

        .no-sort {
            pointer-events: none !important;
            cursor: default !important;
        }
        td, th {
            vertical-align: middle !important;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            color: #5e72e4;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #5e72e4;
            border-color: #5e72e4;
            color: #fff;
        }

        .pagination .page-link:hover {
            background-color: #d4d9ff;
        }
    </style>

    <div class="row" style="min-height: 74vh">
        <div class="col-12 px-lg-4 px-0">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex flex-column flex-lg-row">
                        <div>
                            <h5 class="mb-0">Daftar Voucher</h5>
                            <p class="text-sm mb-0">
                                Manage, create new, delete, and edit here
                            </p>
                        </div>

                        <div class="ms-lg-auto mt-3 mt-lg-0 d-flex flex-column align-items-lg-end gap-2">
                            <div class="d-flex gap-2">
                                <a href="/admin/voucher/new" class="btn bg-gradient-success btn-sm mb-0">+ Tambah Voucher</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Info</th>
                                    <th class="text-center">Hadiah</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list as $index => $item)
                                    <tr class="voucher-row" data-name="{{ strtolower($item->name) }}"  data-id="{{ strtolower($item->id) }}">

                                        <td class="text-center">{{ $list->firstItem() + $index }}</td>

                                        <td class="text-center">{{ strtoupper($item->code) }}</td>

                                        <td class="text-center text-truncate" style="max-width: 120px;">
                                            {{ $item->name }}
                                        </td>

                                        <td class="text-center">{{ $item->info ?? '-' }}</td>

                                        <td class="text-center {{ $item->gift ? 'text-success' : 'text-danger' }}">
                                            {{ $item->gift->name ?? '(Belum Dipilih)' }}
                                        </td>

                                        <td class="text-center {{ $item->status === 'claimed' ? 'text-success' : 'text-warning' }}">
                                            {{ strtoupper($item->status) }}
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if (!isset($item->status) || $item->status == 'pending')
                                                    <a href="/admin/voucher/edit/{{ $item->id }}" class="text-primary" data-bs-toggle="tooltip" title="Ubah Hadiah">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                @endif
                                                <a href="/admin/voucher/delete/{{ $item->id }}" class="text-danger"
                                                    onclick="return confirm('Yakin ingin menghapus voucher ini?')"
                                                    data-bs-toggle="tooltip" title="Hapus Voucher">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="8">Tidak ada data voucher.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $list->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
