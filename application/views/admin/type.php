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
						<h4 class="modal-title" id="myModalLabel">Buat Type</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form inside the modal -->
						<form action="<?php echo base_url('admin/type/create'); ?>" method="post">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
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
							<th>#</th>
							<th>Name</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($this->Type_model->getAll())) : ?>
							<?php foreach ($this->Type_model->getAll() as $type) : ?>
									<tr>
											<td><?= $type->id ?></td>
											<td><?= $type->name ?></td>
											<td>
												<a href="#" class="btn btn-primary btn-xs update-btn" data-toggle="modal" data-target="#updateModal<?= $type->id ?>">
														<i class="fa fa-edit"></i>
												</a>
												<!-- Update Modal -->
												<div class="modal fade" id="updateModal<?= $type->id ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
														<div class="modal-dialog">
																<div class="modal-content">
																		<div class="modal-header">
																				<h4 class="modal-title" id="updateModalLabel">Update Type</h4>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">&times;</span>
																				</button>
																		</div>
																		<div class="modal-body">
																				<form action="<?= base_url('admin/type/update') ?>/<?= $type->id ?>" method="post">
																						<input type="hidden" name="id" value="<?= $type->id ?>">
																						<div class="form-group">
																								<label for="type">Name:</label>
																								<input type="text" class="form-control" id="type" name="name" value="<?= $type->name ?>">
																						</div>
																						<button type="submit" class="btn btn-primary">Update</button>
																				</form>
																		</div>
																</div>
														</div>
												</div>


												<a href="#" class="btn btn-danger btn-xs delete-btn" data-id="<?= $type->id ?>">
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
