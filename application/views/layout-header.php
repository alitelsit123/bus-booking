<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>PT Trans Salim Barakatullah</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
      <!-- style css -->
      <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
      <!-- Responsive-->
      <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css') ?>">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="<?= base_url('assets/css/jquery.mCustomScrollbar.min.css') ?>">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   </head>

   <!-- body -->
   <body class="main-layout">
	 		<?php 
			if ($this->session->flashdata('error')) {
			?>
			<script>
				Swal.fire(
					'Error!',
					'<?= $this->session->flashdata('error') ?>',
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
					`<?= $this->session->flashdata('success') ?>`,
					'success'
				)
			</script>
			<?php } ?>

			<!-- Modal -->
			<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-loginTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Silahkan isi form dibawah ini</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<ul class="nav nav-pills nav-fill">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab-login" role="tab" aria-controls="login" aria-selected="true">Masuk</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab-register" role="tab" aria-controls="register" aria-selected="true">Daftar</a>
								</li>
							</ul>
							<hr />
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active py-4" id="tab-login" role="tabpanel" aria-labelledby="tab-login-tab">
									<?php echo form_open('AuthController/action_login', 'post'); ?>

									<!-- Email field -->
									<div class="form-group">
										<label for="email">Email</label>
										<input type="email" name="email" class="form-control" value="<?php echo set_value('email', $this->session->flashdata('old')['email'] ?? ''); ?>">
										<?php echo form_error('email'); ?>
									</div>

									<!-- Password field -->
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>">
										<?php echo form_error('password'); ?>
									</div>
									
									<div class="d-flex align-items-center justify-content-between">
										<?php
										echo anchor(site_url() . 'lupa_password', 'Lupa Password');
										?>
										<button type="submit" class="btn btn-primary">Login</button>
									</div>

									<?php echo form_close(); ?>
									<!-- End of your login form -->

								</div>
								<div class="tab-pane fade" id="tab-register" role="tabpanel" aria-labelledby="tab-register-tab">
									<?php echo form_open('AuthController/action_register', 'post'); ?>

									<div class="form-group">
											<label for="email">Email</label>
											<input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>">
											<small style="color:red;">
												<?= $this->session->flashdata('email') ?>
											</small>
									</div>

									<div class="form-group">
											<label for="password">Password</label>
											<input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>">
											<small style="color:red;">
											<?= $this->session->flashdata('password') ?>
											</small>
											
									</div>

									<div class="form-group">
											<label for="name">Name</label>
											<input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>">
											<small style="color:red;">
											<?= $this->session->flashdata('name') ?>
											
											</small>
									</div>

									<div class="form-group">
											<label for="phone">Phone</label>
											<input type="number" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone'); ?>">
											<small style="color:red;">
											
											<?= $this->session->flashdata('phone') ?>
											</small>
									</div>

									<div class="form-group">
											<label for="nik">NIK</label>
											<input type="number" class="form-control" name="nik" id="nik" value="<?php echo set_value('nik'); ?>">
											<small style="color:red;">
											<?= $this->session->flashdata('nik') ?>
											
											</small>
									</div>

									<div class="form-group">
											<label for="address">Address</label>
											<textarea class="form-control" name="address" id="address" row="3"><?php echo set_value('address'); ?></textarea>
											<small style="color:red;">
											<?= $this->session->flashdata('address') ?>
											
											</small>
									</div>

									<button type="submit" class="btn btn-primary">Register</button>

									<?php echo form_close(); ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
      <!-- loader  -->
      <!-- <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div> -->
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="<?= base_url('/assets/logo.png') ?>" alt="#" style="width: 40px;height:40px;" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="<?= base_url('/') ?>"> Home  </a>
                              </li>
                              <!-- <li class="nav-item">
                                 <a class="nav-link" href="about.html">About</a>
                              </li> -->
                              <li class="nav-item">
                                 <a class="nav-link" href="#testimonial">Testimonial</a>
                              </li>
                              <!-- <li class="nav-item">
                                 <a class="nav-link" href="#contact">Contact Us</a>
                              </li> -->
															<?php if($this->session->userdata('user')): ?> 
																<li class="nav-item dropdown">
																<a class="nav-link dropdown-toggle" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle padd_right" aria-hidden="true"></i><?= $this->session->userdata('user')->email ?></a>
																	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
																		<?php if($this->session->userdata('user')->role == 'admin'):?>
																		<a class="dropdown-item" href="<?= base_url('/admin/dashboard') ?>">Admin Area</a>
																		<?php else:?>
																		<a class="dropdown-item" href="<?= base_url('/member/dashboard') ?>">Member Area</a>
																		<?php endif;?>
																		<a class="dropdown-item" href="<?= base_url('/AuthController/logout') ?>">Logout</a>
																	</div>
																</li>
															<?php else:?>
																<li class="nav-item d_none">
																	<a class="nav-link" href="#modal-login" data-toggle="modal"><i class="fa fa-user-circle padd_right" aria-hidden="true"></i>Login/Register</a>
																</li>
															<?php endif;?>

                              <li class="nav-item d_none">
                                 <a class="nav-link" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
