<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="row flex-column flex-md-row flex-fill align-items-center">
                    <div class="col">
                        <!-- BEGIN NAVBAR MENU -->
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="/">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Dashboard </span>
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                                            <path d="M12 12l8 -4.5"></path>
                                            <path d="M12 12l0 9"></path>
                                            <path d="M12 12l-8 -4.5"></path>
                                            <path d="M16 5.25l-8 4.5"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Core Data </span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a href="./positions.html" class="dropdown-item"> Organization </a>
                                            <a href="{{ route('coredata.position') }}" class="dropdown-item"> Position </a>
                                            <a href="{{ route('coredata.jobGrade') }}" class="dropdown-item"> Job Grade </a>
                                            <a href="{{ route('coredata.workStatus') }}" class="dropdown-item"> Employment Status </a>
                                            <a href="{{ route('coredata.education') }}" class="dropdown-item"> Education </a>
                                        </div>
                                        <div class="dropdown-menu-column">
                                            <div class="dropend">
                                                <a class="dropdown-item dropdown-toggle" href="#sidebar-payroll-tax" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                                    Salary & Tax
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('sallaryTax.allowances') }}" class="dropdown-item"> Allowances </a>
                                                    <a href="{{ route('sallaryTax.payPeriods') }}" class="dropdown-item"> Pay Periods </a>
                                                    <a href="{{ route('sallaryTax.taxPtkp') }}" class="dropdown-item"> Tax Allowance (PTKP) </a>
                                                    <a href="{{ route('sallaryTax.taxTer') }}" class="dropdown-item"> Effective Tax Rate </a>
                                                    <a href="{{ route('sallaryTax.taxBrackets') }}" class="dropdown-item"> Tax Brackets </a>
                                                    <a href="{{ route('sallaryTax.taxSettings') }}" class="dropdown-item"> Tax Settings </a>
                                                </div>
                                            </div>
                                            <a class="dropdown-item" href="{{ route('sallaryTax.sallaryGroup') }}"> Salary Groups </a>
                                            <a class="dropdown-item" href="{{ route('sallaryTax.membershipFees') }}"> Membership Fees </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-form" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler-users">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Employees </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./import-employee.html"> Import Employees </a>
                                    <a class="dropdown-item" href="./employee-list.html"> Employee List </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler-calendar-stats">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                            <path d="M18 14v4h4" />
                                            <path d="M14 18a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M15 3v4" />
                                            <path d="M7 3v4" />
                                            <path d="M3 11h16" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Work Time </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./attendance-name.html"> Attendance Types </a>
                                    <a class="dropdown-item" href="./shift-management.html"> Shift Settings </a>
                                    <a class="dropdown-item" href="./overtime-management.html"> Overtime </a>
                                    <a class="dropdown-item" href="./working-calendar.html"> Work Calendar </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Attendance </span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item" href="./attendance-log.html"> Employee Attendance </a>
                                            <a class="dropdown-item" href="./employee-shift.html"> Shift Assignments </a>
                                        </div>
                                        <div class="dropdown-menu-column">
                                            <div class="dropend">
                                                <a class="dropdown-item dropdown-toggle" href="#sidebar-approval" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                                    Approvals
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="./approve-overtime.html" class="dropdown-item"> Overtime Approval </a>
                                                    <a href="./approve-permit.html" class="dropdown-item"> Leave Approval </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-plugins" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-paywall">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M13 21h-6a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h10" />
                                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                            <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                            <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                            <path d="M19 21v1" />
                                            <path d="M19 14v1" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Payroll </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./import-manual.html"> Manual Input </a>
                                    <a class="dropdown-item" href="./process-calculation.html"> Run Payroll </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-addons" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings-cog">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12.003 21c-.732 .001 -1.465 -.438 -1.678 -1.317a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c.886 .215 1.325 .957 1.318 1.694" />
                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                            <path d="M17.001 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M19.001 15.5v1.5" />
                                            <path d="M19.001 21v1.5" />
                                            <path d="M22.032 17.25l-1.299 .75" />
                                            <path d="M17.27 20l-1.3 .75" />
                                            <path d="M15.97 17.25l1.3 .75" />
                                            <path d="M20.733 20l1.3 .75" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Settings </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./roles.html"> Access Roles </a>
                                    <a class="dropdown-item" href="./users.html"> Users </a>
                                    <a class="dropdown-item" href="./company-identity.html"> Company Profile </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-title"> Help </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="https://tabler.io/docs" target="_blank" rel="noopener"> Documentation </a>
                                    <a class="dropdown-item" href="./changelog.html"> System Updates </a>
                                </div>
                            </li>
                        </ul>
                        <!-- END NAVBAR MENU -->
                    </div>
                    <div class="col col-md-auto d-none">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings">
                                    <span class="badge badge-sm bg-red text-red-fg">New</span>
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Theme Settings </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>