<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>@yield('title', 'Inbox - Ace Admin')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

{{-- Bootstrap & FontAwesome --}}
<link rel="stylesheet" href="{{ asset('ace/assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('ace/assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">


{{-- Text Fonts --}}
<link rel="stylesheet" href="{{ asset('ace/assets/css/fonts.googleapis.com.css') }}" />

{{-- Ace Template Styles --}}
<link rel="stylesheet" href="{{ asset('ace/assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />
<link rel="stylesheet" href="{{ asset('ace/assets/css/ace-skins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('ace/assets/css/ace-rtl.min.css') }}" />

<style>
    .d-flex { display: flex; }
    .d-inline { display: inline; }
    .d-inline-block { display: inline-block; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    .mb-0 { margin-bottom: 0 !important; }
    .mb-2 { margin-bottom: 10px !important; }
    .mb-3 { margin-bottom: 15px !important; }
    .mt-1 { margin-top: 5px !important; }
    .mt-2 { margin-top: 10px !important; }
    .mt-3 { margin-top: 15px !important; }
    .ml-2 { margin-left: 10px !important; }
    .m-0 { margin: 0 !important; }
    .p-0 { padding: 0 !important; }
    .p-2 { padding: 10px !important; }
    .text-white { color: #fff !important; }
    .text-right { text-align: right !important; }

    .card {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .card-header {
        padding: 10px 12px;
        border-bottom: 1px solid #ddd;
        background: #f7f7f7;
    }

    .card-body {
        padding: 12px;
    }

    .card-footer {
        padding: 10px 12px;
        border-top: 1px solid #ddd;
        background: #f7f7f7;
    }

    .bg-success { background-color: #87b87f !important; }
    .bg-danger { background-color: #d15b47 !important; }
    .bg-info { background-color: #6fb3e0 !important; }
    .bg-warning { background-color: #ffb752 !important; }
    .bg-light { background-color: #f7f7f7 !important; }
    .bg-dark { background-color: #555 !important; }
    .bg-purple { background-color: #9585bf !important; }

    .badge-success { background-color: #82af6f; }
    .badge-danger { background-color: #d15b47; }
    .badge-info { background-color: #6fb3e0; }
    .badge-warning { background-color: #ffb752; }
    .badge-primary { background-color: #428bca; }
    .badge-secondary { background-color: #abbac3; }

    .btn-secondary {
        color: #fff;
        background-color: #abbac3;
        border-color: #abbac3;
    }

    .table-sm > thead > tr > th,
    .table-sm > tbody > tr > td {
        padding: 5px;
    }

    .page-header.d-flex {
        flex-wrap: wrap;
        gap: 10px;
    }
</style>

<script src="{{ asset('ace/assets/js/ace-extra.min.js') }}"></script>
