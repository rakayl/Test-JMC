<?php

namespace App\Services\Barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//repo
use App\Repositories\KategoriRepository;
use App\Repositories\SubKategoriRepository;
use App\Repositories\UserRepository;
use App\Repositories\DetailBarangMasukRepository;
use App\Repositories\BarangMasukRepository;

use Illuminate\Support\Facades\DB;

class UpdateBarang
{
    private KategoriRepository $kategoriRepo;
    private SubKategoriRepository $subKategoriRepo;
    private UserRepository $userRepo;
    private DetailBarangMasukRepository $detailBarangRepo;
    private BarangMasukRepository $barangRepo;
    public function __construct(private Request $request,private string $id) 
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
           $this->detailBarangRepo->deleteNotIn('id',array_filter($this->request->id_detail, function($value) {
                    return $value !== null;
                }));
           $sub = $this->subKategoriRepo->findBy([
               'id'=> $this->request->sub_kategori_id
           ]);
           $kategori = $this->kategoriRepo->findBy([
               'id'=> $this->request->kategori_id
           ]);
           if(!$sub||!$kategori){
               return $false;
           }
           $data= array(
               'user_id'=> $this->request->user_id,
               'kategori_id'=> $this->request->kategori_id,
               'sub_kategori_id'=> $this->request->sub_kategori_id,
               'batas_harga'=> $sub->batas_harga??0,
               'asal_barang'=> $this->request->asal_barang,
               'no_surat'=> $this->request->no_surat??null,
           );
           if ($this->request->hasFile('lampiran')) {
               $path = Storage::disk('public')->put('uploads', $this->request->file('lampiran'));;
                $data['lampiran'] = Storage::url($path);
            } 
            $create = $this->barangRepo->update($this->id,$data);
            if(!$create){
            DB::rollBack();
            return false;
            }
            $detail = array();
            $count = count($this->request->nama_barang);
            for ($i = 0; $i < $count; $i++) {
                $kode = $kategori->kode_kategori.str_pad($i+1, 4, '0', STR_PAD_LEFT);
                $detail=array(
                    'barang_masuk_id'=> $this->id,
                    'kode'=> $kode,
                    'nama_barang'=> $this->request->nama_barang[$i],
                    'harga'=> (int) str_replace('.', '', $this->request->harga[$i]),
                    'jumlah_barang'=> $this->request->jumlah[$i],
                    'satuan'=> $this->request->satuan[$i],
                    'expired_date'=> $this->request->expired[$i]?? null,
                );
                if($this->request->id_detail[$i]){
                    
                    $detailcreate = $this->detailBarangRepo->update($this->request->id_detail[$i],$detail);
                }else{
                  $detailcreate = $this->detailBarangRepo->create($detail);
                }
                if(!$detailcreate){
                DB::rollBack();
                return false;
                }
            }
            DB::commit();
            return true;
       } catch (Exception $ex) {
           DB::rollBack();
           return false;
       }
      
    }
}
