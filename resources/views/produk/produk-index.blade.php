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
                        <td>{{ $data->nama }}</td>
                        <td>
                            <img src="{{ asset('produk/'.$data->gambar_produk) }}" width="200" alt="">
                        </td>
                        <td>
                            {{ $data->deskripsi }}
                        </td>
                        <td>Rp. {{ number_format($data->hargak) }}</td>
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
