<!DOCTYPE html>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1QJ3W3GSSX"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-1QJ3W3GSSX');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <style>
    .error {
        color: red;
        font-weight: normal;
    }
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>PEF</b> QAT-2025</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>PEF </b>QAT-2025</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle
                        navigation</span> </a> <span
                    style="font-weight: bold; font-size: 20px; color: white; margin-left:20px; padding-top: 20px; line-height: 50px;">Welcome
                    <?php echo $this->session->userdata('roleText').' '.$this->session->userdata('district_name').' '.$this->session->userdata('name'); 
				
				//print_r($this->session->userdata('role')); //die();
				?></span>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown tasks-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true"> <i class="fa fa-history"></i> </a>
                            <ul class="dropdown-menu">
                                <li class="header"> Last Login : <i class="fa fa-clock-o"></i>
                                    <?= empty($last_login) ? "First Time Login" : $last_login; ?>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image"
                                    alt="User Image" /> <span class="hidden-xs"><?php echo $name; ?></span> </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header"> <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png"
                                        class="img-circle" alt="User Image" />
                                    <p> <?php echo $name; ?> <small><?php echo $role_text; ?></small> </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left"> <a href="<?php echo base_url(); ?>profile"
                                            class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i>
                                            Profile</a> </div>
                                    <div class="pull-right"> <a href="<?php echo base_url(); ?>logout"
                                            class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li> <a href="<?php echo base_url(); ?>dashboard"> <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span></i>
                        </a>
                    </li>
                    <li> <a href="<?php echo base_url(); ?>profile"> <i class="fa fa-ticket"></i> <span>My
                                Profile</span>
                        </a>
                    </li>
                    <?php
                            if ( $role == ROLE_ADMIN || $role == ROLE_MANAGER ) {
                    ?>
                    <li> <a href="<?php echo base_url(); ?>Center/centerListing"> <i class="fa fa-thumb-tack"></i>
                            <span>Exam Centers</span>
                        </a>
                    </li>
                    <?php
                      }
                      if ( $role == ROLE_ADMIN ) {
                            ?>
                    <li> <a href="<?php echo base_url(); ?>userListing"> <i class="fa fa-users"></i> <span>CEOs
                                Details</span>
                        </a>
                    </li>
                    <li> <a href="<?php echo base_url('Pef_School/PefschoolListing'); ?>"> <i
                                class="fa fa-university"></i> <span>Pef Schools</span> </a> </li>
                    <li> <a href="<?php echo base_url('Sed_School/SedschoolListing'); ?>"> <i
                                class="fa fa-graduation-cap"></i> <span>Sed Schools</span> </a> </li>
                    <?php /*?>
                    <li>
                        <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <?php */ ?>
                    <?php
                      }
                       ?>
                    <li> <a href="<?php echo base_url(); ?>logout"> <i class="fa fa-thumb-tack"></i> <span>Logout</span>
                        </a> </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>