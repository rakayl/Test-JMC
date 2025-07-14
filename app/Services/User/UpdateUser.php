<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UpdateUser
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
           $user = $this->userRepo->findBy([
               'id'=> $this->request->id
           ]);
           if(!$user){
            return false;
           }
           
           $data = [
                'name'=> $this->request->edit_name
           ];
           if($this->request->edit_email != $user->email){
               $data['email'] = $this->request->edit_email;
           }
           if($this->request->edit_username != $user->username){
               $data['username'] = $this->request->edit_username;
           }
           if($this->request->password){
               $data['password'] = Hash::make($this->request->password);
           }
            $update = $this->userRepo->update($this->request->id,$data);
            if($update){
                $user->syncRoles($this->request->edit_role);
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
