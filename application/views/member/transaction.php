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
							<th>#</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($this->Book_model->myBooks())) : ?>
							<?php foreach ($this->Book_model->myBooks() as $book) : ?>
									<tr>
											<td><?= $book->code ?></td>
											<td><?= $this->Bus_model->find($book->bus_id)->name ?></td>
											<td>
												<?php if($book->payment_date): ?>
												<div class="badge badge-success">Status <?= $book->status ?></div>
												<div class="badge badge-success">Pembayaran Berhasil</div>
												<div class="badge badge-info">Tanggal sewa mulai <?= $book->start_book ?></div>
												<div class="badge badge-info">Tanggal sewa berakhir <?= $book->end_book ?></div>
												<?php else: ?>
												<div class="badge badge-warning">Status <?= $book->status ?></div>
												<?php $cd = new DateTime($book->date);$cd->modify('+1 day'); ?>
												<br />
												<small style="color:red;">Mohon lunasi sebelum <?= $cd->format('Y-m-d') ?></small>
												<?php endif; ?>
											</td>
											<td>
												<?php if(!$book->payment_date): ?>
												<form action="<?= base_url('member/book/checkout') ?>/<?= $book->bus_id ?>" method="get">
													<input type="hidden" name="date" value="<?= $book->start_book ?> - <?= $book->end_book ?>" />
													<button type="submit" class="btn btn-success float-right">
														Bayar Sekarang
													</button>
												</form>
												<?php endif; ?>
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