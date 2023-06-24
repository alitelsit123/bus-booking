<?php $this->load->view('layout-header-dashboard') ?>

<?php
$attributes = [
	['name','Nama Perusahaan'],
	['alias','Alias Perusahaan'],
	['phone','Nomor Telepon'],
	['email','Email'],
	['address', 'Alamat'],
];
?>
<?php
// var_dump($this->Company_model->getAll());
?>
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<form action="<?= base_url('admin/company/update') ?>" method="post">
			<div class="row">
				<?php foreach($attributes as $row): ?>
				<input type="hidden" name="id" value="<?= $this->Company_model->first()->id ?>">
				<div class="form-group col-6">
					<label for=""><?= $row[1] ?></label>
					<?php if($row[0] == 'address'): ?>
					<textarea name="<?= $row[0] ?>" id="" rows="3" class="form-control" style="width:100%;"><?= $this->Company_model->first()->{$row[0]} ?></textarea>
					<?php else: ?>
					<input type="text" name="<?= $row[0] ?>" value="<?= $this->Company_model->first()->{$row[0]} ?>" class="form-control" id="" aria-describedby="emailHelp" placeholder="">
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<button type="submit" class="btn btn-primary mx-auto">Update</button>
		</form>
	</div><!-- /.container-fluid -->
</section>
    <!-- /.content -->


<?php $this->load->view('layout-footer-dashboard') ?>
