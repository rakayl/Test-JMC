<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class DeleteUser
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
           $update = $this->userRepo->deleteBy([
                'email'=>$this->request->target
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
