<li class="green dropdown-modal">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
        <span class="badge badge-success">5</span>
    </a>

    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">

        <li class="dropdown-header">
            <i class="ace-icon fa fa-envelope-o"></i>
            5 Messages
        </li>

        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar">
                <li>
                    <a href="#" class="clearfix">
                        <img src="{{ asset('ace/assets/images/avatars/avatar.png') }}" class="msg-photo" />
                        <span class="msg-body">
                            <span class="msg-title">
                                <span class="blue">Alex:</span> Hi, how are you?
                            </span>
                            <span class="msg-time"><i class="ace-icon fa fa-clock-o"></i><span>a moment ago</span></span>
                        </span>
                    </a>
                </li>

                {{-- Add more messages as needed --}}
            </ul>
        </li>

        <li class="dropdown-footer">
            <a href="{{ url('admni/inbox') }}">See all messages <i class="ace-icon fa fa-arrow-right"></i></a>
        </li>

    </ul>
</li>
