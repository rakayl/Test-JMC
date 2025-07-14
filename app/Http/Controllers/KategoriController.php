<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Response;

//model
use App\Models\Kategori;

//service
use App\Services\Kategori\StoreKategori;
use App\Services\Kategori\UpdateKategori;
use App\Services\Kategori\DeleteKategori;

//request
use App\Http\Requests\Kategori\StoreKategoriRequest;
use App\Http\Requests\Kategori\UpdateKategoriRequest;
use App\Http\Requests\Kategori\DeleteKategoriRequest;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function index(Request $request)
    {
        $page_title = "All Kategori";
        $perpage = $request->input('length', 10);
        $data = Kategori::when($request->search, function($query, $search) {
                $searchTerms = explode(' ', $search); // Memecah kata pencarian
                return $query->where(function($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where(function($subQ) use ($term) {
                                $subQ->where('kode_kategori', 'like', "%{$term}%")
                                ->orWhere('name_kategori', 'like', "%{$term}%");
                        });
                    }
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perpage)
            ->withQueryString();
        return view('kategori.index', compact(
            'page_title',
            'data'
        ));
    }
    public function create(StoreKategoriRequest $request)
    {
        try {
          $service = (new StoreKategori($request))->call();
          if($service){
            return back()->with(['success' => [__('Kategori created successfully!')]]);
          }
           return back()->with(['error' => [__('Create Kategori Failed!')]]);
        } catch (\Throwable $th) {
           return back()->with(['error' => [__('Create Kategori Error!')]]);
        }
    }
     public function update(UpdateKategoriRequest $request)
    {
        try {
         $service = (new UpdateKategori($request))->call();
          if($service){
            return back()->with(['success' => [__('Kategori updated successfully!')]]);
          }
           return back()->with(['error' => [__('Update Kategori Failed!')]]);
        } catch (\Throwable $th) {
           return back()->with(['error' => [__('Update Kategori Failed!')]]);
        }
    }
    public function delete(DeleteKategoriRequest $request)
    {
        try {
          $service = (new DeleteKategori($request))->call();
          if($service){
             return back()->with(['success' => [__('Kategori Delete successfully!')]]);
          }
            return back()->with(['error' => [__('Kategori Delete Failed')]]);
        } catch (\Throwable $th) {
            return back()->with(['error' => [__('Something Went Wrong! Please Try Again.')]]);
        }
    }
}
