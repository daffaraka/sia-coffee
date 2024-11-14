@extends('layouts')
@section('title', 'Edit Pemesanan Bahan Baku - Family Bakery')
@section('content')
    <div class="container py-3">
        <form action="{{ route('pemesanan.update', $bb->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku" value="{{ $bb->nama_bahan_baku }}">
            </div>
            <div class="mb-3">
                <label for="">Jumlah Pesanan</label>
                <input type="text" class="form-control" name="jumlah_pesanan" id="jumlah_pesanan" value="{{ $bb->jumlah_pesanan }}">
            </div>
            <div class="mb-3">
                <label for="">Harga Satuan</label>
                <input type="text" class="form-control" name="harga_satuan" id="harga_satuan" value="{{ $bb->harga_satuan }}">
            </div>
            <div class="mb-3">
                <label for="">Total Harga</label>
                <input type="text" class="form-control" name="total_harga" id="total_harga" value="{{ $bb->total_harga }}">
            </div>
            <div class="mb-3">
                <label for="">Status Pesanan</label>
                <select name="status_pesanan" id="" class="form-control">
                    <option value="Sedang Diantar" {{ $bb->status_pesanan == 'Sedang Diantar' ? 'selected' : '' }}>Sedang
                        Diantar</option>
                    <option value="Diterima" {{ $bb->status_pesanan == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Dibayar" {{ $bb->status_pesanan == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>

                </select>
            </div>

            <div class="mb-3">
                <label for="">DP</label>
                <input type="number" class="form-control" name="dp" value="{{ $bb->dp }}">
            </div>
            <div class="mb-3">
                <label for="">Deadline DP</label>
                <input type="date" class="form-control" name="deadline_dp" value="{{ $bb->deadline_dp }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

<script type="text/javascript">
    $(document).ready(function() {
        $('#jumlah_pesanan, #harga_satuan').on('keyup', function() {
            var jumlah_pesanan = $('#jumlah_pesanan').val();
            var harga_satuan = $('#harga_satuan').val();
            var total_harga = jumlah_pesanan * harga_satuan;
            $('#total_harga').val(total_harga);
        });

        $('#total_harga').on('keyup', function() {
            var total_harga = parseInt($(this).val());
            var jumlah_pesanan = $('#jumlah_pesanan').val();
            var harga_satuan = total_harga / jumlah_pesanan;

            $('#harga_satuan').val(harga_satuan);
        });
    });
</script>
