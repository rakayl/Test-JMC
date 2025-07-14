<?php

namespace App\Services\Kategori;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\KategoriRepository;
use Illuminate\Support\Facades\DB;

class DeleteKategori
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
           $update = $this->kategoriRepo->deleteBy([
                'kode_kategori'=>$this->request->target
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
