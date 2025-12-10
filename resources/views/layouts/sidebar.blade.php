<div id="sidebar" class="sidebar responsive ace-save-state">
    <script>try { ace.settings.loadState('sidebar') } catch (e) { }</script>

    {{-- SHORTCUT BUTTONS --}}
    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">

            <a href="{{ route('dashboard') }}" class="btn btn-success">
                <i class="ace-icon fa fa-home"></i>
            </a>

            <a href="{{ route('doctors.index') }}" class="btn btn-info">
                <i class="ace-icon fa fa-users"></i>
            </a>

            <a href="#" class="btn btn-warning">
                <i class="ace-icon fa fa-stethoscope"></i>
            </a>
            <a href="#" class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </a>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <a href="{{ route('dashboard') }}" class="btn btn-success"></a>
            <a href="{{ route('doctors.index') }}" class="btn btn-info"></a>
            <span class="btn btn-warning"></span>
            <span class="btn btn-danger"></span>
        </div>
    </div>

    <ul class="nav nav-list">

        {{-- DASHBOARD --}}
        @can('dashboard.view')
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>
        @endcan

        {{-- ADMIN --}}
        @canany(['roles.view', 'users.view', 'departments.view', 'auditlogs.view', 'notification-settings.view', 'product-list'])
            <li
                class="{{ request()->is('roles*') || request()->is('users*') || request()->is('departments*') || request()->is('products*') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-gears"></i>
                    <span class="menu-text"> Admin </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu">
                    @can('users.view')
                        <li class="{{ request()->is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}"><i class="menu-icon fa fa-user"></i> Users</a>
                        </li>
                    @endcan

                    @can('roles.view')
                        <li class="{{ request()->is('roles*') ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}"><i class="menu-icon fa fa-shield"></i> Roles</a>
                        </li>
                    @endcan

                    @can('departments.view')
                        <li class="{{ request()->is('departments*') ? 'active' : '' }}">
                            <a href="{{ route('departments.index') }}"><i class="menu-icon fa fa-sitemap"></i> Departments</a>
                        </li>
                    @endcan

                    @can('auditlogs.view')
                        <li>
                            <a href="{{ route('activity.logs') }}">
                                <i class="menu-icon fa fa-history"></i> Activity Logs
                            </a>
                        </li>
                    @endcan

                    @can('notification-settings.view')
                        <li class="{{ request()->is('notification-settings') ? 'active' : '' }}">
                            <a href="{{ route('notification-settings.index') }}">
                                <i class="menu-icon fa fa-bell"></i> Alerts
                            </a>
                        </li>
                    @endcan

                    @can('product-list')
                        <li class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i> Manage Health Records
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- CLINICAL --}}
        @canany(['patients.view', 'opd.view', 'ipd.view', 'appointments.view', 'consultations.view', 'doctors.view', 'doctor-schedule.view'])
            <li
                class="{{ request()->is('doctors*', 'patients*', 'opd*', 'ipd*', 'appointments*', 'consultations*', 'doctor-schedule*') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-hospital-o"></i>
                    <span class="menu-text"> Clinical </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu">
                    @can('doctors.view')
                        <li class="{{ request()->is('doctors*') ? 'active' : '' }}">
                            <a href="{{ route('doctors.index') }}"><i class="menu-icon fa fa-user-md"></i> Doctors</a>
                        </li>
                    @endcan

                    @can('patients.view')
                        <li class="{{ request()->is('patients*') ? 'active' : '' }}">
                            <a href="{{ route('patients.index') }}"><i class="menu-icon fa fa-wheelchair"></i> Patients</a>
                        </li>
                    @endcan

                    @can('opd.view')
                        <li class="{{ request()->is('opd*') ? 'active' : '' }}">
                            <a href="{{ route('opd.index') }}"><i class="menu-icon fa fa-stethoscope"></i> OPD</a>
                        </li>
                    @endcan

                    @can('ipd.view')
                        <li class="{{ request()->is('ipd*') ? 'active' : '' }}">
                            <a href="{{ route('ipd.index') }}"><i class="menu-icon fa fa-bed"></i> IPD</a>
                        </li>
                    @endcan

                    @can('appointments.view')
                        <li class="{{ request()->is('appointments*') ? 'active' : '' }}">
                            <a href="{{ route('appointments.index') }}">
                                <i class="menu-icon fa fa-calendar-check-o"></i> Appointment
                            </a>
                        </li>
                    @endcan

                    @can('consultations.view')
                        <li class="{{ request()->is('consultations*') ? 'active' : '' }}">
                            <a href="{{ route('consultations.index') }}">
                                <i class="menu-icon fa fa-heartbeat"></i> Consultation
                            </a>
                        </li>
                    @endcan

                    @can('doctor-schedule.view')
                        <li class="{{ request()->is('doctor-schedule*') ? 'active' : '' }}">
                            <a href="{{ route('doctor-schedule.index') }}">
                                <i class="menu-icon fa fa-clock-o"></i> Dr. Schedule
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- WARDS --}}
        @canany(['wards.view', 'rooms.view', 'beds.view'])
            <li class="{{ request()->is('wards*', 'rooms*', 'beds*') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-building"></i>
                    <span class="menu-text"> Wards </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu">
                    @can('wards.view')
                        <li class="{{ request()->is('wards*') ? 'active' : '' }}">
                            <a href="{{ route('wards.index') }}"><i class="menu-icon fa fa-hospital-o"></i> Wards</a>
                        </li>
                    @endcan

                    @can('rooms.view')
                        <li class="{{ request()->is('rooms*') ? 'active' : '' }}">
                            <a href="{{ route('rooms.index') }}"><i class="menu-icon fa fa-home"></i> Rooms</a>
                        </li>
                    @endcan

                    @can('beds.view')
                        <li class="{{ request()->is('beds*') ? 'active' : '' }}">
                            <a href="{{ route('beds.index') }}"><i class="menu-icon fa fa-th-large"></i> Beds</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- PHARMACY --}}
        @canany([
                    'medicine-categories.view',
                    'medicine-units.view',
                    'medicines.view',
                    'suppliers.view',
                    'purchases.view',
                    'issue-medicines.view',
                    'stock-adjustments.view'
                ])
                <li class="{{ request()->is(
                'medicine-categories*',
                'medicine-units*',
                'medicines*',
                'suppliers*',
                'purchases*',
                'issue-medicines*',
                'stock-adjustments*'
            ) ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-medkit"></i>
                        <span class="menu-text"> Pharmacy </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <ul class="submenu">

                               @can('medicine-categories.view')
                                <li class="{{ request()->is('medicine-categories*') ? 'active' : '' }}">
                                    <a href="{{ route('medicine-categories.index') }}"><i class="menu-icon fa fa-tags"></i> Categories</a>
                                </li>
                            @endcan

                        @can('medicine-units.view')
                            <li class="{{ request()->is('medicine-units*') ? 'active' : '' }}">
                                <a href="{{ route('medicine-units.index') }}"><i class="menu-icon fa fa-eyedropper"></i> Units</a>
                            </li>
                        @endcan

                        @can('medicines.view')
                            <li class="{{ request()->is('medicines*') ? 'active' : '' }}">
                                <a href="{{ route('medicines.index') }}"><i class="menu-icon fa fa-medkit"></i> Medicines</a>
                            </li>
                        @endcan

                        @can('suppliers.view')
                            <li class="{{ request()->is('suppliers*') ? 'active' : '' }}">
                                <a href="{{ route('suppliers.index') }}"><i class="menu-icon fa fa-truck"></i> Suppliers</a>
                            </li>
                        @endcan

                        @can('purchases.view')
                            <li class="{{ request()->is('purchases*') ? 'active' : '' }}">
                                <a href="{{ route('purchases.index') }}"><i class="menu-icon fa fa-shopping-cart"></i> Purchases</a>
                            </li>
                        @endcan

                        @can('issue-medicines.view')
                            <li class="{{ request()->is('issue-medicines*') ? 'active' : '' }}">
                                <a href="{{ route('issue-medicines.index') }}"><i class="menu-icon fa fa-plus-square"></i> Issue</a>
                            </li>
                        @endcan


                        @can('stock-adjustments.view')
                            <li class="{{ request()->is('stock-adjustments*') ? 'active' : '' }}">
                                <a href="{{ route('stock-adjustments.index') }}"><i class="menu-icon fa fa-refresh"></i> Stock Adjustments</a>
                            </li>
                        @endcan
                    </ul>
                </li>
        @endcanany
        
        {{-- LAB --}}
@canany([
        'lab-test-categories.view',
        'lab-tests.view',
        'lab-requests.view',
        'lab-results.view',
        'lab-reports.view'
    ])
            <li class="{{ request()->is(
            'lab-test-categories*',
            'lab-tests*',
            'lab-requests*',
            'lab-requests/*/results*'
        ) ? 'open' : '' }}">

                  <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-flask"></i>
              <spa      n class="menu-text"> Lab </span>
                <b class    ="arrow fa fa-angle-down"></b>
              </a>

        <ul         class="submenu">

                    {{-- Categories --}}
                    @can('lab-test-categories.view')
                        <li class="{{ request()->is('lab-test-categories*') ? 'active' : '' }}">
                            <a href="{{ route('lab-test-categories.index') }}">
                                <i class="menu-icon fa fa-tags"></i> Categories
                            </a>
                        </li>
                    @endcan

                    {{-- Tests --}}
                    @can('lab-tests.view')
                        <li class="{{ request()->is('lab-tests*') ? 'active' : '' }}">
                            <a href="{{ route('lab-tests.index') }}">
                                <i class="menu-icon fa fa-flask"></i> Tests
                            </a>
                        </li>
                    @endcan

                    {{-- Requests --}}
                    @can('lab-requests.view')
                        <li class="{{ request()->is('lab-requests*') ? 'active' : '' }}">
                            <a href="{{ route('lab-requests.index') }}">
                                <i class="menu-icon fa fa-file-text"></i> Requests
                            </a>
                        </li>
                    @endcan

                    {{-- Sample Collection & Results (Lab Technician) --}}
                    @canany(['lab-samples.collect', 'lab-results.create', 'lab-results.edit'])
                        <li class="{{ request()->is('lab-requests/*/results*') ? 'active' : '' }}">
                            <a href="{{ route('lab-requests.index') }}">
                                <i class="menu-icon fa fa-eyedropper"></i> Samples / Results
                            </a>
                        </li>
                    @endcanany

                    {{-- Reports (Doctor / Admin) --}}
                    @can('lab-reports.view')
                                <li>
                            <a href="{{ route('lab-requests.index') }}">
                                <i class="menu-icon fa fa-file-pdf-o"></i> Reports
                            </a>
                        </li>
                    @endcan

        </ul>
    </li>
@endcanany


        {{-- RADIOLOGY --}}
        @canany(['radiology-categories.view', 'radiology-tests.view', 'radiology-requests.view'])
            <li class="{{ request()->is('radiology-categories*', 'radiology-tests*', 'radiology-requests*') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">

                                           <i class="menu-icon fa fa-image"></i>
                    <span class="menu-text"> Radiology </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu">
                    @can('radiology-categories.view')
                        <li class="{{ request()->is('radiology-categories*') ? 'active' : '' }}">
                            <a href="{{ route('radiology-categories.index') }}"><i class="menu-icon fa fa-tags"></i> Categories</a>
                        </li>
                    @endcan


                                           @can('radiology-tests.view')
                                            <li class="{{ request()->is('radiology-tests*') ? 'active' : '' }}">
                                                <a href="{{ route('radiology-tests.index') }}"><i class="menu-icon fa fa-bolt"></i> Tests</a>
                                            </li>
                                        @endcan

                    @can('radiology-requests.view')
                        <li class="{{ request()->is('radiology-requests*') ? 'active' : '' }}">
                            <a href="{{ route('radiology-requests.index') }}"><i class="menu-icon fa fa-file-text"></i> Requests</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- BILLING --}}
        @can('billing.view')
            <li class="{{ request()->is('billing*') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-credit-card"></i>
                    <span class="menu-text"> Billing </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li class="{{ request()->is('billing*') ? 'active' : '' }}">
                        <a href="{{ route('billing.index') }}"><i class="menu-icon fa fa-file-text"></i> Records</a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- HR --}}
        @canany(['employees.view', 'attendance.view', 'salary-structures.view', 'payroll.view'])
            <li class="{{ request()->is('employees*', 'attendance*', 'salary-structures*', 'payroll*') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-briefcase"></i>
                    <span class="menu-text"> HR / Payroll </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu">

                                           @can('employees.view')
                                            <li class="{{ request()->is('employees*') ? 'active' : '' }}">
                                                <a href="{{ route('employees.index') }}"><i class="menu-icon fa fa-users"></i> Employees</a>
                                            </li>
                                        @endcan


                                           @can('attendance.view')
                                            <li class="{{ request()->is('attendance*') ? 'active' : '' }}">
                                                <a href="{{ route('attendance.index') }}"><i class="menu-icon fa fa-calendar-check-o"></i> Attendance</a>
                                            </li>
                                        @endcan

                    @can('salary-structures.view')
                        <li class="{{ request()->is('salary-structures*') ? 'active' : '' }}">
                            <a href="{{ route('salary-structures.index') }}"><i class="menu-icon fa fa-money"></i> Salary Structure</a>
                        </li>
                    @endcan

                    @can('payroll.view')
                        <li class="{{ request()->is('payroll*') ? 'active' : '' }}">
                            <a href="{{ route('payroll.index') }}"><i class="menu-icon fa fa-credit-card"></i> Payroll</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- EXPORT --}}
        @can('export.view')
            <li class="{{ request()->is('export*') ? 'active' : '' }}">
                <a href="{{ route('export.patients') }}">
                    <i class="menu-icon fa fa-download"></i>
                    <span class="menu-text"> Export </span>
                </a>
            </li>
        @endcan

        {{-- HOSPITALS --}}
        @can('hospitals.view')
                <li class="{{ request()->is('admin/hospitals*') ? 'active' : '' }}">
                    <a href="{{ route('admin.hospitals.index') }}">
                        <i class="menu-icon fa fa-building"></i>
              <span class="menu-text"> Hospitals </span>
                     </a>
                </li>
        @endcan
    </ul>

    {{-- COLLAPSE --}}
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left ace-save-state"
           data-icon1="ace-icon fa fa-angle-double-left"
           data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
