
    <div id="admin-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add User') }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('user.create') }}"
                    enctype="multipart/form-data">
                    @csrf
                   <div class="col-xl-6 col-lg-6 form-group role-select-wrp">
                                <label>{{ __("Role") }}*</label>
                                <select class="form--control select2-auto-tokenize" name="role"  data-placeholder="{{ __('Select Role') }}">
                                        <option value="admin">Admin</option>
                                        <option value="operator">Operator</option>
                                </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Nama Lengkap')."*",
                                    'name'          => "name",
                                    'placeholder'   => __('Nama Lengkap'),
                                ])
                            </div>
                        
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Email')."*",
                                    'name'          => "email",
                                    'placeholder'   => __('Email'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __('Username')."*",
                                    'name'          => "username",
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
            openModalWhenError("admin-add", "#admin-add");

            function placeRandomPassword(clickedButton, placeInput) {
                $(clickedButton).click(function() {
                    var generateRandomPassword = makeRandomString(10);
                    $(placeInput).val(generateRandomPassword);
                });
            }
            placeRandomPassword(".rand_password_generator", ".place_random_password");
        </script>
       
    @endpush
