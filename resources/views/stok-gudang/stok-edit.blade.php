@extends('layouts')
@section('title', 'Edit Stok Bahan Baku - Family Bakery')
@section('content')
    @include('flash')
    <div class="container py-3">
        <form action="{{ route('stok.update', $stok->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku" value="{{ $stok->nama_bahan_baku }}">
            </div>
            <div class="mb-3">
                <label for="">Jumlah Bahan Baku saat ini</label>
                <input type="text" class="form-control" name="jumlah"
                    value="{{ $jb}}">
            </div>

            <div class="mb-3">
                <label for="">Satuan</label>
                <select name="satuan" class="form-control text-dark" id="">
                    <option value="Kg" {{ $stok->satuan == 'Kg' ? 'selected' : '' }}>Kg</option>
                    <option value="Gram" {{ $stok->satuan == 'Gram' ? 'selected' : '' }}>Gram</option>
                    <option value="Pcs" {{ $stok->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="Butir" {{ $stok->satuan == 'Butir' ? 'selected' : '' }}>Butir</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Minimal Stok</label>
                <input type="text" class="form-control" name="jumlah_minimal" value="{{$jm}}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    @include('sweetalert::alert')
@endsection


