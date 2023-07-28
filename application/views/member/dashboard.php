<?php $this->load->view('layout-header-dashboard') ?>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
				<div class="row">
					<?php foreach($this->Bus_model->getAll() as $row): ?>
						<div class="col-4">
							<div class="card">
								<?php if($row->image): ?>
								<img src="<?= base_url('assets/upload/'.$row->image) ?>" alt="" class="img-card-top" srcset="" style="" />
								<?php else: ?>
								Gambar belum di upload
								<?php endif; ?>
								<div class="card-body">
									<h5 class="mb-2"><strong><?= $row->name ?></strong></h5>
									<div class="d-block">
										<div class="badge badge-info"><?= $this->Type_model->find($row->type_id)->name ?? '<small><i>Tipe tidak ada atau dibapus!</i></small>' ?></div>
										<div class="badge badge-info">Rp. <?= number_format($row->price_daily) ?></div>
									</div>
									<!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php $this->load->view('layout-footer-dashboard') ?>
