<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $fillable = [
        'kategori_id',
        'nama_sub_kategori',
        'batas_harga',
    ];
}
