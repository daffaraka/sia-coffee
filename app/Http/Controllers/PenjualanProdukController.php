<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanProdukController extends Controller
{
    public function index()
    {
        $pembelian = TransaksiPembelian::with(['supplier', 'pembelianBarang.barang'])->get();

        return view('pembelian.pembelian-index', compact('pembelian'));
    }


    public function create()
    {
        $produk = Produk::all();
        return view('pembelian.pembelian-create', compact('supplier', 'barang'));
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'qty.*' => 'required|numeric|gt:0',
            ],
            [
                'qty.*.gt' => 'Qty tidak boleh 0',
            ]
        );


        $sisa_pembayaran = 0;
        $finalTotal = 0;

        $transaksiPembelian = new TransaksiPembelian();

        $transaksiPembelian->no_pembelian = $request->no_pembelian;
        $transaksiPembelian->supplier_id = $request->supplier_id;
        $transaksiPembelian->tanggal_pembelian = Carbon::now()->toDateString();
        $transaksiPembelian->jenis_pembayaran = $request->jenis_pembayaran;
        $transaksiPembelian->tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;
        $transaksiPembelian->save();

        // 'total_pembelian' => $total,


        for ($i = 0; $i < count($request->id_barang); $i++) {

            $produk = Produk::find($request->id_barang[$i]);
            $total = $request->qty[$i] * $produk->harga_beli;
            $finalTotal += $total; // Menambahkan total individu ke $finalTotal

            $pembelianBarang = new PembelianBarang();
            $pembelianBarang->pembelian_id = $transaksiPembelian->id;
            $pembelianBarang->barang_id = $request->id_barang[$i];
            $pembelianBarang->qty = $request->qty[$i];
            $pembelianBarang->total = $total;
            $pembelianBarang->save();

            $produk->stok += $request->qty[$i];
            $produk->save();
        }



        if ($request->jenis_pembayaran == 'Cicil') {
            $sisa_pembayaran = $finalTotal / 2;
        } else {
            $sisa_pembayaran = 0;
        }
        $transaksiPembelian->sisa_pembayaran = $sisa_pembayaran;
        $transaksiPembelian->total_pembelian = $finalTotal;
        $transaksiPembelian->save();



        return redirect()->route('pembelian.index')->with('success', 'Transaksi Berhasil di Input');
    }

    public function show($id)
    {
    }


    public function edit($id)
    {
        $pembelian = TransaksiPembelian::with(['pembelianBarang.barang'])->find($id);
        // dd($pembelian);
        $produk = Produk::all();
        return view('pembelian.pembelian-edit', compact('pembelian'));
    }


    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'qty.*' => 'required|numeric|gt:0',
            ],
            [
                'qty.*.gt' => 'Qty tidak boleh 0',
            ]
        );


        $sisa_pembayaran = 0;
        $finalTotal = 0;

        $transaksiPembelian = TransaksiPembelian::find($id);

        $transaksiPembelian->barang()->detach();

        $transaksiPembelian->no_pembelian = $request->no_pembelian;
        $transaksiPembelian->supplier_id = $request->supplier_id;
        $transaksiPembelian->tanggal_pembelian = Carbon::now()->toDateString();
        $transaksiPembelian->jenis_pembayaran = $request->jenis_pembayaran;
        $transaksiPembelian->save();

        for ($i = 0; $i < count($request->id_barang); $i++) {
            $produk = Produk::find($request->id_barang[$i]);

            $total = $request->qty[$i] * $produk->harga_beli;
            $finalTotal += $total; // Menambahkan total individu ke $finalTotal

            $transaksiPembelian->barang()->attach($request->id_barang[$i], [
                'qty' => $request->qty[$i],
                'total' => $total
            ]);

            $produk->stok += $request->qty[$i];
            $produk->save();
        }

        if ($request->jenis_pembayaran == 'Cicil') {
            $sisa_pembayaran = $finalTotal / 2;
        } else {
            $sisa_pembayaran = 0;
        }

        $transaksiPembelian->sisa_pembayaran = $sisa_pembayaran;
        $transaksiPembelian->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil diedit');
    }


    public function destroy($id)
    {
        $pembelian = TransaksiPembelian::find($id);
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Transaksi Berhasil di hapus');
    }
}
