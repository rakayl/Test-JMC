@extends('admin.layouts.master')

@push('css')
<style>
    .table-area {
        background: #fff;
        border-radius: 5px;
        padding: 20px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-btn-area {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        width: 250px;
    }

    .search-wrapper input {
        width: 100%;
        height: 40px;
        padding: 8px 15px 8px 40px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        outline: none;
        font-size: 14px;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        pointer-events: none;
    }

    .btn-add-default {
        height: 40px;
        padding: 0 20px;
        background: #c91b1b;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .btn-add-default:hover {
        background: #a51616;
        color: white;
    }

    .entry-wrapper {
        margin-bottom: 15px;
    }

    .entry-wrapper select {
        width: auto;
        margin: 0 5px;
    }

    .custom-table td, 
    .custom-table th {
        text-align: left !important;
        padding: 12px;
    }
</style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',[
        'breadcrumbs' => [
            [
                'name' => __("Dashboard"),
                'url' => setRoute("home"),
            ]
        ], 
        'active' => __("Barang Masuk")
    ])
@endsection

@section('content')
<div class="table-area">
    <div class="table-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="title mb-0">{{ __("All Kategori") }}</h5>
            <div class="d-flex gap-3 align-items-center">
                @include('admin.components.link.add-default',[
                    'href' => setRoute('barang.create'),
                    'class' => "modal-btn",
                    'text' => __('Tambah Data'),
                    'permission' => "barang.create"
                ])
            </div>
        </div>

        <div class="table-responsive">
            <div class="entry-wrapper d-flex align-items-center">
                <form action="{{ Route('barang.index') }}" method="GET" class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    <input type="hidden" name="subkategori" value="{{ request('subkategori') }}">
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                  
                    <select name="length" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                        <option value="10" {{ request('length') == '10' ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('length') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('length') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('length') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                    <select  class="form--control" id="kategori" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $value)
                            <option @if(request('kategori')==$value->id) selected @endif value="{{$value->id}}">{{$value->name_kategori}}</option>
                        @endforeach
                    </select>
                <select class="form--control" id="subkategori" required disabled >
                            <option value="">Pilih Subkategori</option>
                        </select>
                    <select class="form--control" id="tahun" onchange="handleTahun(this.value)" name="tahun">
                        <option value="">Select Year</option>
                        <!-- Options will be added by JavaScript -->
                    </select>
                    <input type="text" class="form--control" 
                           id="searchInput" 
                           placeholder="Search" 
                           value="{{ request('search') }}"
                           oninput="handleSearch(this.value)">
                </form>
                <form action="{{ Route('barang.export') }}"class="d-flex align-items-center">
                    @csrf
                    @method("POST")
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    <input type="hidden" name="subkategori" value="{{ request('subkategori') }}">
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                  <button type="submit" class="btn--base " >Download</button>
                </form>
            </div>
            @include('barang.table',compact("data"))
        </div>
        {{ get_paginate($data) }}
    </div>
</div>

@endsection

@push('script')
<script>
    
    
    const yearSelect = document.getElementById('tahun');
    const currentYear = new Date().getFullYear();
    const range = 30; // +/- 20 years from current year

    for (let i = currentYear - range; i <= currentYear + range; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        yearSelect.appendChild(option);
    }
    
     <?php if(request('tahun')){ ?>
                yearSelect.value='{{ request('tahun') }}';
        <?php } ?>
    var search='';
    var kategori='';
    var subkategori='';
    var tahun='';
    
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(request('kategori')){ ?>
                kategori={{request('kategori')}};
        <?php } ?>
        <?php if(request('search')){ ?>
                search='{{request('search')}}';
        <?php } ?>
        <?php if(request('subkategori')){ ?>
                subkategori='{{request('subkategori')}}';
        <?php } ?>
        <?php if(request('tahun')){ ?>
                tahun='{{ request('tahun') }}';
        <?php } ?>
        const kategoriSelect = document.getElementById('kategori');
        const subkategoriSelect = document.getElementById('subkategori');
        <?php if(request('kategori')){ ?>
            kategoriSelect.value = {{request('kategori')??null}};
            const event = new Event('change');
            kategoriSelect.dispatchEvent(event);
            kategorisUpdate({{request('kategori')}});
        <?php } ?>
            kategoriSelect.addEventListener('change', function() {
                kategori = this.value;
                subkategoriSelect.innerHTML = '<option value="">Pilih Subkategori</option>';
                subkategoriSelect.disabled = true;
                if (kategori) {
                    // Tampilkan loading
                    
                    // Fetch data subkategori dari endpoint
                    fetch(`/barang/kategori/${kategori}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Sembunyikan loading
                            
                            if (data && data.length > 0) {
                                subkategoriSelect.disabled = false;
                                data.forEach(function(item) {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.nama_sub_kategori;
                                    subkategoriSelect.appendChild(option);
                                });
                            } else {
                                alert('Tidak ada subkategori untuk kategori ini');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching subcategories:', error);
                            loadingSubkategori.style.display = 'none';
                            alert('Gagal memuat data subkategori');
                        });
                }else{
                    var em = '';
                    handleSubkategori(em);
                }
            });
            
        
             function kategorisUpdate(value) {
                  kategori = value;
                subkategoriSelect.innerHTML = '<option value="">Pilih Subkategori</option>';
                subkategoriSelect.disabled = true;
               
                if (kategori) {
                    // Tampilkan loading
                    // Fetch data subkategori dari endpoint
                    fetch(`/barang/kategori/${kategori}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Sembunyikan loading
                            if (data && data.length > 0) {
                                subkategoriSelect.disabled = false;
                                data.forEach(function(item) {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.nama_sub_kategori;
                                    subkategoriSelect.appendChild(option);
                                        <?php if(request('subkategori')){ ?>
                                             const sevent = new Event('change');
                                            subkategoriSelect.value = {{request('subkategori')??null}};     
                                            subkategoriSelect.dispatchEvent(sevent);
                                        <?php } ?>
                                   
                                });
                            } else {
                                alert('Tidak ada subkategori untuk kategori ini');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching subcategories:', error);
                            loadingSubkategori.style.display = 'none';
                            alert('Gagal memuat data subkategori');
                        });
                }
             }
        subkategoriSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if(subkategori != selectedOption.value){
                    handleSubkategori(selectedOption.value);
                }
            });
     
})
        function handleSubkategori(value) {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                const currentUrl = new URL(window.location.href);
                subkategori = value;
                currentUrl.searchParams.set('kategori', kategori);
                currentUrl.searchParams.set('subkategori', subkategori);
                currentUrl.searchParams.set('tahun', tahun);
                currentUrl.searchParams.set('search', search);
                window.location.href = currentUrl.toString();
            }, 500);
        }
        function handleSearch(value) {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                const currentUrl = new URL(window.location.href);
                search = value;
                currentUrl.searchParams.set('kategori', kategori);
                currentUrl.searchParams.set('subkategori', subkategori);
                currentUrl.searchParams.set('tahun', tahun);
                currentUrl.searchParams.set('search', search);
                window.location.href = currentUrl.toString();
            }, 500);
        }
        function handleTahun(value) {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                const currentUrl = new URL(window.location.href);
                tahun = value;
                currentUrl.searchParams.set('kategori', kategori);
                currentUrl.searchParams.set('subkategori', subkategori);
                currentUrl.searchParams.set('tahun', tahun);
                currentUrl.searchParams.set('search', search);
                window.location.href = currentUrl.toString();
            }, 500);
        }
$(document).on("click",".delete-modal-button",function() {
    var oldData = $(this).parents("tr").attr("data-item");
    var actionRoute = "{{ setRoute('barang.delete') }}";
    var target = oldData;
    var message = `{{ __("anda hendak menghapus ") }} <strong>${target}</strong>, apakah anda yakin ingin melakukannya ?`;
    var title = "ingin menghapus barang masu ini ?"
    openDeleteModal(actionRoute,target,message,"Hapus","DELETE",title);
});
$(document).on("click",".verifikasi-modal-button",function() {
    var oldData = $(this).parents("td").attr("data-detail");
    var actionRoute = "{{ setRoute('barang.status') }}";
    var target = oldData;
    var message = `{{ __("anda hendak verifikasi ") }} <strong>${target}</strong>, apakah anda yakin ingin melakukannya ?`;
    var title = "ingin verikasi barang ini ?"
    openDeleteModal(actionRoute,target,message,"Verifikasi ","POST",title);
});
</script>
@endpush
