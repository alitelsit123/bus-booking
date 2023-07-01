<?php $this->load->view('layout-header-dashboard') ?>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">

		<div class="card">
			<div class="card-body">
				<!-- DataTables table -->
				<table id="myTable" class="table table-stripped">
					<thead>
						<tr>
							<th>#TX</th>
							<th>Nama Bus</th>
							<th>Informasi</th>
							<!-- <th>#Status sewa</th> -->
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($this->Book_model->getAll())) : ?>
							<?php foreach ($this->Book_model->getAll() as $book) : ?>
									<tr>
											<td><?= $book->code ?></td>
											<td><?= $this->Bus_model->find($book->bus_id)->name ?? '' ?></td>
											<td>
												<?php if($book->payment_date): ?>
												<div class="badge badge-success">Status pembayaran <?= $book->status ?></div><br />
												<div class="badge badge-success">Pembayaran Berhasil</div><br />
												<div class="badge badge-info">Tanggal sewa mulai <?= $book->start_book ?></div><br />
												<div class="badge badge-info">Tanggal sewa berakhir <?= $book->end_book ?></div><br />
												<?php else: ?>
												<div class="badge badge-warning">Status <?= $book->status ?></div>
												<?php endif; ?>
												<div class="card card-outlined mt-1">
													<div class="card-body">
													<small class="btn-block">Kota Penjemputan: <?= $book->city_from ?> <br />Lokasi Penjemputan: <?= $book->location_from ?></small>
													<small class="">Kota Tujuan: <?= $book->city_to ?> <br />Alamat Tujuan: <?= $book->location_to ?></small>
													</div>
												</div>
											</td>
											<!-- <td>
												<select name="" id="" class="form-control status-<?= $book->id ?>">
													<option value="">-- Pilih Aksi --</option>
													<option value="Belum di ambil" <?= $book->status_booking == 'Belum di ambil' ? 'selected':'' ?>>Belum diambil</option>
													<option value="Sedang di gunakan" <?= $book->status_booking == 'Sedang di gunakan' ? 'selected':'' ?>>Sedang digunakan</option>
													<option value="Sudah di kembalikan" <?= $book->status_booking == 'Sudah di kembalikan' ? 'selected':'' ?>>Dikembalikan</option>
												</select>
												<script>
													$(document).ready(function() {
														$('.status-<?= $book->id ?>').change(function() {
															$.post('<?= base_url('admin/bus/updateAttribute') ?>', {
																table: 'bookings',
																id: '<?= $book->id ?>',
																attr: 'status_booking',
																value: $(this).val(),
															}, function() {
																Swal.fire('Berhasil', 'Status Booking diupdate', 'success')	
															})
														})
													})
												</script>
											</td> -->
											<td>
												<?php if($book->payment_date): ?>
												<a target="_blank" href="<?= base_url('admin/transaction/invoice/'.$book->id) ?>" class="btn btn-sm btn-primary">Invoice</a>
												<?php endif; ?>
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
