<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\DetailBarangMasuk;
use Illuminate\Database\Eloquent\Model;

class DetailBarangMasukRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new DetailBarangMasuk);
    }

}
