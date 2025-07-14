 <div id="admin-edit" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __("Edit User") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="modal-form" method="POST" action="{{ setRoute('user.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-10-none">
                            <div class="col-xl-6 col-lg-6 form-group role-select-wrp">
                                <label>{{ __("Role") }}*</label>
                                <select class="form--control select2-auto-tokenize" name="edit_role"  data-placeholder="{{ __('Select Role') }}">
                                        <option value="admin">Admin</option>
                                        <option value="operator">Operator</option>
                                </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Nama Lengkap')."*",
                                    'name'          => "edit_name",
                                    'placeholder'   => __('Nama Lengkap'),
                                ])
                            </div>
                        
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Email')."*",
                                    'name'          => "edit_email",
                                    'placeholder'   => __('Email'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Username')."*",
                                    'name'          => "edit_username",
                                    'placeholder'   => __('Username'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>{{ __('password') . '*' }}</label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form--control place_random_password @error('password') is-invalid @enderror"
                                        placeholder="{{ __('password') }}" name="password">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                openModalWhenError("admin-edit","#admin-edit");

                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-data"));
                    var editModal = $("#admin-edit");
                    editModal.find("input[name=id]").val(oldData.id);
                    editModal.find("input[name=edit_name]").val(oldData.name);
                    editModal.find("input[name=edit_email]").val(oldData.email);
                    editModal.find("input[name=edit_username]").val(oldData.username);
                    editModal.find("select[name=edit_role]").val(oldData.role).trigger('change');
                    openModalBySelector("#admin-edit");

                });
            </script>
            
        
        @endpush
