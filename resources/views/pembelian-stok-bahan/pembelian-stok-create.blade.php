@extends('layouts')
@section('title', 'Tambah Bahan Baku - Family Bakery')
@section('content')
    <style>
        .select2-container .select2-selection--single {
            height: auto;
            line-height: inherit;
            padding: 0.5rem 1rem;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: unset;
        }
    </style>
    <div class="container py-3">
        <div class="card mb-3 ">
            <div class="card-body border-1">
                <h4>Petunjuk Pemesanan Bahan Baku</h4>

                <ul class="nav">
                    <li class="nav-item">- Untuk menambahkan data pemesanan bahan baku, data yang disediakan dalam select dropdown adalah data yang sudah ada di Stok Bahan Baku. </li>
                    <li class="nav-item">- Jika anda ingin menambahkan <b class="text-danger"> data yang tidak tercantum pada select dropdown</b> , anda harus menambahkannya dari data stok bahan baku terlebih dahulu. </li>
                    <li class="nav-item">- Jumlah bahan baku akan otomatis bertambah jika status yang anda masukkan adalah <b class="text-danger"> Diterima </b> </li>



                    {{-- <li class="nav-item text-danger">-</li> --}}
                </ul>
            </div>
        </div>
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <select class="livesearch form-control" name="nama_bahan_baku" id="nama_bahan_Baku">
                    @foreach ($stok as $item)
                        <option value="{{ $item->nama_bahan_baku }}">{{ $item->nama_bahan_baku }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="" id="label_jumlah_pesanan">Jumlah Pesanan (<span id="satuan"></span>) </label>
                <input type="text" class="form-control" name="jumlah_pesanan" id="jumlah_pesanan">
            </div>
            <div class="mb-3">
                <label for="">Harga Satuan</label>
                <input type="text" class="form-control" name="harga_satuan" id="harga_satuan">
            </div>
            <div class="mb-3">
                <label for="">Total Harga</label>
                <input type="text" class="form-control" name="total_harga" id="total_harga">
            </div>
            <div class="mb-3">
                <label for="">Status Pesanan</label>
                <select name="status_pesanan" id="" class="form-control">
                    <option value="Sedang Diantar">Sedang Diantar</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Dibayar">Dibayar</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="">DP</label>
                <input type="number" class="form-control" name="dp">
            </div>
            <div class="mb-3">
                <label for="">Deadline Pembayaran</label>
                <input type="date" class="form-control" name="deadline_dp">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

<script type="text/javascript">
    $(document).ready(function() {
        $('.livesearch').select2();

        $('#jumlah_pesanan, #harga_satuan').on('input', function() {
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

        $('#nama_bahan_Baku').on('change', function() {
            var nama_bahan_baku = this.value;

            $.ajax({
                url: "{{ url('get-data-satuan') }}/" + nama_bahan_baku,
                type: "post",
                data: {
                    nama_bahan_baku: nama_bahan_baku,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#satuan').text(result.satuan.satuan);

                }
            });

        });
    });
</script>
