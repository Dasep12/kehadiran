 <header class="navbar navbar-expand-md d-print-none">
     <div class="container-xl">
         <!-- BEGIN NAVBAR TOGGLER -->
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <!-- END NAVBAR TOGGLER -->
         <!-- BEGIN NAVBAR LOGO -->
         <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
             <a href="/" aria-label="Tabler">
                 HRMS
             </a>
         </div>
         <!-- END NAVBAR LOGO -->
         <div class="navbar-nav flex-row order-md-last">
             <div class="nav-item d-none d-md-flex me-3">
                 <div class="btn-list ">
                     <a href="https://github.com/tabler/tabler" class="btn btn-5 btn-success fw-bold" target="_blank" rel="noreferrer">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                             <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                             <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                         </svg>
                         Support
                     </a>
                     <a href="https://github.com/sponsors/codecalm" class="d-none btn btn-6 " target="_blank" rel="noreferrer">
                         <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-pink icon-2">
                             <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                         </svg>
                         Sponsor
                     </a>
                 </div>
             </div>
             <div class="d-none d-md-flex">
                 <div class="nav-item">
                     <a href="?theme=dark" class="nav-link px-0 hide-theme-dark d-none" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Enable dark mode" data-bs-original-title="Enable dark mode">
                         <!-- Download SVG icon from http://tabler.io/icons/icon/moon -->
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                             <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                         </svg>
                     </a>
                     <a href="?theme=light" class="nav-link px-0 hide-theme-light" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Enable light mode" data-bs-original-title="Enable light mode">
                         <!-- Download SVG icon from http://tabler.io/icons/icon/sun -->
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                             <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                             <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="nav-item dropdown d-none d-md-flex">
                     <a href="#" class="nav-link px-0 " data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications" data-bs-auto-close="outside" aria-expanded="false">
                         <!-- Download SVG icon from http://tabler.io/icons/icon/bell -->
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                             <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                             <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                         </svg>
                         <span class="badge bg-red"></span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                         <div class="card">
                             <div class="card-header d-flex">
                                 <h3 class="card-title">Notifications</h3>
                                 <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                             </div>
                             <div class="list-group list-group-flush list-group-hoverable">
                                 <div class="list-group-item">
                                     <div class="row align-items-center">
                                         <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                         <div class="col text-truncate">
                                             <a href="#" class="text-body d-block">Example 1</a>
                                             <div class="d-block text-secondary text-truncate mt-n1">Change deprecated html tags to text decoration classes (#29604)</div>
                                         </div>
                                         <div class="col-auto">
                                             <a href="#" class="list-group-item-actions">
                                                 <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-muted icon-2">
                                                     <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                                 </svg>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="list-group-item">
                                     <div class="row align-items-center">
                                         <div class="col-auto"><span class="status-dot d-block"></span></div>
                                         <div class="col text-truncate">
                                             <a href="#" class="text-body d-block">Example 2</a>
                                             <div class="d-block text-secondary text-truncate mt-n1">justify-content:between ⇒ justify-content:space-between (#29734)</div>
                                         </div>
                                         <div class="col-auto">
                                             <a href="#" class="list-group-item-actions show">
                                                 <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-yellow icon-2">
                                                     <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                                 </svg>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="list-group-item">
                                     <div class="row align-items-center">
                                         <div class="col-auto"><span class="status-dot d-block"></span></div>
                                         <div class="col text-truncate">
                                             <a href="#" class="text-body d-block">Example 3</a>
                                             <div class="d-block text-secondary text-truncate mt-n1">Update change-version.js (#29736)</div>
                                         </div>
                                         <div class="col-auto">
                                             <a href="#" class="list-group-item-actions">
                                                 <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-muted icon-2">
                                                     <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                                 </svg>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="list-group-item">
                                     <div class="row align-items-center">
                                         <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                                         <div class="col text-truncate">
                                             <a href="#" class="text-body d-block">Example 4</a>
                                             <div class="d-block text-secondary text-truncate mt-n1">Regenerate package-lock.json (#29730)</div>
                                         </div>
                                         <div class="col-auto">
                                             <a href="#" class="list-group-item-actions">
                                                 <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-muted icon-2">
                                                     <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                                 </svg>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="card-body">
                                 <div class="row">
                                     <div class="col">
                                         <a href="#" class="btn btn-2 w-100"> Archive all </a>
                                     </div>
                                     <div class="col">
                                         <a href="#" class="btn btn-2 w-100"> Mark all as read </a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="nav-item dropdown d-none d-md-flex me-3">
                     <a href="#" class="nav-link px-0 d-none" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show app menu" data-bs-auto-close="outside" aria-expanded="false">
                         <!-- Download SVG icon from http://tabler.io/icons/icon/apps -->
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                             <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                             <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                             <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                             <path d="M14 7l6 0"></path>
                             <path d="M17 4l0 6"></path>
                         </svg>
                     </a>
                     <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                         <div class="card">
                             <div class="card-header">
                                 <div class="card-title">My Apps</div>
                                 <div class="card-actions btn-actions">
                                     <a href="#" class="btn-action">
                                         <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                             <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                             <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                         </svg>
                                     </a>
                                 </div>
                             </div>
                             <div class="card-body scroll-y p-2" style="max-height: 50vh">
                                 <div class="row g-0">
                                     <div class="col-4">
                                         <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">
                                             <img src="" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">
                                             <span class="h5">Amazon</span>
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="nav-item dropdown">
                 <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                     <span class="avatar avatar-sm" style="background-image:url({{ asset('assets/images/employee/male.png') }})"> </span>
                     <div class="d-none d-xl-block ps-2">
                         <div>Pawel Kuna</div>
                         <div class="mt-1 small text-secondary">UI Designer</div>
                     </div>
                 </a>
                 <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <a href="#" class="dropdown-item">Status</a>
                     <a href="./profile.html" class="dropdown-item">Profile</a>
                     <a href="#" class="dropdown-item">Feedback</a>
                     <div class="dropdown-divider"></div>
                     <a href="./settings.html" class="dropdown-item">Settings</a>
                     <a href="{{ route('auth.logout') }}" class="dropdown-item">Logout</a>
                 </div>
             </div>
         </div>
     </div>
 </header>