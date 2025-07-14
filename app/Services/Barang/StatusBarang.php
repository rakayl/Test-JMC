<?php

namespace App\Services\Barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
//repo
use App\Repositories\KategoriRepository;
use App\Repositories\SubKategoriRepository;
use App\Repositories\UserRepository;
use App\Repositories\DetailBarangMasukRepository;
use App\Repositories\BarangMasukRepository;

class StatusBarang
{
    private KategoriRepository $kategoriRepo;
    private SubKategoriRepository $subKategoriRepo;
    private UserRepository $userRepo;
    private DetailBarangMasukRepository $detailBarangRepo;
    private BarangMasukRepository $barangRepo;
    public function __construct(private Request $request) 
    {
         $this->kategoriRepo = new KategoriRepository();
        $this->subKategoriRepo = new SubKategoriRepository();
        $this->userRepo = new UserRepository();
        $this->detailBarangRepo = new DetailBarangMasukRepository();
        $this->barangRepo = new BarangMasukRepository();
    }
    public function call()
    {   
        
       DB::beginTransaction();
       try {
           $update = $this->detailBarangRepo->statusVerifikasi([
                'id'=>$this->request->target
            ],[
                'status'=>1
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
