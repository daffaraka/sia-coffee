<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelianStok;
use App\Models\StokGudang;

class PembelianStokController extends Controller
{

    public function index()
    {
        $pembelian = PembelianStok::with(['stok_bahan_baku', 'pembelian_barang'])->get();
        return view('pembelian-stok-bahan.pembelian-index', compact('pembelian'));
    }

    public function create()
    {
        $stok_bahan_baku = StokGudang::all();
        return view('pembelian-stok-bahan.pembelian-create', compact('stok_bahan_baku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_bahan_baku_id' => 'required',
            'jumlah' => 'required',
        ]);

        $pembelian = PembelianStok::create([
            'stok_bahan_baku_id' => $request->stok_bahan_baku_id,
            'jumlah' => $request->jumlah,
        ]);

        for ($i=0; $i < $request->jumlah; $i++) {
            PembelianBarang::create([
                'pembelian_stok_id' => $pembelian->id,
            ]);
        }

        return redirect()->route('pembelian-stok.index');
    }

    public function edit($id)
    {
        $pembelian = PembelianStok::with(['stok_bahan_baku', 'pembelian_barang'])->find($id);
        $stok_bahan_baku = StokBahanBaku::all();
        return view('pembelian-stok-bahan.pembelian-edit', compact('pembelian', 'stok_bahan_baku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_bahan_baku_id' => 'required',
            'jumlah' => 'required',
        ]);

        $pembelian = PembelianStok::find($id);
        $pembelian->update([
            'stok_bahan_baku_id' => $request->stok_bahan_baku_id,
            'jumlah' => $request->jumlah,
        ]);

        $pembelian->pembelian_barang()->delete();

        for ($i=0; $i < $request->jumlah; $i++) {
            PembelianBarang::create([
                'pembelian_stok_id' => $pembelian->id,
            ]);
        }

        return redirect()->route('pembelian-stok.index');
    }

    public function destroy($id)
    {
        $pembelian = PembelianStok::find($id);
        $pembelian->delete();

        return redirect()->route('pembelian-stok.index');
    }
}
