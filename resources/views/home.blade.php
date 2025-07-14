<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penjualan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .category-selector {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #e9f7ef;
            border-radius: 5px;
        }
        .category-group {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        .category-box {
            flex: 1;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .btn {
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
        .btn-tambah {
            background-color: #4CAF50;
            color: white;
        }
        .btn-hapus {
            background-color: #f44336;
            color: white;
        }
        .btn-simpan {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            display: block;
            margin: 20px auto 0;
            border-radius: 4px;
        }
        .btn-simpan:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .total-container {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .price-limit {
            background-color: #fff8e1;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,.3);
            border-radius: 50%;
            border-top-color: #000;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .input-rupiah {
            position: relative;
        }
        .input-rupiah::before {
            content: 'Rp ';
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }
        .input-rupiah input {
            padding-left: 30px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Form Penjualan Barang</h2>
        
        <!-- Category Selector Outside Table -->
        <div class="category-selector">
            <div class="category-group">
                <div class="category-box">
                    <label for="kategori">Kategori:</label>
                    <select id="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <!-- Kategori akan diisi oleh JavaScript -->
                    </select>
                </div>
                <div class="category-box">
                    <label for="subkategori">Subkategori:</label>
                    <select id="subkategori" name="subkategori" required disabled>
                        <option value="">Pilih Subkategori</option>
                    </select>
                    <span id="loading-subkategori" style="display:none;"><span class="loading"></span> Memuat...</span>
                </div>
            </div>
            <div class="price-limit">
                <label for="batasan_harga">Batasan Harga untuk Subkategori:</label>
                <input type="text" id="batasan_harga" readonly>
                <div id="error-message" class="error-message">Total harga melebihi batasan yang ditentukan!</div>
            </div>
        </div>

        <form id="formPenjualan">
            <table id="tabelBarang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga (Rp)</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tanggal Expired</th>
                        <th>Total (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris akan ditambahkan secara dinamis -->
                </tbody>
            </table>
            
            <div class="total-container">
                <label>Total Keseluruhan: </label>
                <input type="text" id="totalKeseluruhan" value="Rp 0" readonly>
            </div>
            
            <button type="submit" class="btn-simpan" id="submitBtn" disabled>Simpan Data</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabelBody = document.querySelector('#tabelBarang tbody');
            const totalKeseluruhan = document.getElementById('totalKeseluruhan');
            const kategoriSelect = document.getElementById('kategori');
            const subkategoriSelect = document.getElementById('subkategori');
            const batasanHargaInput = document.getElementById('batasan_harga');
            const submitBtn = document.getElementById('submitBtn');
            const errorMessage = document.getElementById('error-message');
            const loadingSubkategori = document.getElementById('loading-subkategori');
            
            let currentMaxPrice = 0;
            let currentTotal = 0;
            
            // Data kategori contoh
            const kategoriData = [
                {"id":3,"kode_kategori":"ATK","name_kategori":"Alat Tulis Kantor","created_at":"2025-07-09T16:01:27.000000Z","updated_at":"2025-07-09T16:01:27.000000Z"}
            ];
            
            // Mengisi dropdown kategori
            kategoriData.forEach(function(kategori) {
                const option = document.createElement('option');
                option.value = kategori.id;
                option.textContent = kategori.name_kategori;
                option.dataset.kode = kategori.kode_kategori;
                kategoriSelect.appendChild(option);
            });
            
            let counter = 1;
            
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
                    loadingSubkategori.style.display = 'inline-block';
                    
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
                            loadingSubkategori.style.display = 'none';
                            
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
                    <td>${counter}</td>
                    <td><input type="text" name="nama_barang[]" required></td>
                    <td class="input-rupiah">
                        <input type="text" name="harga[]" class="harga" required 
                               oninput="formatRupiahInput(this)">
                    </td>
                    <td><input type="number" name="jumlah[]" class="jumlah" min="1" value="1" required></td>
                    <td>
                        <select name="satuan[]" required>
                            <option value="pcs">pcs</option>
                            <option value="kg">kg</option>
                            <option value="liter">liter</option>
                            <option value="pack">pack</option>
                            <option value="dus">dus</option>
                        </select>
                    </td>
                    <td><input type="date" name="expired[]"></td>
                    <td><input type="text" name="total[]" class="total" value="Rp 0" readonly></td>
                    <td class="action-buttons">
                        ${isFirstRow ? 
                            `<button type="button" class="btn btn-tambah tambah-baris" title="Tambah Baris">+</button>` : 
                            `<button type="button" class="btn btn-hapus hapus-baris" title="Hapus Baris">-</button>`}
                    </td>
                `;
                
                tabelBody.appendChild(newRow);
                counter++;
                
                // Tambahkan event listener untuk input harga dan jumlah
                const hargaInput = newRow.querySelector('.harga');
                const jumlahInput = newRow.querySelector('.jumlah');
                
                hargaInput.addEventListener('input', function() {
                    hitungTotal.call(this);
                    validatePrice(this);
                });
                
                jumlahInput.addEventListener('input', hitungTotal);
                
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
            
            // Fungsi untuk format input Rupiah
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
            
            // Fungsi untuk mendapatkan nilai numerik dari input Rupiah
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
                const harga = getNumericValue(row.querySelector('.harga').value);
                const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
                const total = harga * jumlah;
                
                row.querySelector('.total').value = formatRupiah(total);
                hitungTotalKeseluruhan();
                checkSubmitButton();
            }
            
            // Fungsi untuk menghitung total keseluruhan
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
                    errorMessage.style.display = 'block';
                } else {
                    submitBtn.disabled = false;
                    errorMessage.style.display = 'none';
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
                    const harga = formData.getAll('harga[]').map(val => getNumericValue(val));
                    const jumlah = formData.getAll('jumlah[]');
                    const satuan = formData.getAll('satuan[]');
                    const expired = formData.getAll('expired[]');
                    const total = formData.getAll('total[]').map(val => getNumericValue(val));
                    
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
    </script>
</body>
</html>