<?php $this->load->view('layout-header-dashboard') ?>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= sizeof($this->Bus_model->getAll()) ?></h3>

                <p>Bis Tersedia</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= base_url('/member/book') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
				<hr />
				<div class="row">
					<?php foreach($this->Bus_model->getAll() as $row): ?>
						<div class="col-4">
							<div class="card" style="width: 18rem;">
								<?php if($row->image): ?>
								<img src="<?= base_url('assets/upload/'.$row->image) ?>" alt="" class="img-card-top" srcset="" style="" />
								<?php else: ?>
								Gambar belum di upload
								<?php endif; ?>
								<div class="card-body">
									<h5 class="mb-2"><strong><?= $row->name ?></strong></h5>
									<div class="d-block">
										<div class="badge badge-info"><?= $row->plat ?></div>
										<div class="badge badge-info"><?= $this->Type_model->find($row->type_id)->name ?? '<small><i>Tipe tidak ada atau dibapus!</i></small>' ?></div>
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
