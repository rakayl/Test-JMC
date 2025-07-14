<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($page_title) ? __($page_title) : __("Admin")) }}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('icon.png') }}" type="image/x-icon">
    <link href="//fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/fontawesome-all.css') }}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/bootstrap.css') }}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/line-awesome.css') }}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/animate.css') }}">
    <!-- nice select css -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/nice-select.css') }}">
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/select2.css') }}">
    <!-- rte css -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/rte_theme_default.css') }}">
    <!-- Popup  -->
    <link rel="stylesheet" href="{{ asset('public/backend/library/popup/magnific-popup.css') }}">
    <!-- Light case   -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/lightcase.css') }}">

    <!-- Fileholder CSS CDN -->
    <link rel="stylesheet" href="https://cdn.appdevs.net/fileholder/v1.0/css/fileholder-style.css" type="text/css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
    <style>
        .fileholder-single-file-view{
            min-width: 130px;
        }
        .dashboard-title-part .left .icon {
            background-color:rgb(0 0 0 / 45%);
        }
        .sidebar {
            width:280px;
        }

        .body-wrapper {
            padding-left:330px;
        }

        .navbar-wrapper {
            margin-left:315px;
        }

        .dataTables_length {
            margin-bottom: 15px;
        }

        .dataTables_length select {
            width: auto;
            display: inline-block;
        }

        /* Untuk memastikan alignment yang tepat */
        .dataTables_length.d-flex {
            gap: 5px;
        }

        /* Styling untuk select box */
        .dataTables_length .form-select-sm {
            min-width: 80px;
            height: 30px;
            padding: 0.25rem 1.5rem 0.25rem 0.5rem;
        }
        </style>

    @stack('css')
</head>
<body>

<div class="page-wrapper">
    <div id="body-overlay" class="body-overlay"></div>
    @include('admin.partials.right-settings')
    @include('admin.partials.side-nav-mini')
    @include('admin.partials.side-nav')
    <div class="main-wrapper">
        <div class="main-body-wrapper">
            <nav class="navbar-wrapper" style="background-color:#BA181B;">
                <div class="dashboard-title-part">
                    @yield('page-title')
                    @yield('breadcrumb')
                </div>
            </nav>
            <div class="body-wrapper">
                @yield('content')
            </div>
        </div>
        @include('admin.partials.footer')
    </div>
</div>->

<!-- jquery -->
<script src="{{ asset('public/backend/js/jquery-3.5.1.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('public/backend/js/bootstrap.bundle.js') }}"></script>
<!-- easypiechart js -->
<script src="{{ asset('public/backend/js/jquery.easypiechart.js') }}"></script>
<!-- apexcharts js -->
<!--<script src="{{ asset('public/backend/js/apexcharts.js') }}"></script>-->
<!-- chart js -->
<script src="{{ asset('public/backend/js/chart.js') }}"></script>
<!-- nice select js -->
<script src="{{ asset('public/backend/js/jquery.nice-select.js') }}"></script>
<!-- select2 js -->
<script src="{{ asset('public/backend/js/select2.js') }}"></script>
<!-- rte js -->
<script src="{{ asset('public/backend/js/rte.js') }}"></script>
<!-- rte plugins js -->
<script src='{{ asset('public/backend/js/all_plugins.js') }}'></script>
<!--  Popup -->
<script src="{{ asset('public/backend/library/popup/jquery.magnific-popup.js') }}"></script>
<!--  ligntcase -->
<script src="{{ asset('public/backend/js/lightcase.js') }}"></script>
<!--  Rich text Editor JS -->
<script src="{{ asset('public/backend/js/ckeditor.js') }}"></script>
<!-- main -->
<script src="{{ asset('public/backend/js/main.js') }}"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
@include('admin.partials.notify')
@include('admin.partials.auth-control')

<script>
    var fileHolderAfterLoad = {};
</script>

<script src="https://appdevs.cloud/cdn/fileholder/v1.0/js/fileholder-script.js" type="module"></script>
<script type="module">
    import { fileHolderSettings } from "https://appdevs.cloud/cdn/fileholder/v1.0/js/fileholder-settings.js";
    import { previewFunctions } from "https://appdevs.cloud/cdn/fileholder/v1.0/js/fileholder-script.js";

    var inputFields = document.querySelector(".file-holder");
    fileHolderAfterLoad.previewReInit = function(inputFields){
        previewFunctions.previewReInit(inputFields)
    };

    fileHolderSettings.urls.uploadUrl = "";
    fileHolderSettings.urls.removeUrl = "";

</script>

<script>
    function fileHolderPreviewReInit(selector) {
        var inputField = document.querySelector(selector);
        fileHolderAfterLoad.previewReInit(inputField);
    }
</script>

<script>
    // lightcase
    $(window).on('load', function () {
      $("a[data-rel^=lightcase]").lightcase();
    })
</script>

<script>
    // fullscreen-bar
    let elem = document.documentElement;
    function openFullscreen() {
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) {
      elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
      }
    }

    function closeFullscreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }

    $('.header-fullscreen-bar').on('click', function(){
      $(this).toggleClass('active');
      $('.body-overlay').removeClass('active');
    });
</script>


@stack('script')

</body>
<script>
        $(document).ready(function () {
    var table = $('#datatables').DataTable({
        responsive: true,
        dom: 'lrtip', // Hilangkan pencarian global
        lengthMenu: [10, 25, 50, 100], // Dropdown untuk memilih jumlah entri
        pageLength: 10, // Default jumlah entri per halaman
        serverSide: true,
        processing: true, // Indikator loading
        ajax: {
            url: '/users/driver-care', // Endpoint API
            type: 'GET', // HTTP method
            data: function (d) {
                d.per_page = d.length; // Kirim panjang halaman
            },
        },
        columns: [
            { data: 'id', name: 'id', title: 'ID' }, // Kolom ID
            { data: 'fullname', name: 'fullname', title: 'Nama Lengkap' }, // Kolom Nama
            { data: 'email', name: 'email', title: 'Email' }, // Kolom Email
            { data: 'kabupaten', name: 'kabupaten', title: 'Kabupaten' }, // Kolom Kabupaten
            { 
                data: 'created_at', 
                name: 'created_at', 
                title: 'Tanggal Daftar',
                render: function (data) {
                    return new Date(data).toLocaleDateString('id-ID'); // Format tanggal
                },
            },
            {
                data: 'status',
                name: 'status',
                title: 'Status',
                render: function (data) {
                    return data === 1 
                        ? '<span class="badge badge-success">Aktif</span>' 
                        : '<span class="badge badge-danger">Tidak Aktif</span>'; // Status
                },
            },
        ],
        language: {
            emptyTable: "Saat ini belum ada data yang tersedia di menu ini",
            processing: "Sedang memuat data...",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
            infoEmpty: "Tidak ada data untuk ditampilkan",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya",
            },
        },
    });
});

        $('#search').on('keyup', function() {
                table.search(this.value).draw();
        });

        $('#kabupaten').on('change', function() {
            if (this.value == 0) {
                table.search('').draw(); // Show all entries
            } else {
                table.search(this.value).draw(); // Filter based on the selected value
            }
        });
        $('#status').on('change', function() {
            if (this.value == 0) {
                table.search('').draw(); // Show all entries
            } else {
                table.search(this.value).draw(); // Filter based on the selected value
            }
        });

    });
</script>
</html>
