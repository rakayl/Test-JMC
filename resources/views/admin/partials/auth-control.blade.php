<style>
    .white-popup {
        padding:15px;
    }
    .mfp-content {
        width:400px;
    }
</style>
<script>
    $(document).on("click",".logout-btn",function(event) {
        event.preventDefault();
        var actionRoute =  "{{ setRoute('logout') }}";
        var target      = "auth()->user()->id";
        var message     = `{{ __('Anda hendak keluar dari dashboard ini apakah anda yakin ingin melakukannya') }} ?`;
        var title = `Apakah ingin Keluar`;
        openDeleteModal(actionRoute,target,message,"{{ __('Logout') }}","POST",title);
    });

    /**
     * Function for open delete modal with method DELETE
     * @param {string} URL
     * @param {string} target
     * @param {string} message
     * @returns
     */
    function openDeleteModal(URL,target,message,actionBtnText = "{{ __('Keluar') }}",method = "DELETE",title){
    if(URL == "" || target == "") {
        return false;
    }

    if(message == "") {
        message = "Are you sure to delete ?";
    }
    var method = `<input type="hidden" name="_method" value="${method}">`;
    openModalByContent(
        {
            content: `<div class="card modal-alert border-0">
                        <div class="card-body">
                            <form method="POST" action="${URL}">
                                <input type="hidden" name="_token" value="${laravelCsrf()}">
                                ${method}
                                <div class="head mb-3">
                                <h3>${title}</h3>
                                    ${message}
                                    <input type="hidden" name="target" value="${target}">
                                </div>
                                <div class="foot d-flex align-items-center justify-content-between">
                                    <button type="button" class="modal-close btn btn--info">{{ __('Kembali') }}</button>
                                    <button type="submit" class="alert-submit-btn btn btn--danger btn-loading">${actionBtnText}</button>
                                </div>
                            </form>
                        </div>
                    </div>`,
        },

    );
    }

</script>
