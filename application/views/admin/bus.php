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
						<h4 class="modal-title" id="myModalLabel">Buat Bus</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form inside the modal -->
						<form action="<?php echo base_url('admin/bus/create'); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
									<label for="type">Name:</label>
									<input type="text" class="form-control" id="type" name="name">
							</div>
							<div class="form-group">
									<label for="type">Gambar:</label>
									<input type="file" class="form-control" id="type" name="image">
							</div>
							<div class="form-group">
									<label for="type">Plat:</label>
									<input type="text" class="form-control" id="type" name="plat">
							</div>
							<div class="form-group">
									<label for="type">Mesin:</label>
									<input type="text" class="form-control" id="type" name="mesin">
							</div>
							<div class="form-group">
									<label for="type">Tipe:</label>
									<select name="type_id" id="" class="form-control">
										<option value=""></option>
										<?php foreach($this->Type_model->getAll() as $type): ?>
										<option value="<?= $type->id ?>"><?= $type->name ?></option>
										<?php endforeach; ?>
									</select>
							</div>
							<div class="form-group">
									<label for="type">Year:</label>
									<input type="number" class="form-control" id="type" name="year">
							</div>
							<div class="form-group">
									<label for="type">Seat:</label>
									<input type="number" class="form-control" id="type" name="seat">
							</div>
							<div class="form-group">
									<label for="type">Harga per hari:</label>
									<input type="number" class="form-control" id="type" name="price_daily">
							</div>
							<div class="form-group">
									<label for="type">Deskripsi:</label>
									<textarea name="description" id="" rows="3" class="form-control"></textarea>
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
							<th>Gambar</th>
							<th>Plat</th>
							<th>Type</th>
							<th>Harga per hari</th>
							<th>Status</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($this->Bus_model->getAll())) : ?>
							<?php foreach ($this->Bus_model->getAll() as $bus) : ?>
									<tr>
											<td><?= $bus->id ?></td>
											<td><?= $bus->name ?></td>
											<td>
												<?php if($bus->image): ?>
												<img src="<?= base_url('assets/upload/'.$bus->image) ?>" alt="" srcset="" style="width:50px;height:50px;border-radius:9999px;" />
												<?php else: ?>
												Gambar belum di upload
												<?php endif; ?>
												<br />
												<input type="file" name="" id="" class="d-none file-<?= $bus->id ?>" />
												<button type="button" class="btn btn-xs btn-primary mt-2 update-image-btn-<?= $bus->id ?>">Update Gambar</button>
												<script>
													$(document).ready(function() {
														$('.update-image-btn-<?= $bus->id ?>').click(function() {
															$('.file-<?= $bus->id ?>').click()
														})
														$('.file-<?= $bus->id ?>').change(function() {
															var formData = new FormData(); // Create a new FormData object
															var imageFile = $(this)[0].files[0]; // Get the selected image file

															formData.append('image', imageFile); // Append the file to the FormData object

															// Send the image parameter using $.post()
															$.ajax({
																url: '<?= base_url('admin/bus/validateImage') ?>', // Replace with your server-side endpoint
																type: 'POST',
																data: formData,
																contentType: false, // Set contentType and processData to false
																processData: false,
																success: function(response) {
																	$.post('<?= base_url('admin/bus/updateAttribute') ?>', {
																		table: 'busses',
																		id: '<?= $bus->id ?>',
																		attr: 'image',
																		value: response,
																	}, function() {
																		Swal.fire('Berhasil', 'Gambar diupdate', 'success')	
																		setTimeout(() => {
																			location.reload()
																		}, 1000);
																	})
																},
																error: function(xhr, status, error) {
																	Swal.fire('Gagal!', 'Gagal upload gambar', 'error')	
																}
															});
														})
													})
												</script>
											</td>
											<td><?= $bus->plat ?></td>
											<td><?= $this->Type_model->find($bus->type_id)->name ?? '<small><i>Tipe tidak ada atau dibapus!</i></small>' ?></td>
											<td><?= $bus->price_daily ?></td>
											<td>
												<select name="status" id="" class="form-control type-<?= $bus->id ?>">
													<option value=""></option>
													<?php foreach(['Active','Di Booking','Tidak Aktif'] as $status): ?>
													<option value="<?= $status ?>" <?= $status == $bus->status ? 'selected':'' ?>><?= $status ?></option>
													<?php endforeach; ?>
												</select>
												<script>
													$(document).ready(function() {
														$('.type-<?= $bus->id ?>').change(function() {
															$.post('<?= base_url('admin/bus/updateAttribute') ?>', {
																table: 'busses',
																id: '<?= $bus->id ?>',
																attr: 'status',
																value: $(this).val(),
															}, function() {
																Swal.fire('Berhasil', 'Status diupdate', 'success')	
															})
														})
													})
												</script>
											</td>
											<td>
												<a href="#" class="btn btn-primary btn-xs update-btn" data-toggle="modal" data-target="#updateModal">
														<i class="fa fa-edit"></i>
												</a>
												<!-- Update Modal -->
												<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
														<div class="modal-dialog">
																<div class="modal-content">
																		<div class="modal-header">
																				<h4 class="modal-title" id="updateModalLabel">Update bus</h4>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">&times;</span>
																				</button>
																		</div>
																		<div class="modal-body">
																				<!-- Form inside the modal -->
																				<form action="<?php echo base_url('admin/bus/update/'.$bus->id); ?>" method="post" enctype="multipart/form-data">
																					<div class="form-group">
																							<label for="type">Name:</label>
																							<input type="text" class="form-control" id="type" name="name" value="<?= $bus->name ?>">
																					</div>
																					<div class="form-group">
																							<label for="type">Plat:</label>
																							<input type="text" class="form-control" id="type" name="plat" value="<?= $bus->plat ?>">
																					</div>
																					<div class="form-group">
																							<label for="type">Mesin:</label>
																							<input type="text" class="form-control" id="type" name="mesin" value="<?= $bus->mesin ?>">
																					</div>
																					<div class="form-group">
																							<label for="type">Tipe:</label>
																							<select name="type_id" id="" class="form-control">
																								<option value=""></option>
																								<?php foreach($this->Type_model->getAll() as $type): ?>
																								<option value="<?= $type->id ?>" <?php if($bus->type_id == $type->id): ?> selected <?php endif; ?>><?= $type->name ?></option>
																								<?php endforeach; ?>
																							</select>
																					</div>
																					<div class="form-group">
																							<label for="type">Year:</label>
																							<input type="number" class="form-control" id="type" name="year" value="<?= $bus->year ?>">
																					</div>
																					<div class="form-group">
																							<label for="type">Seat:</label>
																							<input type="number" class="form-control" id="type" name="seat" value="<?= $bus->seat ?>">
																					</div>
																					<div class="form-group">
																							<label for="type">Harga per hari:</label>
																							<input type="number" class="form-control" id="type" name="price_daily" value="<?= $bus->price_daily ?>">
																					</div>
																					<div class="form-group">
																							<label for="type">Deskripsi:</label>
																							<textarea name="description" id="" rows="3" class="form-control"><?= $bus->description ?></textarea>
																					</div>
																					<button type="submit" class="btn btn-primary">Submit</button>
																				</form>
																		</div>
																</div>
														</div>
												</div>
												<a href="#" class="btn btn-danger btn-xs delete-btn" data-id="<?= $bus->id ?>">
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
