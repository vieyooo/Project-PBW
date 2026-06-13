@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Pelanggan</h1>
    <a href="{{ route('pelanggans.create') }}" class="btn btn-primary mb-3">Tambah Pelanggan</a>
    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($pelanggans ?? [] as $pelanggan)
            <tr>
                <td>{{ $pelanggan->ID_PELANGGAN ?? '' }}</td>
                <td>{{ $pelanggan->NAMA_PELANGGAN ?? '' }}</td>
                <td>{{ $pelanggan->ALAMAT ?? '' }}</td>
                <td>{{ $pelanggan->NO_TELP ?? '' }}</td>
                <td>
                    <a href="{{ route('pelanggans.edit', $pelanggan->ID_PELANGGAN) }}">Edit</a>
                    <form action="{{ route('pelanggans.destroy', $pelanggan->ID_PELANGGAN) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection