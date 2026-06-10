{{-- resources/views/supplier/edit.blade.php --}}
{{-- Migrasi dari: supplier-ubah.php --}}

@extends('layouts.dashboard')

@section('title', 'Edit Supplier')

@section('content')
<div class="form-container">

    <div class="form-header">
        <h3><i class="fas fa-pencil-alt"></i> Form Edit Supplier</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PUT method — Laravel membaca @method('PUT') sebagai HTTP PUT --}}
    <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">ID Supplier</label>
                    <input type="text" class="form-control" value="{{ $supplier->id_supplier }}" readonly>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Penanggung Jawab (PIC) <span>*</span></label>
                    <input type="text"
                           name="pic_supplier"
                           class="form-control @error('pic_supplier') is-invalid @enderror"
                           value="{{ old('pic_supplier', $supplier->pic_supplier) }}"
                           required autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Supplier <span>*</span></label>
            <input type="text"
                   name="nama_supplier"
                   class="form-control @error('nama_supplier') is-invalid @enderror"
                   value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                   required autocomplete="off">
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">No. Telp <span>*</span></label>
                    <input type="text"
                           name="no_telp"
                           class="form-control @error('no_telp') is-invalid @enderror"
                           value="{{ old('no_telp', $supplier->no_telp) }}"
                           required autocomplete="off">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Fax (Opsional)</label>
                    <input type="text"
                           name="fax"
                           class="form-control"
                           value="{{ old('fax', $supplier->fax) }}"
                           autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap <span>*</span></label>
            <textarea name="alamat"
                      class="form-control @error('alamat') is-invalid @enderror"
                      required>{{ old('alamat', $supplier->alamat) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
        </div>
    </form>

</div>
@endsection
