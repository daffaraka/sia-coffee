<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga_produk',
        'gambar_produk'
    ];

}
