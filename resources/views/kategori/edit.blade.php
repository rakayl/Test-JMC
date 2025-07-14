 <div id="kategori-edit" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __("Edit Kategori") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="modal-form" method="POST" action="{{ setRoute('kategori.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Kode Kategori')."*",
                                    'name'          => "edit_kode_kategori",
                                    'placeholder'   => __('Kode Kategori'),
                                ])
                            </div>
                        
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Nama Kategori')."*",
                                    'name'          => "edit_name_kategori",
                                    'placeholder'   => __('Nama Kategori'),
                                ])
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
                openModalWhenError("kategori-edit","#kategori-edit");

                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-data"));
                    var editModal = $("#kategori-edit");
                    editModal.find("input[name=id]").val(oldData.id);
                    editModal.find("input[name=edit_kode_kategori]").val(oldData.kode_kategori);
                    editModal.find("input[name=edit_name_kategori]").val(oldData.name_kategori);
                    openModalBySelector("#kategori-edit");

                });
            </script>
            
        
        @endpush
