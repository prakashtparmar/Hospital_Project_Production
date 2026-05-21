<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
</head>

<body class="login-layout">

<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">

                    {{-- Page Content --}}
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.scripts')



</body>
</html>
