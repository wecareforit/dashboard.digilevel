<!DOCTYPE html>
<html lang="en" dir="ltr"  data-bs-theme="light" data-color-theme="Aqua_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="./assets/css/styles.css" />
  <title>MaterialM Bootstrap Admin</title>
  <!-- Jvectormap  -->
  <link rel="stylesheet" href="./assets/libs/jvectormap/jquery-jvectormap.css" />
</head>

<body>
 
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="side-mini-panel with-vertical">
      <!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
      <div class="iconbar">
        <div>
          <div class="mini-nav">
            <div class="brand-logo d-flex align-items-center justify-content-between justify-content-lg-center">
              <a href="./main/index.html" class="text-nowrap logo-img">
                <img src="./assets/images/logos/logo-icon.svg" alt="Logo" />
              </a>
              <a href="javascript:void(0)" class="sidebartoggler close-btn ms-auto text-decoration-none fs-5 d-flex d-xl-none align-items-center justify-content-center text-danger">
                <i class="material-symbols-outlined fs-5">cancel</i>
              </a>
            </div>
            <ul class="mini-nav-ul" data-simplebar>
              <!-- --------------------------------------------------------------------------------------------------------- -->
              <!-- Dashboards -->
              <!-- --------------------------------------------------------------------------------------------------------- -->
              <li class="mini-nav-item" id="mini-1">
                <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="Dashboards">
                  <iconify-icon icon="solar:layers-line-duotone" class="fs-7"></iconify-icon>
                </a>
              </li>
              <!-- --------------------------------------------------------------------------------------------------------- -->
              <!-- Landingpage -->
              <!-- --------------------------------------------------------------------------------------------------------- -->
          

              <li>
                <span class="sidebar-divider lg"></span>
              </li>
              <!-- --------------------------------------------------------------------------------------------------------- -->
              <!-- Tables -->
              <!-- --------------------------------------------------------------------------------------------------------- -->
              <li class="mini-nav-item" id="mini-objects">
                <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="Objecten">
                  <iconify-icon icon="solar:tuning-square-2-line-duotone" class="fs-7"></iconify-icon>
                </a>
              </li>
            

     <li class="mini-nav-item" id="mini-settings">
                <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="Instellingen">
                  <iconify-icon icon="solar:tuning-square-2-line-duotone" class="fs-7"></iconify-icon>
                </a>
              </li>
            


            </ul>
            
          </div>
          <div class="sidebarmenu">
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
              <ul class="sidebar-menu" id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap">
                  <span class="hide-menu">Dashboards</span>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                <li class="sidebar-item">
                  <a class="sidebar-link" href="./main/index2.html" aria-expanded="false">
                    <iconify-icon icon="solar:widget-add-line-duotone" class=""></iconify-icon>
                    <span class="hide-menu">eCommerce</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="" id="get-url" aria-expanded="false">
                    <iconify-icon icon="solar:chart-line-duotone" class=""></iconify-icon>
                    <span class="hide-menu">Objecten</span>
                  </a>
                </li>

               

                
              </ul>
            </nav>
            <!-- sidebar -->
            <nav class="sidebar-nav" id="menu-right-mini-2" data-simplebar>
              <ul class="sidebar-menu" id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap">
                  <span class="hide-menu">LandingPage</span>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                <li class="sidebar-item">
                  <a class="sidebar-link" href="./landingpage/index.html"><iconify-icon icon="solar:bill-list-line-duotone"></iconify-icon> Landingpage</a>
                </li>
              </ul>
            </nav>
           
            <!-- sidebar -->
            <nav class="sidebar-nav scroll-sidebar" id="menu-right-mini-objects" data-simplebar>
              <ul class="sidebar-menu" id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap">
                  <span class="hide-menu">Objecten</span>
                </li>

                             <li class="sidebar-item">
                  <a href="./main/table-datatable-api.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Overzicht</span>
                  </a>
                </li>
        
                <li class="sidebar-item">
                  <a href="./main/table-datatable-basic.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Keuringen</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="./main/table-datatable-api.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Reparaties</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="./main/table-datatable-advanced.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Storingen</span>
                  </a>
                </li>
              </ul>
            </nav>






               <nav class="sidebar-nav scroll-sidebar" id="menu-right-mini-settings" data-simplebar>
              <ul class="sidebar-menu" id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap">
                  <span class="hide-menu">Objecten</span>
                </li>

                             <li class="sidebar-item">
                  <a href="./main/table-datatable-api.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Koppelingen</span>
                  </a>
                </li>
        
                <li class="sidebar-item">
                  <a href="./main/table-datatable-basic.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Medewerkers</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="./main/table-datatable-api.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Afdelingen</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="./main/table-datatable-advanced.html" class="sidebar-link">
                    <iconify-icon icon="solar:align-horizonta-spacing-line-duotone"></iconify-icon>
                    <span class="hide-menu">Locaties</span>
                  </a>
                </li>
              </ul>
            </nav>











            

            <!-- sidebar -->
         
          </div>
        </div>
      </div>
    </aside>
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <header class="topbar">
        <div class="with-vertical"><!-- ---------------------------------- -->
          <!-- Start Vertical Layout Header -->
          <!-- ---------------------------------- -->
          <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
              <li class="nav-item nav-icon-hover ms-n3">
                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                  <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                </a>
              </li>
              
            </ul>

            <div class="d-block d-lg-none">
              <img src="./assets/images/logos/dark-logo.svg" class="dark-logo" width="180" alt="MaterialM-img" />
              <img src="./assets/images/logos/light-logo.svg" class="light-logo" width="180" alt="MaterialM-img" />
            </div>
            <a class="navbar-toggler p-0 border-0 nav-icon-hover" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between">
               <ul class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                  <!-- <li class="nav-item nav-icon-hover dropdown">
                    <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                      <iconify-icon icon="solar:sort-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                  </li> -->
                  <!-- <li class="nav-item nav-icon-hover d-none d-xl-block">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                  </li>
                  <li class="nav-item nav-icon-hover">
                    <a class="nav-link moon dark-layout" href="javascript:void(0)">
                      <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                    </a>
                    <a class="nav-link sun light-layout" href="javascript:void(0)">
                      <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                    </a>
                  </li>
                  <li class="nav-item nav-icon-hover d-block d-xl-none">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                  </li> -->
                  <!-- ------------------------------- -->
                  <!-- start message Dropdown -->
                  <!-- ------------------------------- -->
                  <!-- <li class="nav-item nav-icon-hover dropdown">
                    <a class="nav-link position-relative" href="javascript:void(0)" id="drop2" aria-expanded="false">
                      <iconify-icon icon="solar:inbox-line-line-duotone" class="fs-6"></iconify-icon>
                      <span class="badge text-bg-primary fs-1 notification">3</span>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Inbox</h5>
                        <span class="badge text-bg-warning rounded-4 px-3 py-1 lh-sm">3 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-6.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-danger border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Michell Flintoff</h6>
                              <span class="fs-2 d-block">just now</span>
                            </div>
                            <span class="d-block w-100 text-truncate">You: Yesterdy was great...</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-2.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-primary border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Bianca Anderson</h6>
                              <span class="fs-2 d-block">5 mins ago</span>
                            </div>

                            <span class="d-block w-100 text-truncate">Nice looking dress you...</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-3.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-success border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Andrew Johnson</h6>
                              <span class="fs-2 d-block">10 mins ago</span>
                            </div>
                            <span class="d-block w-100 text-truncate">Sent a photo</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-4.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-warning border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Marry Strokes</h6>
                              <span class="fs-2 d-block">days ago</span>
                            </div>
                            <span class="d-block w-100 text-truncate">
                              If I don’t like something, I’ll stay away from it.
                            </span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-5.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-success border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Josh Anderson</h6>
                              <span class="fs-2 d-block">year ago</span>
                            </div>
                            <span class="d-block w-100 text-truncate">$230 deducted from account</span>
                          </div>
                        </a>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100">See All Messages</button> -->
                 
                  <!-- ------------------------------- -->
                  <!-- end message Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start notification Dropdown -->
                  <!-- ------------------------------- -->
                  <!-- <li class="nav-item nav-icon-hover dropdown">
                    <a class="nav-link position-relative" href="javascript:void(0)" id="drop2" aria-expanded="false">
                      <iconify-icon icon="solar:bell-bing-line-duotone" class="fs-6"></iconify-icon>
                      <div class="notification text-bg-danger rounded-circle fs-1">5</div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                        <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-danger-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-danger">
                            <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Launch Admin</h6>
                              <span class="d-block fs-2">9:30 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just see the my new admin!</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-primary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-primary">
                            <iconify-icon icon="solar:calendar-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Event today</h6>
                              <span class="d-block fs-2">9:15 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just a reminder that you have event</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-secondary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-secondary">
                            <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Settings</h6>
                              <span class="d-block fs-2">4:36 PM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">You can customize this template as you want</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-warning-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-warning">
                            <iconify-icon icon="solar:widget-4-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Launch Admin</h6>
                              <span class="d-block fs-2">9:30 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just see the my new admin!</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-primary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-primary">
                            <iconify-icon icon="solar:calendar-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Event today</h6>
                              <span class="d-block fs-2">9:15 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just a reminder that you have event</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-secondary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-secondary">
                            <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Settings</h6>
                              <span class="d-block fs-2">4:36 PM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">You can customize this template as you want</span>
                          </div>
                        </a>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100">See All Notifications</button>
                      </div>
                    </div>
                  </li> -->
                  <!-- ------------------------------- -->
                  <!-- end notification Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start profile Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)" id="drop1" aria-expanded="false">
                      <div class="d-flex align-items-center gap-2 lh-base">
                                     <img 
    src="{{ auth()->user()->profile_photo_url }}" 
    alt="{{ auth()->user()->name }}" 
     width="35" height="35"
    class="w-12 h-12 rounded-circle"
/>  
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
            
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                    

                                          
                  <img 
    src="{{ auth()->user()->profile_photo_url }}" 
    alt="{{ auth()->user()->name }}" 
    class="w-12 h-12 rounded-circle"
/>




                          <div class="ms-3">
                            <h5 class="mb-0 fs-4"> {{ auth()->user()->name }}</h5>
                            <span class="mb-1 d-block">Admin</span>
                            <p class="mb-0 d-flex align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i>  {{ auth()->user()->email }}
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="./main/page-user-profile.html" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded round">
                              <iconify-icon icon="solar:wallet-2-line-duotone" class="fs-7"></iconify-icon>
                            </span>
                            <div class="w-75 v-middle ps-3">
                              <h5 class="mb-1 fs-3 fw-medium">Mijn account</h5>
                              <span class="fs-2 d-block text-body-secondary">Profiel instellingen</span>
                            </div>
                          </a>
                      
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">Logout</button>
                        </div>
                      </div>
                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end profile Dropdown -->
                  <!-- ------------------------------- -->
                </ul>
              </div>
            </div>
          </nav>
          <!-- ---------------------------------- -->
          <!-- End Vertical Layout Header -->
          <!-- ---------------------------------- -->

          <!-- ------------------------------- -->
          <!-- apps Dropdown in Small screen -->
          <!-- ------------------------------- -->
          <!--  Mobilenavbar -->
          <div class="offcanvas offcanvas-start pt-0" data-bs-scroll="true" tabindex="-1" id="mobilenavbar" aria-labelledby="offcanvasWithBothOptionsLabel">
            <nav class="sidebar-nav scroll-sidebar">
              <div class="offcanvas-header justify-content-between">
                <a href="./main/index.html" class="text-nowrap logo-img">
                  <img src="./assets/images/logos/logo-icon.svg" alt="Logo" />
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body pt-0 h-n80" data-simplebar="" data-simplebar>
                <ul id="sidebarnav">
                  <li class="sidebar-item">
                    <a class="sidebar-link has-arrow ms-0" href="javascript:void(0)" aria-expanded="false">
                      <span>
                        <iconify-icon icon="solar:slider-vertical-line-duotone" class="fs-7"></iconify-icon>
                      </span>
                      <span class="hide-menu">Apps</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level my-3">
                      <li class="sidebar-item py-2">
                        <a href="./main/app-chat.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-chat.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Chat Application</h6>
                            <span class="fs-3 d-block text-muted">New messages arrived</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/app-invoice.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-invoice.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Invoice App</h6>
                            <span class="fs-3 d-block text-muted">Get latest invoice</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/app-contact2.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-mobile.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Contact Application</h6>
                            <span class="fs-3 d-block text-muted">2 Unsaved Contacts</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/app-email.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-message-box.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Email App</h6>
                            <span class="fs-3 d-block text-muted">Get new emails</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/page-user-profile.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-cart.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">User Profile</h6>
                            <span class="fs-3 d-block text-muted">learn more information</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/app-calendar.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-date.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Calendar App</h6>
                            <span class="fs-3 d-block text-muted">Get dates</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/app-contact.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-lifebuoy.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Contact List Table</h6>
                            <span class="fs-3 d-block text-muted">Add new contact</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="./main/app-notes.html" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/svgs/icon-dd-application.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div class="d-inline-block">
                            <h6 class="mb-0 bg-hover-primary">Notes Application</h6>
                            <span class="fs-3 d-block text-muted">To-do and Daily tasks</span>
                          </div>
                        </a>
                      </li>
                      <ul class="px-8 mt-7 mb-4">
                        <li class="sidebar-item mb-3">
                          <h5 class="fs-5 fw-semibold">Quick Links</h5>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/page-pricing.html">Pricing Page</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/authentication-login.html">Authentication
                            Design</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/authentication-register.html">Register
                            Now</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/authentication-error.html">404 Error
                            Page</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/app-notes.html">Notes App</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/page-user-profile.html">User
                            Application</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold bg-hover-primary" href="./main/page-account-settings.html">Account
                            Settings</a>
                        </li>
                      </ul>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link ms-0" href="./main/app-chat.html" aria-expanded="false">
                      <span>
                        <iconify-icon icon="solar:chat-unread-outline" class="fs-7"></iconify-icon>
                      </span>
                      <span class="hide-menu">Chat</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link ms-0" href="./main/app-calendar.html" aria-expanded="false">
                      <span>
                        <iconify-icon icon="solar:calendar-minimalistic-outline" class="fs-7"></iconify-icon>
                      </span>
                      <span class="hide-menu">Calendar</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link ms-0" href="./main/app-email.html" aria-expanded="false">
                      <span>
                        <iconify-icon icon="solar:inbox-unread-outline" class="fs-7"></iconify-icon>
                      </span>
                      <span class="hide-menu">Email</span>
                    </a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
        <div class="app-header with-horizontal">
          <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav">
              <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                  <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                </a>
              </li>
              <li class="nav-item d-none d-xl-block">
                <a href="." class="text-nowrap nav-link">
                  <img src="./assets/images/logos/dark-logo.svg" class="dark-logo" width="180" alt="MaterialM-img" />
                  <img src="./assets/images/logos/light-logo.svg" class="light-logo" width="180" alt="MaterialM-img" />
                </a>
              </li>
              <li class="nav-item nav-icon-hover d-none d-lg-block dropdown">
                <div class="hover-dd">
                  <a class="nav-link" id="drop2" href="javascript:void(0)" aria-haspopup="true" aria-expanded="false">
                    <iconify-icon icon="solar:widget-3-line-duotone" class="fs-6"></iconify-icon>
                  </a>
                  <div class="dropdown-menu dropdown-menu-nav  dropdown-menu-animate-up" aria-labelledby="drop2">
                    <div class="row">
                      <div class="col-8">
                        <div class="ps-3 pt-3">
                          <div class="border-bottom">
                            <div class="row">
                              <div class="col-6">
                                <div class="position-relative">
                                  <a href="./main/app-chat.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-chat.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Chat Application</h6>
                                      <span class="fs-2 d-block text-muted">New messages arrived</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-invoice.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-invoice.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Invoice App</h6>
                                      <span class="fs-2 d-block text-muted">Get latest invoice</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-contact2.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-mobile.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Contact Application</h6>
                                      <span class="fs-2 d-block text-muted">2 Unsaved Contacts</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-email.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-message-box.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Email App</h6>
                                      <span class="fs-2 d-block text-muted">Get new emails</span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="position-relative">
                                  <a href="./main/page-user-profile.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-cart.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">User Profile</h6>
                                      <span class="fs-2 d-block text-muted">learn more information</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-calendar.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-date.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Calendar App</h6>
                                      <span class="fs-2 d-block text-muted">Get dates</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-contact.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-lifebuoy.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Contact List Table</h6>
                                      <span class="fs-2 d-block text-muted">Add new contact</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-notes.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-circle round-40 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-application.svg" alt="MaterialM-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div class="d-inline-block">
                                      <h6 class="mb-1">Notes Application</h6>
                                      <span class="fs-2 d-block text-muted">To-do and Daily tasks</span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row align-items-center py-3">
                            <div class="col-8">
                              <a class="fw-semibold text-dark d-flex align-items-center lh-1 bg-hover-primary" href="./main/page-faq.html">
                                <i class="ti ti-help fs-6 me-2"></i>Frequently Asked Questions
                              </a>
                            </div>
                            <div class="col-4">
                              <div class="d-flex justify-content-end pe-4">
                                <button class="btn btn-primary rounded-pill">Check</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-4 ms-n4">
                        <div class="position-relative p-3 border-start h-100">
                          <h5 class="fs-5 mb-9 fw-semibold">Quick Links</h5>
                          <ul>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/page-pricing.html">Pricing Page</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/authentication-login.html">Authentication
                                Design</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/authentication-register.html">Register Now</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/authentication-error.html">404 Error Page</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/app-notes.html">Notes App</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/page-user-profile.html">User Application</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/page-account-settings.html">Account Settings</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

            </ul>
            <div class="d-block d-xl-none">
              <a href="." class="text-nowrap nav-link">
                <img src="./assets/images/logos/dark-logo.svg" width="180" alt="MaterialM-img" />
              </a>
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                      <iconify-icon icon="solar:sort-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                  </li>
                  <li class="nav-item nav-icon-hover d-none d-lg-block">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                  </li>
                  <li class="nav-item nav-icon-hover">
                    <a class="nav-link moon dark-layout" href="javascript:void(0)">
                      <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                    </a>
                    <a class="nav-link sun light-layout" href="javascript:void(0)">
                      <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                    </a>
                  </li>
                  <li class="nav-item nav-icon-hover d-block d-xl-none">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- start message Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item nav-icon-hover dropdown">
                    <a class="nav-link position-relative" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                      <iconify-icon icon="solar:inbox-line-line-duotone" class="fs-6"></iconify-icon>
                      <span class="badge text-bg-primary fs-1 notification">3</span>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Inbox</h5>
                        <span class="badge text-bg-warning rounded-4 px-3 py-1 lh-sm">3 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-6.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-danger border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Michell Flintoff</h6>
                              <span class="fs-2 d-block">just now</span>
                            </div>
                            <span class="d-block w-100 text-truncate">You: Yesterdy was great...</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-2.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-primary border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Bianca Anderson</h6>
                              <span class="fs-2 d-block">5 mins ago</span>
                            </div>

                            <span class="d-block w-100 text-truncate">Nice looking dress you...</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-3.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-success border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Andrew Johnson</h6>
                              <span class="fs-2 d-block">10 mins ago</span>
                            </div>
                            <span class="d-block w-100 text-truncate">Sent a photo</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-4.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-warning border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Marry Strokes</h6>
                              <span class="fs-2 d-block">days ago</span>
                            </div>
                            <span class="d-block w-100 text-truncate">
                              If I don’t like something, I’ll stay away from it.
                            </span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3 position-relative">
                            <img src="./assets/images/profile/user-5.jpg" alt="user" class="rounded-circle" width="45" height="45" />
                            <span class="position-absolute top-25 start-75 translate-middle-x p-1 bg-success border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </span>
                          <div class="w-75 v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1">Josh Anderson</h6>
                              <span class="fs-2 d-block">year ago</span>
                            </div>
                            <span class="d-block w-100 text-truncate">$230 deducted from account</span>
                          </div>
                        </a>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100">See All Messages</button>
                      </div>
                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end message Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start notification Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item nav-icon-hover dropdown">
                    <a class="nav-link position-relative" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                      <iconify-icon icon="solar:bell-bing-line-duotone" class="fs-6"></iconify-icon>
                      <div class="notification text-bg-danger rounded-circle fs-1">5</div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                        <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-danger-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-danger">
                            <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Launch Admin</h6>
                              <span class="d-block fs-2">9:30 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just see the my new admin!</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-primary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-primary">
                            <iconify-icon icon="solar:calendar-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Event today</h6>
                              <span class="d-block fs-2">9:15 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just a reminder that you have event</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-secondary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-secondary">
                            <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Settings</h6>
                              <span class="d-block fs-2">4:36 PM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">You can customize this template as you want</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-warning-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-warning">
                            <iconify-icon icon="solar:widget-4-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Launch Admin</h6>
                              <span class="d-block fs-2">9:30 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just see the my new admin!</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-primary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-primary">
                            <iconify-icon icon="solar:calendar-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Event today</h6>
                              <span class="d-block fs-2">9:15 AM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">Just a reminder that you have event</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span class="flex-shrink-0 bg-secondary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-secondary">
                            <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <div class="d-flex align-items-center justify-content-between">
                              <h6 class="mb-1 fw-semibold">Settings</h6>
                              <span class="d-block fs-2">4:36 PM</span>
                            </div>
                            <span class="d-block text-truncate text-truncate">You can customize this template as you want</span>
                          </div>
                        </a>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100">See All Notifications</button>
                      </div>
                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end notification Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start profile Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-flex align-items-center gap-2 lh-base">
                       
                                          
                  <img 
    src="{{ auth()->user()->profile_photo_url }}" 
    alt="{{ auth()->user()->name }}" 
     width="35" height="35"
    class="w-12 h-12 rounded-circle"
/>  
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                          <img 
    src="{{ auth()->user()->profile_photo_url }}" 
    alt="{{ auth()->user()->name }}" 
     width="35" height="35"
    class="w-12 h-12 rounded-circle"
/>  
                          <div class="ms-3">
                            <h5 class="mb-0 fs-4">Jonathan Deo</h5>
                            <span class="mb-1 d-block">Admin</span>
                            <p class="mb-0 d-flex align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> info@MaterialM.com
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="./main/page-user-profile.html" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded round">
                              <iconify-icon icon="solar:wallet-2-line-duotone" class="fs-7"></iconify-icon>
                            </span>
                            <div class="w-75 v-middle ps-3">
                              <h5 class="mb-1 fs-3 fw-medium">My Profile</h5>
                              <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                            </div>
                          </a>
                          <a href="./main/app-email.html" class="py-8 px-7 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center bg-success-subtle text-success rounded round">
                              <iconify-icon icon="solar:inbox-line-duotone" class="fs-7"></iconify-icon>
                            </span>
                            <div class="w-75 v-middle ps-3">
                              <h5 class="mb-1 fs-3 fw-medium">My Inbox</h5>
                              <span class="fs-2 d-block text-body-secondary">Messages & Emails</span>
                            </div>
                          </a>
                          <a href="./main/app-notes.html" class="py-8 px-7 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded round">
                              <iconify-icon icon="solar:checklist-minimalistic-line-duotone" class="fs-7"></iconify-icon>
                            </span>
                            <div class="w-75 v-middle ps-3">
                              <h5 class="mb-1 fs-3 fw-medium">My Task</h5>
                              <span class="fs-2 d-block text-body-secondary">To-do and Daily Tasks</span>
                            </div>
                          </a>
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">


                        <form method="POST" action="/logout">
    @csrf
    <button type="submit" class="btn btn-primary">
      Uitloggen
    </button>
</form>



 
                        </div>
                      </div>
                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end profile Dropdown -->
                  <!-- ------------------------------- -->
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!--  Header End -->
 

      <div class="body-wrapper">
 ss
 
      </div>
 
    </div>

      
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content rounded">
          <div class="modal-header border-bottom">
            <input type="search" class="form-control fs-3" placeholder="Search here" id="search" />
            <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
              <i class="ti ti-x fs-5 ms-3"></i>
            </a>
          </div>
          <div class="modal-body message-body" data-simplebar="">
            <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
            <ul class="list mb-0 py-2">
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="fs-3 text-dark fw-normal d-block">Analytics</span>
                  <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                </a>
              </li>
             
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <script src="./assets/js/vendor.min.js"></script>
  <!-- Import Js Files -->
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="./assets/js/theme/app.init.js"></script>
  <script src="./assets/js/theme/theme.js"></script>
  <script src="./assets/js/theme/app.min.js"></script>
  <script src="./assets/js/theme/sidebarmenu.js" defer></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <!-- highlight.js (code view) -->
  <script src="./assets/js/highlights/highlight.min.js"></script>
  <script>
  hljs.initHighlightingOnLoad();


  document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
    codeBlock.textContent = codeBlock.innerHTML;
  });
</script>
  <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="./assets/libs/jvectormap/jquery-jvectormap.min.js"></script>
  <script src="./assets/js/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
  <script src="./assets/js/dashboards/dashboard1.js"></script>
</body>

</html>