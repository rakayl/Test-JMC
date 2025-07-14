 <div id="subkategori-edit" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __("Edit Kategori") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="modal-form" method="POST" action="{{ setRoute('subkategori.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>{{ __('Kategori') }}*</label>
                                <select class="form--control nice-select" name="edit_kategori_id" >
                                    @foreach ($kategori as $va)
                                        <option value="{{ $va->id }}">({{ $va->kode_kategori }}) {{ $va->name_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Nama Sub Kategori')."*",
                                    'name'          => "edit_nama_sub_kategori",
                                    'placeholder'   => __('Nama Sub Kategori'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>{{ __('Batas Harga') . '*' }}</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form--control"
                                        placeholder="{{ __('batas harga') }}" name="edit_batas_harga"
                                        oninput="formatIndonesianNumber(this)">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                <button type="button" class="btn btn--danger modal-close">{{ __("cancel") }}</button>
                                <button type="submit" class="btn btn--base">{{ __("update") }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push("script")
            <script>
                openModalWhenError("subkategori-edit","#subkategori-edit");

                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-data"));
                    var editModal = $("#subkategori-edit");
                    var batas_harga = parseInt(oldData.batas_harga, 10).toLocaleString('id-ID').split(',')[0];
                    editModal.find("input[name=id]").val(oldData.id);
                    editModal.find("input[name=edit_batas_harga]").val(batas_harga);
                    editModal.find("input[name=edit_nama_sub_kategori]").val(oldData.nama_sub_kategori);
                    editModal.find("select[name=edit_kategori_id]").val(oldData.kategori_id).trigger('change');
                    openModalBySelector("#subkategori-edit");
                    
                });
            </script>
            
        
        @endpush
