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

class UpdateSubKategori
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
         
           
           $data = [
                'kategori_id'=> $this->request->edit_kategori_id,
                'nama_sub_kategori'=> $this->request->edit_nama_sub_kategori,
                'batas_harga'=> (int) str_replace('.', '', $this->request->edit_batas_harga),
           ];
            $update = $this->subKategoriRepo->update($this->request->id,$data);
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
