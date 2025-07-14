<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class StoreUser
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
            $create = $this->userRepo->create([
                'name'=> $this->request->name,
                'email'=> $this->request->email,
                'password'=> Hash::make($this->request->password),
                'username'=> $this->request->username,
                'status'=> 1
            ]);
            $create->assignRole($this->request->role);
            DB::commit();
            return true;
       } catch (Exception $ex) {
           DB::rollBack();
           return false;
       }
      
    }
}
