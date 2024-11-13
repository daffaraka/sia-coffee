@extends('layouts')
@section('title', 'Tambah Stok Bahan Baku - Family Bakery')
@section('content')
    @include('flash')
    <div class="container py-3">
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku" required>

            </div>
            <div class="mb-3">
                <label for="">Satuan</label>
                <select name="satuan" class="form-control text-dark" id="" required>
                    <option value="Kg">Kg</option>
                    <option value="Gram">Gram</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Butir">Butir</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Bahan Baku saat ini</label>
                <input type="number" class="form-control" name="jumlah" step="any" required>
                <ul class="mt-1 px-0">
                    <li style="font-weight: 600;"> - Gunakan symbol " . " (titik) untuk angka decimal</li>
                </ul>
            </div>


            <div class="mb-3">
                <label for="">Jumlah Minimal Stok</label>
                <input type="number" class="form-control" name="jumlah_minimal" step="any" required>
                <ul class="mt-1 px-0">
                    <li style="font-weight: 600;"> - Gunakan symbol " . " (titik) untuk angka decimal</li>
                </ul>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    @include('sweetalert::alert')
@endsection


