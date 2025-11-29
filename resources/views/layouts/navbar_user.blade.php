<li class="light-blue dropdown-modal">
    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
        <img class="nav-user-photo" src="{{ asset('ace/assets/images/avatars/user.jpg') }}" />
        <span class="user-info">
            <small>Welcome,</small>
            {{ Auth::user()->name ?? 'User' }}
        </span>

        <i class="ace-icon fa fa-caret-down"></i>
    </a>

    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

        <li>
            <a href="#">
                <i class="ace-icon fa fa-cog"></i> Settings
            </a>
        </li>

        <li>
            <a href="#">
                <i class="ace-icon fa fa-user"></i> Profile
            </a>
        </li>

        <li class="divider"></li>

        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ace-icon fa fa-power-off"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
</li>
