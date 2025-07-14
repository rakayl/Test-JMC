<!-- notify js -->
<script src='{{ asset('public/backend/js/bootstrap-notify.js') }}'></script>

<script>
    // Show Laravel Error Messages----------------------------------------------
    $(function () {
        $(document).ready(function(){
            @if (session('error'))
                @if (is_array(session('error')))
                    @foreach (session('error') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-exclamation-triangle',
                            },
                            {
                                type: "danger",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif (session('success'))
                @if (is_array(session('success')))
                    @foreach (session('success') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-check-circle',
                            },
                            {
                                type: "success",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif (session('warning'))
                @if (is_array(session('warning')))
                    @foreach (session('warning') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-exclamation-triangle',
                            },
                            {
                                type: "warning",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif ($errors->any())
                @foreach ($errors->all() as $item)
                    $.notify(
                        {
                            title: "",
                            message: "{{ __($item) }}",
                            icon: 'las la-exclamation-triangle',
                        },
                        {
                            type: "danger",
                            allow_dismiss: true,
                            delay: 5000,
                            placement: {
                            from: "top",
                            align: "right"
                            },
                        }
                    );
                @endforeach
            @endif
        });
    });
    //--------------------------------------------z------------------------------

    // Function for throw error messages from javascript------------------------
    function throwMessage(type,errors = []) {
        if(type == 'error') {
            $.each(errors,function(index,item) {
                $.notify(
                    {
                        title: "",
                        message: item,
                        icon: 'las la-exclamation-triangle',
                    },
                    {
                        type: "danger",
                        allow_dismiss: true,
                        delay: 5000,
                        placement: {
                        from: "top",
                        align: "right"
                        },
                    }
                );
            });
        }else if(type == 'success') {
            $.each(errors,function(index,item) {
                $.notify(
                    {
                        title: "",
                        message: item,
                        icon: 'las la-check-circle',
                    },
                    {
                        type: "success",
                        allow_dismiss: true,
                        delay: 5000,
                        placement: {
                        from: "top",
                        align: "right"
                        },
                    }
                );
            });
        }else if(type == 'warning') {
            $.each(errors,function(index,item) {
                $.notify(
                    {
                        title: "",
                        message: item,
                        icon: 'las la-check-circle',
                    },
                    {
                        type: "warning",
                        allow_dismiss: true,
                        delay: 5000,
                        placement: {
                        from: "top",
                        align: "right"
                        },
                    }
                );
            });
        }

    }
    //--------------------------------------------------------------------------

    function notification(type,message){
        $.notify(
            {
                title: "",
                message: message,
                icon: 'las la-exclamation-triangle',
            },
            {
                type: type,
                allow_dismiss: true,
                delay: 5000,
                placement: {
                from: "top",
                align: "right"
                },
            }
        );
    }

    // Function for set modal session value --------------------
    var validationSession = null;
    function getSessionValue(sesesionValue = null) {
        validationSession = sessionValue;
    }

    @if (session('modal'))
        var sessionValue = "{{ session('modal') }}";
        getSessionValue(sessionValue);
    @endif

    // Function for open modal/popup when have backend session
    function openModalWhenError(sessionValue,modalSelector) {
        if(validationSession != sessionValue) {
            return false;
        }
        openModalBySelector(modalSelector);
    }
    //----------------------------------------------------------



    // State Select Get Cities

</script>
