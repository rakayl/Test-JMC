<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\SubKategori;
use Illuminate\Database\Eloquent\Model;

class SubKategoriRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new SubKategori);
    }

}
