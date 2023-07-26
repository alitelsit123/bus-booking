<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        <?= $title; ?>
    </title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<style>
	
	body {
    background-position: center;
    background-color: #eee;
    background-repeat: no-repeat;
    background-size: cover;
    color: #505050;
    font-family: "Rubik",Helvetica,Arial,sans-serif;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.5;
    text-transform: none;
}

.forgot{
	    background-color: #fff;
    padding: 12px;
    border: 1px solid #dfdfdf;
}

.padding-bottom-3x {
    padding-bottom: 72px !important;
}

.card-footer{
	background-color: #fff;
}

.btn{ 

	font-size: 13px;
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #76b7e9;
    outline: 0;
    box-shadow: 0 0 0 0px #28a745;
}
               
</style>

<body>
    
<div class="container padding-bottom-3x mb-2 mt-5">
	<div class="row justify-content-center">
		<div class="col-lg-8 col-md-10">
			<!-- <div class="forgot">
				
				<h2>Forgot your password?</h2>
			<p>Change your password in three easy steps. This will help you to secure your password!</p>
			<ol class="list-unstyled">
				<li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
				<li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
				<li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
			</ol>

			</div>	 -->
			
			<form class="card mt-4" action="<?= base_url(uri_string()) ?>" method="post">
				<div class="card-body">
					
					<?php if($this->session->flashdata('sukses')): ?>
						<div class="alert alert-info">
							<strong>Informasi</strong> <?= $this->session->flashdata('sukses') ?>
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label for="email-for-pass">Password Baru</label>
						<input class="form-control" type="password" id="email-for-pass" name="password" required="">
					</div>
					<div class="form-group">
						<label for="email-for-pass">Konfirmasi Password</label>
						<input class="form-control" type="password" id="email-for-pass" name="passconf" required="">
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-success" type="submit">Simpan</button>
					<a href="<?= base_url('/') ?>" class="btn btn-danger">Kembali</a>
				</div>
			</form>
		</div>
	</div>
</div>
</body>

</html>
