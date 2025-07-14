<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HtmlTemplateExport;

//model
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\SubKategori;
use App\Models\User;

//service
use App\Services\Barang\StoreBarang;
use App\Services\Barang\UpdateBarang;
use App\Services\Barang\DeleteBarang;
use App\Services\Barang\StatusBarang;

//request
use App\Http\Requests\Barang\StoreBarangRequest;
use App\Http\Requests\Barang\UpdateBarangRequest;
use App\Http\Requests\Barang\StatusRequest;
use App\Http\Requests\Barang\DeleteRequest;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function index(Request $request)
    {
        $page_title = "All Barang Masuk";
        $perpage = $request->input('length', 10);
        $data = BarangMasuk::with('detail','user','kategori','subkategori')
              ->join('kategoris', 'barang_masuks.kategori_id', '=', 'kategoris.id')
              ->join('sub_kategoris', 'barang_masuks.sub_kategori_id', '=', 'sub_kategoris.id')
              ->when($request->search, function($query, $search) {
                    $searchTerms = explode(' ', $search); // Memecah kata pencarian
                    return $query->where(function($q) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $q->where(function($subQ) use ($term) {
                                    $subQ->where('asal_barang', 'like', "%{$term}%")
                                    ->orWhere('nama_sub_kategori', 'like', "%{$term}%");
                            });
                        }
                    });
                })
              ->when($request->kategori, function($query, $search) {
                    $query->where('barang_masuks.kategori_id',$search);
                })
              ->when($request->subkategori, function($query, $search) {
                    $query->where('barang_masuks.kategori_id',$search);
                })
              ->when($request->tahun, function($query, $search) {
                    $query->whereYear('barang_masuks.created_at',$search);
                })
          ->select('barang_masuks.*')
          ->orderBy('barang_masuks.id', 'desc')
          ->paginate($perpage)
          ->withQueryString();
          
        $kategori = Kategori::all();
        return view('barang.index', compact(
            'page_title',
            'data',
            'kategori',
        ));
    }
    public function export(Request $request)
    {
        $filename = 'users-export-' . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
        
        return Excel::download(new HtmlTemplateExport($request), $filename);
    }
    public function create()
    {
        $page_title = "Create Barang Masuk";
        $operator = User::role('operator')
            ->orderBy('id', 'desc')
            ->get();
        $kategori = Kategori::all();
        return view('barang.create', compact(
            'page_title',
            'kategori',
            'operator'
        ));
    }
     public function store(StoreBarangRequest $request)
    {
        try {
         $service = (new StoreBarang($request))->call();
          if($service){
            return redirect('barang_index')->with(['success' => [__('Kategori updated successfully!')]]);
          }
           return back()->with(['error' => [__('Update Kategori Failed!')]]);
        } catch (\Throwable $th) {
           return back()->with(['error' => [__('Update Kategori Failed!')]]);
        }
    }
     public function update($id)
    {
        $page_title = "Update Barang Masuk";
        $operator = User::role('operator')
            ->orderBy('id', 'desc')
            ->get();
        $data = BarangMasuk::with('detail','user','kategori','subkategori')
                ->where('id',$id)
                ->first();
        $kategori = Kategori::all();
        return view('barang.update', compact(
            'page_title',
                'data',
            'kategori',
            'operator'
        ));
    }
     public function edit(UpdateBarangRequest $request,$id)
    {
        try {
         $service = (new UpdateBarang($request,$id))->call();
          if($service){
            return back()->with(['success' => [__('Verifikasi successfully!')]]);
          }
           return back()->with(['error' => [__('Verifikasi Failed!')]]);
        } catch (\Throwable $th) {
           return back()->with(['error' => [__('Something Went Wrong! Please Try Again!')]]);
        }
    }
    public function delete(DeleteRequest $request)
    {
        try {
          $service = (new DeleteBarang($request))->call();
          if($service){
             return back()->with(['success' => [__('Barang Masuk Delete successfully!')]]);
          }
            return back()->with(['error' => [__('Barang Masuk Delete Failed')]]);
        } catch (\Throwable $th) {
            return back()->with(['error' => [__('Something Went Wrong! Please Try Again.')]]);
        }
    }
    public function status(statusRequest $request)
    {
        try {
          $service = (new StatusBarang($request))->call();
          if($service){
             return back()->with(['success' => [__('Verifikasi successfully!')]]);
          }
            return back()->with(['error' => [__('Verifikasi Failed')]]);
        } catch (\Throwable $th) {
            return back()->with(['error' => [__('Something Went Wrong! Please Try Again.')]]);
        }
    }
    public function subkategori($id)
    {
        return SubKategori::where('kategori_id',$id)->get();
    }
}
