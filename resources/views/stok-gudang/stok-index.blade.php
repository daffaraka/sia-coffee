@extends('layouts')
@section('title', 'Stok Bahan Baku - Family Bakery')
@section('content')
    <style>
        td {
            font-size: 1rem !important;
        }

        .dataTables_length,
        .dataTables_length select {
            font-size: 1em;
            margin: 10px 0;
            padding: 0;
            width: 50px !important;
        }
    </style>
    <div class="container-fluid py-4">

        @can('stok_bahan_baku-create')
            <a href="{{ route('stok.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Tambah Data Stok Bahan Baku</a>
        @endcan

        <div class="table-responsive w-100">
            <table class="table table-hover table-light table-striped" id="dataTable">
                <thead class="table-dark" >
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Bahan Baku</th>
                        <th scope="col">Status Jumlah Stok</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Jumlah Stok Minimal</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Terakhir Diedit oleh</th>
                        <th scope="col">Waktu Diupdate</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stok as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_bahan_baku }}</td>
                            <td>
                                <button
                                    class="btn btn-sm {{ $data->jumlah < $data->jumlah_minimal ? 'btn-danger' : 'btn-success' }}">
                                    {{ $data->jumlah < $data->jumlah_minimal ? 'Stok kritis' : 'Stok Aman' }}
                                </button>
                            </td>
                            <td>
                                @if ($data->satuan == 'Kg')
                                    @if ($data->satuan == 'Kg' && $data->jumlah / 1000 < 10)
                                        {{ number_format($data->jumlah / 1000, 2, ',', '.')}}
                                    @elseif ($data->satuan == 'Kg' && $data->jumlah / 1000 <= 100 && $data->jumlah / 1000 >= 10)
                                        {{ number_format($data->jumlah / 1000, 2, ',', '.')}}
                                    @elseif($data->satuan == 'Kg' && $data->jumlah / 1000 <= 1000 && $data->jumlah / 1000 >= 100)
                                        {{ number_format($data->jumlah / 1000, 2, ',', '.')}}
                                    @elseif($data->satuan == 'Kg' && $data->jumlah / 1000 <= 10000 && $data->jumlah / 1000 >= 1000)
                                        {{ number_format($data->jumlah / 1000, 0, ',', '.') }}
                                    @endif
                                @else
                                    {{ $data->jumlah }}
                                @endif


                                <br>
                            </td>
                            <td>
                                @if ($data->satuan == 'Kg')
                                    @if ($data->satuan == 'Kg' && $data->jumlah_minimal / 1000 <= 10)
                                        {{ number_format($data->jumlah_minimal / 1000, 2, ',', '.') }}
                                    @elseif ($data->satuan == 'Kg' && $data->jumlah_minimal / 1000 <= 100)
                                        {{ number_format($data->jumlah_minimal / 1000, 2, ',', '.')}}
                                    @elseif ($data->satuan == 'Kg' && $data->jumlah_minimal / 1000 <= 1000 && $data->jumlah_minimal / 1000 >= 100)
                                        {{ number_format($data->jumlah_minimal / 1000, 2, ',', '.')}}
                                    @elseif($data->satuan == 'Kg' && $data->jumlah_minimal / 1000 <= 10000 && $data->jumlah_minimal / 1000 >= 1000)
                                        {{ number_format($data->jumlah_minimal / 1000, 0, ',', '.')}}
                                    @endif
                                @else
                                    {{ $data->jumlah_minimal }}
                                @endif

                                <br>
                            </td>
                            <td>{{ $data->satuan }}</td>
                            <td>{{ $data->terakhir_diedit_by }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->updated_at)->locale('id')->translatedFormat('d F Y') }}</td>
                            <td>
                                    <a href="{{ route('stok.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                    <a href="#" class="btn btn-danger delete-btn" data-id="{{ $data->id }}">Hapus</a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>



    </div>

    {{-- @include('vendor.sweetalert.alert') --}}
@endsection
{{--
<script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/DataTables/datatables.min.js') }}"></script>
<script>

</script> --}}
