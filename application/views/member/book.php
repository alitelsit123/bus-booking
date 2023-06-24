<?php $this->load->view('layout-header-dashboard') ?>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<?php foreach($this->Bus_model->getAll() as $row): ?>
			<?php if($row->status != 'Active'): continue; endif; ?>
			<div class="col-md-4">
				<div class="card">
					<div class="card-header"><h4>
						<?= $row->name ?></h4>
						<div class="badge badge-info"><?= $this->Type_model->find($row->type_id)->name ?></div>
					</div>
					<?php if($row->image): ?>
					<img src="<?= base_url('assets/upload/'.$row->image) ?>" alt="" srcset="" 
					style="width:100%;height:230px;object-fit:contain"
					class="card-img-top" />
					<?php else: ?>
					Gambar belum di upload
					<?php endif; ?>
					<div class="card-body">
						<p class="card-text">
							<?= strlen($row->description) > 100 ? substr($row->description, 0, 100).'...':$row->description ?>
						</p>
						<a
						data-toggle="modal"
						href="#exampleModal<?= $row->id ?>" 
						class="btn btn-primary btn-block">Sewa Sekarang</a>
						<!-- Modal -->
						<div class="modal fade" id="exampleModal<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Pilih Rentan Waktu</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="<?= base_url('member/book/checkout').'/'.$row->id ?>" method="get">
										<div class="modal-body">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" name="date" class="form-control float-right" id="reservation<?= $row->id ?>" readonly>
												<script>
													(function() {
														$('#reservation<?= $row->id ?>').daterangepicker({
															locale: {
																format: 'YYYY-MM-DD'
															}
														})
													})()
												</script>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button
											type="submit" 
											class="btn btn-primary">Lanjutkan</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php $this->load->view('layout-footer-dashboard') ?>
