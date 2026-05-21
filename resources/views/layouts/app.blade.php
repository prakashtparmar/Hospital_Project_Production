<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
</head>

<body class="no-skin">

    {{-- Navbar --}}
    @include('layouts.navbar')

    <div class="main-container ace-save-state" id="main-container">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="main-content">
            <div class="main-content-inner">

                {{-- Breadcrumb can go here if needed --}}
                @yield('breadcrumbs')

                <div class="page-content">

                    {{-- Global Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade in" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade in" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-times"></i> {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>

            </div>
        </div>

        {{-- Footer --}}
        @include('layouts.footer')

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>

    {{-- JS Scripts --}}
    @include('layouts.scripts')
</body>

</html>