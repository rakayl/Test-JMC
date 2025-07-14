<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarangMasuk extends Model
{
   protected $fillable = [
        'barang_masuk_id',
        'kode',
        'nama_barang',
        'harga',
        'jumlah_barang',
        'satuan',
        'expired_date',
        'status',
    ];
}
