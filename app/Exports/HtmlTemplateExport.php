<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HtmlTemplateExport implements FromView
{
    protected $year;

    public function __construct($request = null)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = BarangMasuk::query();
        
        if ($this->request) {
           $query->with('detail','user','kategori','subkategori')
              ->join('kategoris', 'barang_masuks.kategori_id', '=', 'kategoris.id')
              ->join('sub_kategoris', 'barang_masuks.sub_kategori_id', '=', 'sub_kategoris.id')
              ->when($this->request->search, function($query, $search) {
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
              ->when($this->request->kategori, function($query, $search) {
                    $query->where('barang_masuks.kategori_id',$search);
                })
              ->when($this->request->subkategori, function($query, $search) {
                    $query->where('barang_masuks.kategori_id',$search);
                })
              ->when($this->request->tahun, function($query, $search) {
                    $query->whereYear('barang_masuks.created_at',$search);
                })
          ->select('barang_masuks.*')
          ->orderBy('barang_masuks.id', 'desc');
        }

        return view('barang.export', [
            'data' => $query->get()
        ]);
    }
}