@can('auditlogs.view')
    @php
        $activityLogs = $navbarActivityLogs ?? collect();
        $activityCount = $navbarActivityLogCount ?? $activityLogs->count();

        $activityIcon = function ($description) {
            $text = strtolower($description ?? '');

            if (str_contains($text, 'login')) {
                return ['fa-sign-in', 'btn-success'];
            }

            if (str_contains($text, 'logout')) {
                return ['fa-sign-out', 'btn-grey'];
            }

            if (str_contains($text, 'delete')) {
                return ['fa-trash-o', 'btn-danger'];
            }

            if (str_contains($text, 'update') || str_contains($text, 'edit')) {
                return ['fa-pencil', 'btn-warning'];
            }

            if (str_contains($text, 'create') || str_contains($text, 'added')) {
                return ['fa-plus', 'btn-info'];
            }

            return ['fa-history', 'btn-primary'];
        };
    @endphp

    <li class="purple dropdown-modal">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
            @if($activityCount > 0)
                <span class="badge badge-important">{{ $activityCount > 99 ? '99+' : $activityCount }}</span>
            @endif
        </a>

        <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
            <li class="dropdown-header">
                <i class="ace-icon fa fa-history"></i>
                {{ $activityCount }} Recent {{ \Illuminate\Support\Str::plural('Activity', $activityCount) }}
            </li>

            <li class="dropdown-content">
                <ul class="dropdown-menu dropdown-navbar navbar-pink">
                    @forelse($activityLogs as $log)
                        @php
                            [$icon, $buttonClass] = $activityIcon($log->description);
                        @endphp
                        <li>
                            <a href="{{ route('activity.logs') }}">
                                <div class="clearfix">
                                    <span class="pull-left">
                                        <i class="btn btn-xs no-hover {{ $buttonClass }} fa {{ $icon }}"></i>
                                        {{ \Illuminate\Support\Str::limit($log->description ?: 'Activity recorded', 34) }}
                                    </span>
                                </div>
                                <span class="msg-time">
                                    <i class="ace-icon fa fa-user"></i>
                                    <span>{{ $log->causer?->name ?? 'System' }}</span>
                                    <i class="ace-icon fa fa-clock-o"></i>
                                    <span>{{ optional($log->created_at)->diffForHumans() }}</span>
                                </span>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a href="{{ route('activity.logs') }}">
                                <i class="btn btn-xs no-hover btn-default fa fa-info-circle"></i>
                                No recent activity logs
                            </a>
                        </li>
                    @endforelse
                </ul>
            </li>

            <li class="dropdown-footer">
                <a href="{{ route('activity.logs') }}">
                    See all activity logs
                    <i class="ace-icon fa fa-arrow-right"></i>
                </a>
            </li>
        </ul>
    </li>
@endcan
