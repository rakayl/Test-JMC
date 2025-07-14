<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_id',
        'sub_kategori_id',
        'batas_harga',
        'asal_barang',
        'no_surat',
        'lampiran',
    ];
    // Post has many Comments
    public function detail()
    {
        return $this->hasMany(DetailBarangMasuk::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function subkategori()
    {
        return $this->belongsTo(SubKategori::class,'sub_kategori_id');
    }
}
