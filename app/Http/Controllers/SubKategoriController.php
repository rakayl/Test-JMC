<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Response;

//model
use App\Models\Kategori;
use App\Models\SubKategori;

//service
use App\Services\SubKategori\StoreSubKategori;
use App\Services\SubKategori\UpdateSubKategori;
use App\Services\SubKategori\DeleteSubKategori;

//request
use App\Http\Requests\SubKategori\StoreSubKategoriRequest;
use App\Http\Requests\SubKategori\UpdateSubKategoriRequest;
use App\Http\Requests\SubKategori\DeleteSubKategoriRequest;

class SubKategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function index(Request $request)
    {
        $page_title = "All Sub Kategori";
        $perpage = $request->input('length', 10);
        $data = SubKategori::join('kategoris', 'sub_kategoris.kategori_id', '=', 'kategoris.id')
                ->when($request->search, function($query, $search) {
                $searchTerms = explode(' ', $search); // Memecah kata pencarian
                return $query->where(function($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where(function($subQ) use ($term) {
                                $subQ->where('nama_sub_kategori', 'like', "%{$term}%")
                                ->orWhere('name_kategori', 'like', "%{$term}%");
                        });
                    }
                });
            })
            ->select('sub_kategoris.*','name_kategori','kode_kategori')
            ->orderBy('id', 'desc')
            ->paginate($perpage)
            ->withQueryString();
            $kategori = Kategori::all();
        return view('subkategori.index', compact(
            'page_title',
            'data',
            'kategori'
        ));
    }
    public function create(StoreSubKategoriRequest $request)
    {
        try {
          $service = (new StoreSubKategori($request))->call();
          if($service){
            return back()->with(['success' => [__('SubKategori created successfully!')]]);
          }
           return back()->with(['error' => [__('Create SubKategori Failed!')]]);
        } catch (\Throwable $th) {
           return back()->with(['error' => [__('Create SubKategori Error!')]]);
        }
    }
     public function update(UpdateSubKategoriRequest $request)
    {
        try {
        $service = (new UpdateSubKategori($request))->call();
          if($service){
            return back()->with(['success' => [__('SubKategori updated successfully!')]]);
          }
           return back()->with(['error' => [__('Update SubKategori Failed!')]]);
        } catch (\Throwable $th) {
           return back()->with(['error' => [__('Update SubKategori Failed!')]]);
        }
    }
    public function delete(DeleteSubKategoriRequest $request)
    {
        try {
          $service = (new DeleteSubKategori($request))->call();
          if($service){
             return back()->with(['success' => [__('SubKategori Delete successfully!')]]);
          }
            return back()->with(['error' => [__('SubKategori Delete Failed')]]);
        } catch (\Throwable $th) {
            return back()->with(['error' => [__('Something Went Wrong! Please Try Again.')]]);
        }
    }
}
