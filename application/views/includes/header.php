<!DOCTYPE html>
<html lang="en" dir = "ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>assets/images/favicon.png"> -->
    <title>Kiwo</title>
    <link href="<?= base_url(); ?>assets/libs/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/extra-libs/calendar/calendar.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="<?= base_url(); ?>dist/css/style.min.css" rel="stylesheet">
    <style type="text/css">
        .odd, .even {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper">
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                
                <a class="navbar-brand" href="<?= base_url(); ?>">
                    <!-- Logo icon -->
                    <b class="logo-icon p-l-10">
                        <!-- Dark Logo icon -->
                        <img src="<?= base_url(); ?>assets/images/kiwologo.png" alt="homepage" class="light-logo" width = "198" />
                        
                    </b>
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================= -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>

            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                  
                </ul>
                <a href="<?= base_url() ?>home/logout">Logout</a>
            </div>
        </nav>

    </header>