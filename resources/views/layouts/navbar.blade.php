<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">

        {{-- Sidebar Toggle --}}
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        {{-- Logo / Brand --}}
        <div class="navbar-header pull-left">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <small>
                    <i class="fa fa-hospital-o"></i>
                    HMS Admin
                </small>
            </a>
        </div>

        {{-- Right Icons --}}
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                {{-- Tasks Dropdown --}}
                @include('layouts.navbar_tasks')

                {{-- Notifications Dropdown --}}
                @include('layouts.navbar_notifications')

                {{-- Messages Dropdown --}}
                @include('layouts.navbar_messages')

                {{-- User Dropdown --}}
                @include('layouts.navbar_user')

            </ul>
        </div>

    </div>
</div>
