@extends('layouts')
@section('content')
    <a href="{{route('produk.create')}}" class="btn btn-primary">Tambah Produk</a>

    <div class="table-responsive mt-5 ">
        <table class="table table-striped table-bordered shadow">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Gambar Produk</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($produk as $data)
                    <tr class="">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_produk }}</td>
                        <td>
                            <img src="{{ asset($data->gambar_produk) }}" style="width: 200px; height: auto;" class="rounded-0" alt="{{$data->gambar_produk}}">
                        </td>
                        <td>
                            {{ $data->deskripsi }}
                        </td>
                        <td>Rp. {{ number_format($data->harga_produk) }}</td>
                        <td>
                            <a href="{{route('produk.edit',$data->id)}}" class="btn btn-info">Edit</a>
                            <a href="{{route('produk.destroy',$data->id)}}" class="btn btn-danger">Hapus</a>

                        </td>

                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
