<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\BarangMasuk;
use Illuminate\Database\Eloquent\Model;

class BarangMasukRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new BarangMasuk);
    }

}
