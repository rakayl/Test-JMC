
    <div id="subkategori-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Sub Kategori') }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('subkategori.create') }}"
                    enctype="multipart/form-data">
                    @csrf
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>{{ __('Kategori') }}*</label>
                                <select class="form--control nice-select" name="kategori_id" data-old="{{ old('kategori_id') }}">
                                    <option selected disabled>{{ __('Select Kategori') }}</option>
                                    @foreach ($kategori as $va)
                                        <option value="{{ $va->id }}">({{ $va->kode_kategori }}) {{ $va->name_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Nama Sub Kategori')."*",
                                    'name'          => "nama_sub_kategori",
                                    'placeholder'   => __('Nama Sub Kategori'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>{{ __('Batas Harga') . '*' }}</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form--control @error('batas_harga') is-invalid @enderror"
                                        placeholder="{{ __('batas harga') }}" name="batas_harga"
                                        oninput="formatIndonesianNumber(this)">
                                </div>
                                @error('batas_harga')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <div
                            class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __('cancel') }}</button>
                            <button type="submit" class="btn btn--base">{{ __('Add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            openModalWhenError("subkategori-add", "#subkategori-add");

            function placeRandomPassword(clickedButton, placeInput) {
                $(clickedButton).click(function() {
                    var generateRandomPassword = makeRandomString(10);
                    $(placeInput).val(generateRandomPassword);
                });
            }
            placeRandomPassword(".rand_password_generator", ".place_random_password");
            
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
