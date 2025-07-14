@extends('admin.layouts.master')

@push('css')
    <style>
        input[type="text"], 
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .btns {
            padding: 0;
            margin: 2px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btns-tambah {
            background-color: #4CAF50;
            color: white;
        }
        .btns-hapus {
            background-color: #f44336;
            color: white;
        }
        .btns-simpan {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            display: block;
            margin: 20px auto 0;
            border-radius: 4px;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Barang Masuk"),
            'url'   => setRoute("barang.index"),
        ]
    ], 'active' => __("Barang Masuk Create")])
@endsection

@section('content')
  <form class="card-form" method="POST" enctype="multipart/form-data" action="{{ setRoute('barang.store') }}">
     @csrf
    @method("POST")
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Informasi Umum") }}</h6>
        </div>
        <div class="card-body">
                <div class="row">
                    @if(auth()->user()->hasRole('admin'))
                         <div class="row">
                                <div class="col-xl-6 col-lg-6 form-group">
                                    <label>{{ __('Operator') }}*</label>
                                    <select  class="form--control" id="user_id" name="user_id" required>
                                    <option value="">Pilih Operator</option>
                                    @foreach (operator as $va)
                                        <option value="{{ $va->id }}">{{ $va->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                    @else
                        <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}">
                    @endif
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 form-group">
                            <label>{{ __('Kategori') }}*</label>
                            <select  class="form--control" id="kategori" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <!-- Kategori akan diisi oleh JavaScript -->
                        </select>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-xl-6 col-lg-6 form-group">
                            <label>{{ __('Sub Kategori') }}*</label>
                             <select class="form--control" id="subkategori" name="sub_kategori_id" required disabled>
                                <option value="">Pilih Subkategori</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            <label>{{ __('Batasan Harga') }}*</label>
                            <input type="text" id="batasan_harga" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{ __('Asal Barang') }}*</label>
                            <input type="text" class="form--control" name="asal_barang" id="asal_barang" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 form-group">
                            <label>{{ __('Nomor Surat') }}*</label>
                            <input type="text" class="form--control" id="no_surat" name="no_surat">
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            <label>{{ __('Lampiran') }}*</label>
                            <input type="file" accept=".doc,.docx,.zip"  class="form--control" id="lampiran" name="lampiran">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Informasi Barang") }}</h6>
        </div>
        <div class="card-body">
                <div class="row" id="formPenjualan">
                     <table id="tabelBarang">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga (Rp)</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Total (Rp)</th>
                                <th>Tanggal Expired</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
               
        </div>
    </div>
    <div class="custom-card">
            <div class="row">
                        <div class="col-xl-4 col-lg-4 form-group">
                            <h6 class="title" style="text-align: right">{{ __("Total Harga Barang :") }}</h6>
                        </div>
                        <div class="col-xl-4 col-lg-4 form-group">
                            <input type="text" id="totalKeseluruhan" value="Rp 0" readonly>
                        </div>
                    </div>
    </div>
    <div class="col-xl-12 col-lg-12">
            <button type="submit" class="btns-simpan" id="submitBtn" disabled>Simpan Data</button>
     </div>
    </form>
@endsection

@push('script')
   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabelBody = document.querySelector('#tabelBarang tbody');
            const totalKeseluruhan = document.getElementById('totalKeseluruhan');
            const kategoriSelect = document.getElementById('kategori');
            const subkategoriSelect = document.getElementById('subkategori');
            const batasanHargaInput = document.getElementById('batasan_harga');
            const submitBtn = document.getElementById('submitBtn');
            
            let currentMaxPrice = 0;
            let currentTotal = 0;
            
            let counter = 1;
            
            const kategoriData = <?php echo json_encode($kategori); ?>;;
            
            // Mengisi dropdown kategori
            kategoriData.forEach(function(kategori) {
                const option = document.createElement('option');
                option.value = kategori.id;
                option.textContent = kategori.name_kategori;
                option.dataset.kode = kategori.kode_kategori;
                kategoriSelect.appendChild(option);
            });
            // Update subkategori berdasarkan kategori yang dipilih
            kategoriSelect.addEventListener('change', function() {
                const selectedKategoriId = this.value;
                subkategoriSelect.innerHTML = '<option value="">Pilih Subkategori</option>';
                subkategoriSelect.disabled = true;
                batasanHargaInput.value = '';
                currentMaxPrice = 0;
                checkSubmitButton();
                
                if (selectedKategoriId) {
                    // Tampilkan loading
                    
                    // Fetch data subkategori dari endpoint
                    fetch(`/barang/kategori/${selectedKategoriId}`)
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
                                    option.dataset.batas_harga = item.batas_harga;
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
                }
            });
            
            // Update batasan harga saat subkategori dipilih
            subkategoriSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    currentMaxPrice = parseInt(selectedOption.dataset.batas_harga);
                    batasanHargaInput.value = `Maksimal Rp ${formatNumber(currentMaxPrice)}`;
                } else {
                    batasanHargaInput.value = '';
                    currentMaxPrice = 0;
                }
                checkSubmitButton();
            });
            
            // Fungsi untuk menambahkan baris baru
            function tambahBaris(isFirstRow = false) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="text" name="nama_barang[]" required></td>
                    <td class="input-rupiah">
                        <input type="text" name="harga[]" class="harga" required 
                               oninput="formatRupiahInput(this)">
                    </td>
                    <td><input type="number" name="jumlah[]" class="jumlah" min="1" value="1" required></td>
                    <td><input type="text" name="satuan[]" required></td>
                    <td><input type="text" name="total[]" class="total" value="Rp 0" readonly></td>
                    <td><input type="date" name="expired[]"></td>
                    <td class="action-buttons">
                        ${isFirstRow ? 
                            `<button type="button" class="btns btns-tambah tambah-baris" title="Tambah Baris">+</button>` : 
                            `<button type="button" class="btns btns-hapus hapus-baris" title="Hapus Baris">-</button>`}
                    </td>
                `;
                
                tabelBody.appendChild(newRow);
                counter++;
                
                // Tambahkan event listener untuk input harga dan jumlah
                const inputs = newRow.querySelectorAll('.harga, .jumlah');
                inputs.forEach(input => {
                    input.addEventListener('input', hitungTotal);
                });
                
                // Tambahkan event listener untuk tombol tambah (hanya di baris pertama)
                if (isFirstRow) {
                    newRow.querySelector('.tambah-baris').addEventListener('click', function() {
                        // Validasi kategori dan subkategori sebelum menambah baris
                        if (!kategoriSelect.value || !subkategoriSelect.value) {
                            alert('Harap pilih kategori dan subkategori terlebih dahulu!');
                            return;
                        }
                        tambahBaris();
                    });
                }
                
                // Tambahkan event listener untuk tombol hapus (kecuali baris pertama)
                if (!isFirstRow) {
                    newRow.querySelector('.hapus-baris').addEventListener('click', function() {
                        tabelBody.removeChild(newRow);
                        hitungTotalKeseluruhan();
                        updateNomorBaris();
                        checkSubmitButton();
                    });
                }
            }
            window.formatRupiahInput = function(input) {
                // Simpan posisi kursor
                let cursorPos = input.selectionStart;
                let originalLength = input.value.length;
                
                // Hapus semua karakter non-digit
                let value = input.value.replace(/\D/g, '');
                
                // Format dengan titik sebagai pemisah ribuan
                if (value.length > 0) {
                    value = parseInt(value, 10).toLocaleString('id-ID');
                }
                
                // Set nilai kembali ke input
                input.value = value;
                
                // Sesuaikan posisi kursor
                let newLength = input.value.length;
                let lengthDiff = newLength - originalLength;
                
                if (cursorPos >= originalLength) {
                    input.setSelectionRange(newLength, newLength);
                } else {
                    input.setSelectionRange(cursorPos + lengthDiff, cursorPos + lengthDiff);
                }
                
                // Hitung total
                hitungTotal.call(input);
            };
             function getNumericValue(rupiahInput) {
                return parseInt(rupiahInput.replace(/\D/g, '')) || 0;
            }
            
            // Fungsi untuk validasi harga sesuai batasan subkategori
            function validatePrice(inputElement) {
                const selectedOption = subkategoriSelect.options[subkategoriSelect.selectedIndex];
                if (!selectedOption.value) return;
                
                const maxPrice = parseInt(selectedOption.dataset.batas_harga);
                const enteredPrice = getNumericValue(inputElement.value);
                
                if (enteredPrice > maxPrice) {
                    alert(`Harga tidak boleh melebihi Rp ${formatNumber(maxPrice)}`);
                    inputElement.value = formatNumber(maxPrice);
                    inputElement.focus();
                    hitungTotal.call(inputElement);
                }
            }
            // Fungsi untuk menghitung total per baris
            function hitungTotal() {
                const row = this.closest('tr');
                const harga = parseFloat(row.querySelector('.harga').value) || 0;
                const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
                const total = harga * jumlah;
                
                row.querySelector('.total').value = formatRupiah(total);
                hitungTotalKeseluruhan();
                checkSubmitButton();
            }
            
            // Fungsi untuk menghitung total keseluruhan
                function hitungTotal() {
                const row = this.closest('tr');
                const harga = getNumericValue(row.querySelector('.harga').value);
                const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
                const total = harga * jumlah;
                
                row.querySelector('.total').value = formatRupiah(total);
                hitungTotalKeseluruhan();
                checkSubmitButton();
            }
              function hitungTotalKeseluruhan() {
                let total = 0;
                document.querySelectorAll('.total').forEach(input => {
                    total += getNumericValue(input.value);
                });
                
                currentTotal = total;
                totalKeseluruhan.value = formatRupiah(total);
            }
            
            
            // Fungsi untuk memeriksa tombol submit
            function checkSubmitButton() {
                if (currentMaxPrice > 0 && currentTotal > currentMaxPrice) {
                    submitBtn.disabled = true;
                } else {
                    submitBtn.disabled = false;
                  
                }
                
                // Juga nonaktifkan jika belum memilih kategori/subkategori
                if (!kategoriSelect.value || !subkategoriSelect.value) {
                    submitBtn.disabled = true;
                }
            }
            
            // Fungsi untuk format rupiah
            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            // Fungsi untuk format number (tanpa Rp)
            function formatNumber(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            // Fungsi untuk update nomor baris
            function updateNomorBaris() {
                const rows = tabelBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    row.cells[0].textContent = index + 1;
                });
                counter = rows.length + 1;
            }
            
            // Event listener untuk form submit
            document.getElementById('formPenjualan').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validasi form (kecuali tanggal expired)
                let isValid = true;
                const requiredFields = document.querySelectorAll('input[required], select[required]');
                
                requiredFields.forEach(input => {
                    if (!input.value) {
                        input.style.borderColor = 'red';
                        isValid = false;
                    } else {
                        input.style.borderColor = '#ddd';
                    }
                });
                
                // Validasi kategori dan subkategori
                if (!kategoriSelect.value || !subkategoriSelect.value) {
                    alert('Harap pilih kategori dan subkategori!');
                    isValid = false;
                }
                
                // Validasi total harga
                if (currentTotal > currentMaxPrice) {
                    alert('Total harga melebihi batasan yang ditentukan!');
                    isValid = false;
                }
                
                if (isValid) {
                    // Proses data (contoh: tampilkan di console)
                    const formData = new FormData(this);
                    const selectedKategori = kategoriSelect.options[kategoriSelect.selectedIndex];
                    const selectedSubkategori = subkategoriSelect.options[subkategoriSelect.selectedIndex];
                    
                    const data = {
                        kategori_id: selectedKategori.value,
                        kategori: selectedKategori.text,
                        kode_kategori: selectedKategori.dataset.kode,
                        subkategori_id: selectedSubkategori.value,
                        subkategori: selectedSubkategori.text,
                        batas_harga: currentMaxPrice,
                        total_harga: currentTotal,
                        items: []
                    };
                    
                    // Mengumpulkan data barang
                    const namaBarang = formData.getAll('nama_barang[]');
                    const harga = formData.getAll('harga[]');
                    const jumlah = formData.getAll('jumlah[]');
                    const satuan = formData.getAll('satuan[]');
                    const expired = formData.getAll('expired[]');
                    const total = formData.getAll('total[]');
                    
                    for (let i = 0; i < namaBarang.length; i++) {
                        data.items.push({
                            nama_barang: namaBarang[i],
                            harga: harga[i],
                            jumlah: jumlah[i],
                            satuan: satuan[i],
                            expired: expired[i],
                            total: total[i]
                        });
                    }
                    
                    console.log('Data yang dikirim:', data);
                    alert('Data berhasil disimpan!\nKategori: ' + data.kategori + 
                          '\nSubkategori: ' + data.subkategori +
                          '\nBatas Harga: Rp ' + formatNumber(data.batas_harga) +
                          '\nTotal Harga: ' + formatRupiah(data.total_harga));
                } else {
                    alert('Harap lengkapi semua field yang wajib diisi dan pastikan total harga sesuai batasan!');
                }
            });
            
            // Tambahkan baris pertama saat halaman dimuat
            tambahBaris(true);
        });
          function formatIndonesianNumber(input) {
            // Simpan posisi kursor
            let cursorPos = input.selectionStart;
            let originalLength = input.value.length;
            
            // Hapus semua karakter kecuali angka dan koma
            let value = input.value.replace(/[^\d,]/g, '');
            
            // Pastikan hanya ada satu koma desimal
            let commaCount = (value.match(/,/g) || []).length;
            if (commaCount > 1) {
                value = value.replace(/,+$/, '');
            }
            
            // Pisahkan bagian desimal
            let parts = value.split(',');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? ',' + parts[1] : '';
            
            // Format bagian integer dengan titik sebagai pemisah ribuan
            if (integerPart.length > 0) {
                integerPart = parseInt(integerPart, 10).toLocaleString('id-ID').split(',')[0];
            }
            
            // Gabungkan kembali
            value = integerPart + decimalPart;
            
            // Set nilai baru ke input
            input.value = value;
            
            // Sesuaikan posisi kursor
            let newLength = input.value.length;
            let lengthDiff = newLength - originalLength;
            
            if (cursorPos >= originalLength) {
                input.selectionStart = input.selectionEnd = newLength;
            } else {
                input.selectionStart = input.selectionEnd = cursorPos + lengthDiff;
            }
            
            // Validasi
            validateInput(input);
        }
        
        function validateInput(input) {
            const errorElement = document.getElementById('jumlahError');
            const rawValue = input.value.replace(/\./g, '').replace(',', '.');
            
            if (input.value === '') {
                errorElement.textContent = 'Harap masukkan jumlah';
            } else if (isNaN(parseFloat(rawValue))) {
                errorElement.textContent = 'Format angka tidak valid';
            } else {
                errorElement.textContent = '';
            }
        }
    </script>
@endpush
