<?php

namespace App\Services\Kategori;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\KategoriRepository;
use Illuminate\Support\Facades\DB;

class UpdateKategori
{
    private KategoriRepository $kategoriRepo;
    public function __construct(private Request $request) 
    {
        $this->kategoriRepo = new KategoriRepository();
    }
    public function call()
    {   
        
       DB::beginTransaction();
       try {
           $kategori = $this->kategoriRepo->findBy([
               'id'=> $this->request->id
           ]);
           if(!$kategori){
            return false;
           }
           
           $data = [
                'name_kategori'=> $this->request->edit_name_kategori
           ];
           if($this->request->edit_kode_kategori != $kategori->kode_kategori){
               $data['kode_kategori'] = $this->request->edit_kode_kategori;
           }
            $update = $this->kategoriRepo->update($this->request->id,$data);
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
