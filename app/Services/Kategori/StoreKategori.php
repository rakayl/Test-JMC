<?php

namespace App\Services\Kategori;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\KategoriRepository;
use Illuminate\Support\Facades\DB;

class StoreKategori
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
            $create = $this->kategoriRepo->create([
                'kode_kategori'=> $this->request->kode_kategori,
                'name_kategori'=> $this->request->name_kategori,
            ]);
            DB::commit();
            return true;
       } catch (Exception $ex) {
           DB::rollBack();
           return false;
       }
      
    }
}
