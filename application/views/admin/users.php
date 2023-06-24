<?php $this->load->view('layout-header-dashboard') ?>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Button to trigger modal -->
		<button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#myModal">Tambah</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Buat Akun</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					<?php echo form_open('AuthController/action_register', 'post'); ?>
						
						<div class="form-group">
								<label for="type">Role:</label>
								<select name="type_id" id="" class="form-control">
									<option value=""></option>
									<option value="admin">Admin</option>
									<option value="customer">Member</option>
								</select>
						</div>

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
								<input type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone'); ?>">
								<small style="color:red;">
								
								<?= $this->session->flashdata('phone') ?>
								</small>
						</div>

						<div class="form-group">
								<label for="nik">NIK</label>
								<input type="text" class="form-control" name="nik" id="nik" value="<?php echo set_value('nik'); ?>">
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

						<button type="submit" class="btn btn-primary">Simpan</button>

						<?php echo form_close(); ?>
						<!-- End of your login form -->

					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<!-- DataTables table -->
				<table id="myTable" class="table table-stripped">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Email</th>
							<th>Nomor Hp</th>
							<th>NIK</th>
							<th>Alamat</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($this->Account_model->getAll())) : ?>
							<?php foreach ($this->Account_model->getAll() as $i => $account) : ?>
								<?php 
								if ($account->id == $this->session->userdata('user')->id) {
									continue;
								} 
								?>
									<tr>
											<td><?= $account->name ?></td>
											<td><?= $account->email ?></td>
											<td><?= $account->phone ?></td>
											<td><?= $account->nik ?></td>
											<td><?= $account->address ?></td>
											<td>
												<a href="#" class="btn btn-primary btn-xs update-btn" data-toggle="modal" data-target="#updateModal">
														<i class="fa fa-edit"></i>
												</a>
												<!-- Update Modal -->
												<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
														<div class="modal-dialog">
																<div class="modal-content">
																		<div class="modal-header">
																				<h4 class="modal-title" id="updateModalLabel">Update Type</h4>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">&times;</span>
																				</button>
																		</div>
																		<div class="modal-body">
																				<form action="<?= base_url('admin/account/update') ?>/<?= $account->id ?>" method="post">
																						<input type="hidden" name="id" value="<?= $account->id ?>">
																						<div class="form-group">
																								<label for="email">Email</label>
																								<input type="text" class="form-control" name="email" id="email" value="<?php echo $account->email; ?>">
																								<small style="color:red;">
																									<?= $this->session->flashdata('email') ?>
																								</small>
																						</div>

																						<div class="form-group">
																								<label for="name">Name</label>
																								<input type="text" class="form-control" name="name" id="name" value="<?php echo $account->name; ?>">
																								<small style="color:red;">
																								<?= $this->session->flashdata('name') ?>
																								
																								</small>
																						</div>

																						<div class="form-group">
																								<label for="phone">Phone</label>
																								<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $account->phone; ?>">
																								<small style="color:red;">
																								
																								<?= $this->session->flashdata('phone') ?>
																								</small>
																						</div>

																						<div class="form-group">
																								<label for="nik">NIK</label>
																								<input type="text" class="form-control" name="nik" id="nik" value="<?php echo $account->nik; ?>">
																								<small style="color:red;">
																								<?= $this->session->flashdata('nik') ?>
																								
																								</small>
																						</div>

																						<div class="form-group">
																								<label for="address">Address</label>
																								<textarea class="form-control" name="address" id="address" row="3"><?php echo $account->address; ?></textarea>
																								<small style="color:red;">
																								<?= $this->session->flashdata('address') ?>
																								
																								</small>
																						</div>
																						<button type="submit" class="btn btn-primary">Update</button>
																				</form>
																		</div>
																</div>
														</div>
												</div>


												<a href="#" class="btn btn-danger btn-xs delete-btn" data-id="<?= $account->id ?>">
														<i class="fa fa-trash"></i>
												</a>
											</td>
									</tr>
							<?php endforeach; ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
    <!-- /.content -->

<script>
	$(document).ready(function() {
		$('#myTable').DataTable()
	})
</script>


<script>
    // Add event listener to delete button
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();

        // Get the ID from data attribute
        var id = $(this).data('id');

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to delete this item?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then(function(isConfirm) {
            if (isConfirm.isConfirmed) {
							window.location.href = '<?= base_url('/admin') ?>/type/delete/' + id;
            }
        });
    });
</script>

<?php $this->load->view('layout-footer-dashboard') ?>
