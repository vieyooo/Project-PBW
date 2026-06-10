{{-- resources/views/supplier/create.blade.php --}}
{{-- Migrasi dari: supplier-tambah.php --}}

@extends('layouts.dashboard')

@section('title', 'Tambah Supplier')

@section('content')
<div class="form-container">

    <div class="form-header">
        <h3><i class="fas fa-plus-circle"></i> Form Tambah Supplier</h3>
    </div>

    {{-- Tampilkan error validasi --}}
    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">ID Supplier</label>
                    {{-- ID di-generate otomatis, tidak perlu dikirim user --}}
                    <input type="text" class="form-control" value="{{ $idOtomatis }}" readonly>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Penanggung Jawab (PIC) <span>*</span></label>
                    <input type="text"
                           name="pic_supplier"
                           class="form-control @error('pic_supplier') is-invalid @enderror"
                           value="{{ old('pic_supplier') }}"
                           placeholder="Nama Penanggung Jawab"
                           required autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Supplier <span>*</span></label>
            <input type="text"
                   name="nama_supplier"
                   class="form-control @error('nama_supplier') is-invalid @enderror"
                   value="{{ old('nama_supplier') }}"
                   placeholder="Contoh: PT. Indo Leather Prima"
                   required autocomplete="off">
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">No. Telp <span>*</span></label>
                    <input type="text"
                           name="no_telp"
                           class="form-control @error('no_telp') is-invalid @enderror"
                           value="{{ old('no_telp') }}"
                           placeholder="Contoh: (021) 6123456"
                           required autocomplete="off">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Fax (Opsional)</label>
                    <input type="text"
                           name="fax"
                           class="form-control"
                           value="{{ old('fax') }}"
                           placeholder="Contoh: (021) 6123457"
                           autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap <span>*</span></label>
            <textarea name="alamat"
                      class="form-control @error('alamat') is-invalid @enderror"
                      placeholder="Masukkan alamat lengkap supplier..."
                      required>{{ old('alamat') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data
            </button>
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
        </div>
    </form>

</div>
@endsection
