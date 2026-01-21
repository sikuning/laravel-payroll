<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{$siteInfo->com_name}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="javascript:void(0)" class="d-block">{{session()->get('admin_name')}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('admin/dashboard')}}" class="nav-link {{(Request::path() == 'admin/dashboard')? 'active':''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{(Request::path() == 'admin/departments' || Request::path() == 'admin/designations' || Request::path() == 'admin/employees')? 'menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Emp Management <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('admin/departments')}}" class="nav-link {{(Request::path() == 'admin/departments')? 'active bg-primary':''}}">
                                <i class="fas fa fa-building nav-icon"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/designations')}}" class="nav-link {{(Request::path() == 'admin/designations')? 'active bg-primary':''}}">
                                <i class="nav-icon fas fa-map"></i>
                                <p>Designation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/employees')}}" class="nav-link {{(Request::path() == 'admin/employees')? 'active bg-primary':''}}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                    </ul> 
                </li>
                <li class="nav-item has-treeview {{(Request::path() == 'admin/attendance' || Request::path() == 'admin/attendance/create')? 'menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p> Attendance <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('admin/attendance/create')}}" class="nav-link {{(Request::path() == 'admin/attendance/create')? 'active bg-primary':''}}">
                                <i class="fas fa-check nav-icon"></i>
                                <p>Mark Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/attendance')}}" class="nav-link {{(Request::path() == 'admin/attendance')? 'active bg-primary':''}}">
                                <i class="far fa-eye nav-icon"></i>
                                <p>View Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/late_configration')}}" class="nav-link {{(Request::path() == 'admin/late_configration')? 'active bg-primary':''}}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>Late Configration</p>
                            </a>
                        </li>
                    </ul> 
                </li>
                <li class="nav-item has-treeview {{(Request::path() == 'admin/leave_type' || Request::path() == 'admin/leave_application')? 'menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Leave Management <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('admin/public_holidays')}}" class="nav-link {{(Request::path() == 'admin/public_holidays')? 'active bg-primary':''}}">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Public Holidays</p>
                            </a>
                            <a href="{{url('admin/weekly_holidays')}}" class="nav-link {{(Request::path() == 'admin/weekly_holidays')? 'active bg-primary':''}}">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Weekly Holidays</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/leave_type')}}" class="nav-link {{(Request::path() == 'admin/leave_type')? 'active bg-primary':''}}">
                                <i class="fa fa-cubes nav-icon"></i>
                                <p>Leave Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/leave_application')}}" class="nav-link {{(Request::path() == 'admin/leave_application')? 'active bg-primary':''}}">
                                <i class="fas fa-rocket nav-icon"></i>
                                <p>Leave Applications</p>
                            </a>
                        </li>
                    </ul> 
                </li>
                <li class="nav-item has-treeview {{(Request::path() == 'admin/work_shift' || Request::path() == 'admin/tax_rule' || Request::path() == 'admin/allowance' || Request::path() == 'admin/deduction' || Request::path() == 'admin/pay_grade' || Request::path() == 'admin/hourly_pay_grade' || Request::path() == 'admin/salary_sheet')? 'menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                        <p>Payroll <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('admin/work_shift')}}" class="nav-link {{(Request::path() == 'admin/work_shift')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Work Shift</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/tax_rule')}}" class="nav-link {{(Request::path() == 'admin/tax_rule')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tax Rule</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/allowance')}}" class="nav-link {{(Request::path() == 'admin/allowance')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Allowance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/deduction')}}" class="nav-link {{(Request::path() == 'admin/deduction')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Deduction</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/pay_grade')}}" class="nav-link {{(Request::path() == 'admin/pay_grade')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Monthly Pay Grade</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/hourly_pay_grade')}}" class="nav-link {{(Request::path() == 'admin/hourly_pay_grade')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Hourly Pay Grade</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/salary_sheet')}}" class="nav-link {{(Request::path() == 'admin/salary_sheet')? 'active bg-primary':''}}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Salary Sheet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/payment_history')}}" class="nav-link {{(Request::path() == 'admin/payment_history')? 'active bg-primary':''}}">
                                <i class="fas fa-money-bill-wave-alt nav-icon"></i>
                                <p>Payment History</p>
                            </a>
                        </li>
                    </ul> 
                </li>
                <li class="nav-item has-treeview {{(Request::path() == 'admin/general-settings' || Request::path() == 'admin/profile-settings'|| Request::path() == 'admin/social-settings' || Request::path() == 'admin/banner')? 'menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fa fa-wrench"></i>
                        <p> Settings <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('admin/general-settings')}}" class="nav-link {{(Request::path() == 'admin/general-settings')? 'active bg-primary':''}}">
                                <i class="fas fa-cogs nav-icon"></i>
                                <p>General Setting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/profile-settings')}}" class="nav-link {{(Request::path() == 'admin/profile-settings')? 'active bg-primary':''}}">
                                <i class="nav-icon fa fa-user"></i>
                                <p>Profile Setting</p>
                            </a>
                        </li>
                    </ul> 
                </li>
            </ul>
        </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Control Sidebar -->