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
						<div class="badge badge-info"><?= $this->Type_model->find($row->type_id)->name ?? '<small><i>Tipe tidak ada atau dibapus!</i></small>' ?></div>
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
						<div class="d-flex align-items-center justify-content-center">
							<a href="#d<?= $row->id ?>" data-toggle="modal" class="btn btn-default w-full flex-grow-1 mr-1">Detail Bus</a>
							<a
							data-toggle="modal"
							href="#exampleModal<?= $row->id ?>" 
							class="btn btn-primary w-full flex-grow-1 ml-1">Sewa Sekarang</a>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="d<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"><?= $row->name ?></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?php if($row->image): ?>
										<img src="<?= base_url('assets/upload/'.$row->image) ?>" alt="" srcset="" 
										style="width:100%;height:230px;object-fit:contain;"
										class="card-img-top" />
										<?php else: ?>
										Gambar belum di upload
										<?php endif; ?>
										<table class="table table-borderless">
											<tbody>
												<tr>
													<td>Nama Bus</td>
													<td><?= $row->name ?></td>
												</tr>
												<tr>
													<td>Mesin</td>
													<td><?= $row->mesin ?></td>
												</tr>
												<tr>
													<td>Plat</td>
													<td><?= $row->plat ?></td>
												</tr>
												<tr>
													<td>Tipe</td>
													<td><?= $this->Type_model->find($row->type_id)->name ?></td>
												</tr>
												<tr>
													<td>Tahun</td>
													<td><?= $row->year ?></td>
												</tr>
												<tr>
													<td>Jumlah Tempat Duduk</td>
													<td><?= $row->seat ?></td>
												</tr>
												<tr>
													<td>Harga</td>
													<td><?= $row->price_daily ?></td>
												</tr>
												<tr>
													<td colspan="2"><?= $row->description ?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary">Save changes</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="exampleModal<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Isi Form Dibawah ini</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="<?= base_url('member/book/checkout').'/'.$row->id ?>" method="get" class="form-<?= $row->id ?>">
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
											<div class="form-group mt-3">
												<label for="">Armada</label>
												<input type="text" readonly name="" value="<?= $row->name ?>" class="form-control" >
											</div>
											<div class="form-group mt-3">
												<label for="">Dari Kota</label>
												<input type="text" name="city_from" class="form-control" >
											</div>
											<div class="form-group">
												<label for="">Alamat Penjemputan</label>
												<input type="text" name="location_from" class="form-control" >
											</div>
											<hr />
											<div class="form-group mt-3">
												<label for="">Tujuan Kota</label>
												<input type="text" name="city_to" class="form-control" >
											</div>
											<div class="form-group">
												<label for="">Tujuan Wisata</label>
												<input type="text" name="location_to" class="form-control" >
											</div>
											<div class="alert alert-danger alert-<?= $row->id ?>" style="display:none;">
												<strong>Gagal!</strong> <span>Bus tidak tersedia.</span>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button
											type="button" 
											class="btn btn-primary btn-sbm-<?= $row->id ?>">Lanjutkan</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function() {
					$('.btn-sbm-<?= $row->id ?>').click(function() {
						$('.alert-<?= $row->id ?>').hide()
						$.post('<?= base_url('member/book/avaibility') ?>', {date: $('#reservation<?= $row->id ?>').val(),bus_id: <?= $row->id ?>}, function(data) {
							if (data.error) {
								$('.alert-<?= $row->id ?>').show()
							} else {
								$('.form-<?= $row->id ?>').submit()
							}
						})
					})
				})
			</script>
			<?php endforeach; ?>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php $this->load->view('layout-footer-dashboard') ?>
