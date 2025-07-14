<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class KategoriRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new Kategori);
    }

}
