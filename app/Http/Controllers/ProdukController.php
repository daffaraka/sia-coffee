<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index()
    {

        $data['judul'] = 'Beranda  produk';
        $data['produk'] = Produk::all();

        return view('produk.produk-index', $data);
    }

    public function create()
    {
        return view('produk.produk-create');
    }


    public function store(Request $request)
    {
        $file = $request->file('gambar_produk');
        $fileName = $file->getClientOriginalName();
        $time = now()->format('Y-m-d H-i-s');
        $fileSaved = $request->nama_produk . '-' . $time . $fileName;
        $filePath = $file->move('upload/produk', $fileSaved);

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga_produk = $request->harga_produk;
        $produk->gambar_produk = $filePath;
        $produk->save();


        return redirect()->route('produk.index');
    }

    public function show(Produk $produk)
    {
        //
    }


    public function edit($id)
    {
        $data['produk'] = Produk::find($id);
        return view('produk.produk-edit ', $data);
    }


    public function update(Request $request, $id)

    {
        $produk = Produk::find($id);


        $file = '';
        $time = now()->format('Y-m-d H-i-s');

        if ($request->has('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $fileName = $file->getClientOriginalName();
            $fileSaved = $request->nama_produk . '-' . $time . $fileName;
            if (File::exists('upload/produk/' . $produk->gambar_produk)) {
                File::delete('upload/produk/' . $produk->gambar_produk);
                $filePath = $file->move('upload/produk', $fileSaved);
            } else {
                $filePath = $file->move('upload/produk', $fileSaved);
            }
        } else {
            $fileSaved = $produk->gambar_produk;
        }

        // $file = $request->file('gambar_produk');
        // $fileName = $file->getClientOriginalName();
        // $time = now()->format('Y-m-d H-i-s');
        // $fileSaved = $request->nama_produk . '-' . $time . $fileName;



        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga_produk = $request->harga_produk;
        $produk->gambar_produk = $filePath;
        $produk->save();

        return redirect()->route(' produk.index');
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return redirect()->route('produk.index');
    }
}
