<?php

namespace App\Repositories;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new User);
    }

}
