{{-- resources/views/supplier/index.blade.php --}}
{{-- Migrasi dari: supplier-lihat.php --}}

@extends('layouts.dashboard')

@section('title', 'Data Supplier')

@section('content')
<div class="table-container">

    {{-- Header + Tombol Tambah --}}
    <div class="action-header">
        <h3>
            <i class="fas fa-truck"></i> Data Supplier
        </h3>
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Supplier
        </a>
    </div>

    {{-- Notifikasi sukses / error --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    {{-- Pilihan Limit Per Halaman --}}
    <div class="limit-selector">
        <span>Tampilkan:</span>
        @foreach([5, 10, 15, 20] as $opt)
            <a href="{{ request()->fullUrlWithQuery(['limit' => $opt, 'page' => 1]) }}"
               class="btn-limit {{ $limit == $opt ? 'active' : '' }}">
                {{ $opt }}
            </a>
        @endforeach
        <span>data per halaman</span>
    </div>

    {{-- Tabel Data --}}
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Supplier</th>
                    <th>Nama Supplier</th>
                    <th>No. Telp</th>
                    <th>Fax</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $index => $supplier)
                    <tr>
                        <td>{{ $suppliers->firstItem() + $index }}</td>
                        <td><span class="badge-id">{{ $supplier->id_supplier }}</span></td>
                        <td>{{ $supplier->nama_supplier }}</td>
                        <td>{{ $supplier->no_telp ?? '-' }}</td>
                        <td>{{ $supplier->fax ?? '-' }}</td>
                        <td>{{ $supplier->pic_supplier ?? '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('supplier.edit', $supplier->id_supplier) }}"
                                   class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('supplier.destroy', $supplier->id_supplier) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus supplier {{ $supplier->nama_supplier }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        {{ $suppliers->links() }}
    </div>

</div>
@endsection
