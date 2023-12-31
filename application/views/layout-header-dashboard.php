<?php
$guard = $this->session->userdata('user');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= ucfirst($this->uri->segment(2)) ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/jqvmap/jqvmap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('/assets/dist/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/daterangepicker/daterangepicker.css') ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('/assets/plugins/summernote/summernote-bs4.min.css') ?>">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


	<!-- jQuery -->
	<script src="<?= base_url('/assets/plugins/jquery/jquery.min.js') ?>"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?= base_url('/assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<!-- ChartJS -->
	<script src="<?= base_url('/assets/plugins/chart.js/Chart.min.js') ?>"></script>
	<!-- Sparkline -->
	<script src="<?= base_url('/assets/plugins/sparklines/sparkline.js') ?>"></script>
	<!-- JQVMap -->
	<script src="<?= base_url('/assets/plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
	<script src="<?= base_url('/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?= base_url('/assets/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
	<!-- daterangepicker -->
	<script src="<?= base_url('/assets/plugins/moment/moment.min.js') ?>"></script>
	<script src="<?= base_url('/assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?= base_url('/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
	<!-- Summernote -->
	<script src="<?= base_url('/assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
	<!-- overlayScrollbars -->
	<script src="<?= base_url('/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('/assets/dist/js/adminlte.js') ?>"></script>

	<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
	<?php 
	if ($this->session->flashdata('error')) {
	?>
	<script>
		Swal.fire(
			'Error!',
			'<?= str_replace(array("\r", "\n"), '', $this->session->flashdata('error')) ?>',
			'error'
		)
	</script>
	<?php } ?>

	<?php 
	if ($this->session->flashdata('success')) {
	?>
	<script>
		Swal.fire(
			'Berhasil!',
			`<?= str_replace(array("\r", "\n"), '', $this->session->flashdata('success')) ?>`,
			'success'
		)
	</script>
	<?php } ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?= base_url('/assets/logo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?= $this->Company_model->first()->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://w7.pngwing.com/pngs/831/88/png-transparent-user-profile-computer-icons-user-interface-mystique-miscellaneous-user-interface-design-smile-thumbnail.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
						<?= $this->session->userdata('user')->name ?>
						<!-- <span class="badge badge-info"><?= $this->session->userdata('user')->role ?></span> -->
					</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url(($this->session->userdata('user')->role == 'customer' ? 'member':'admin').'/dashboard') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
					<?php if($guard->role == 'admin'):?>
						<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
							<li class="nav-item">
                <a href="<?= base_url('/admin/type') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Type</p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('/admin/bus') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Bus</p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('/admin/account') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pengguna</p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('admin/company') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Perusahaan</p>
                </a>
              </li>
            </ul>
          </li>
					<li class="nav-item">
            <a href="<?= base_url('admin/transaction') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
              <p>
                Transaksi
								<?php if($this->Book_model->adminPendingCount() > 0): ?>
                <span class="right badge badge-danger"><?= $this->Book_model->adminPendingCount() > 0 ?></span>
								<?php endif; ?>
              </p>
            </a>
          </li>
					<?php else:?>
					<li class="nav-item">
						<a href="<?= base_url('/member/book') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Sewa</p>
						</a>
					</li>
					<li class="nav-item">
            <a href="<?= base_url('member/transaction') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
              <p>
                Transaksi
								<?php if($this->Book_model->pendingCount() > 0): ?>
                <span class="right badge badge-danger"><?= $this->Book_model->pendingCount() > 0 ?></span>
								<?php endif; ?>
              </p>
            </a>
          </li>
					<?php endif;?>
					<li class="nav-item">
            <a href="<?= base_url('/AuthController/logout') ?>" class="nav-link">
							<i class="fas fa-sign-out-alt nav-icon"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= ucfirst($this->uri->segment(2)) ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
