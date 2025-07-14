<?php

namespace App\Services\SubKategori;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\KategoriRepository;
use App\Repositories\SubKategoriRepository;
use Illuminate\Support\Facades\DB;

class StoreSubKategori
{
    private KategoriRepository $kategoriRepo;
    private SubKategoriRepository $subKategoriRepo;
    public function __construct(private Request $request) 
    {
        $this->kategoriRepo = new KategoriRepository();
        $this->subKategoriRepo = new SubKategoriRepository();
    }
    public function call()
    {   
        
       DB::beginTransaction();
       try {
            $create = $this->subKategoriRepo->create([
                'kategori_id'=> $this->request->kategori_id,
                'nama_sub_kategori'=> $this->request->nama_sub_kategori,
                'batas_harga'=> (int) str_replace('.', '', $this->request->batas_harga),
            ]);
            DB::commit();
            return true;
       } catch (Exception $ex) {
           DB::rollBack();
           return false;
       }
      
    }
}
