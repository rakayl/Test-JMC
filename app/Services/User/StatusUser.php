<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class StatusUser
{
    private UserRepository $userRepo;
    public function __construct(private Request $request) 
    {
        $this->userRepo = new UserRepository();
    }
    public function call()
    {   
        
       DB::beginTransaction();
       try {
            $update = $this->userRepo->updateParam([
                'username'=> $this->request->data_target
            ],[
                'status'=> ($this->request->status == true) ? false : true
            ]);
            if($update){
                 DB::commit();
                return true;
            }
           DB::rollBack();
           return false;
       } catch (Exception $ex) {
           DB::rollBack();
           return false;
       }
      
    }
}
