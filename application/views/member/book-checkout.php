<?php $this->load->view('layout-header-dashboard') ?>
<?php
$existingBook = null;
if ($bus) {
	// $existingBook = $this->db->select('*')->get_where('bookings', ['bus_id' => $bus->id, 'user_id' => $this->session->userdata('user')->id])->row();
	$existingBook = $this->db->select('*')->get_where('bookings', ['status' => 'pending','bus_id' => $bus->id, 'user_id' => $this->session->userdata('user')->id])->row();
	// var_dump($existingBook);return;exit(0);
	if ($existingBook) {
		// var_dump($existingBook);
		if ($data['city_from'] && $data['location_from'] && $data['city_to'] && $data['location_to']) {
			$this->Book_model->update($existingBook->id,['city_from' => $data['city_from'],'location_from' => $data['location_from'], 'city_to' => $data['city_to'], 'location_to' => $data['location_to']]);
		}
	}
}
?>
<script>
var pollingInterval = null
var bookId = '<?= $existingBook ? $existingBook->id:'' ?>'
function checkStatus(bookIds) {
	$.ajax({
		url: '<?= base_url('member/book/checkToken') ?>/'+bookIds, // Replace with your server-side script URL
		method: 'GET',
		success: function(response) {
			// Process the response received from the server
			console.log(response)
			// Swal.fire('Berhasil', 'Pembayaran anda berhasil, Silahkan cek status transaksi di menu transaksi', 'success')

			// Check if the condition you are polling for is met
			if (response === 'success') {
				Swal.fire('Berhasil', 'Pembayaran anda berhasil, Silahkan cek status transaksi di menu transaksi', 'success')
				setTimeout(() => {
					document.location.href = "<?= base_url('member/transaction') ?>"
				}, 5000);
				// Stop polling
				clearInterval(pollingInterval);
				pollingInterval = null;
			}
		},
		error: function(xhr, status, error) {
			// Handle error situations
			console.error(error);
		}
	});
}
<?php if($existingBook): ?>
pollingInterval = setInterval(function() {
checkStatus(bookId);
}, 5000); // Poll every 5 seconds (adjust as needed)
<?php endif; ?>
</script>
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="callout callout-info">
					<h5><i class="fas fa-info"></i> Note:</h5>
					This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
				</div>


				<!-- Main content -->
				<div class="invoice p-3 mb-3">
					<!-- title row -->
					<div class="row">
						<div class="col-12">
							<h4>
								<i class="fas fa-globe"></i> <?= $this->Company_model->first()->name ?>
								<small class="float-right">TANGGAL SEWA: <strong><?= $start_date ?></strong> sampai <strong><?= $end_date ?></strong></small>
							</h4>
						</div>
						<!-- /.col -->
					</div>

					<div class="mb-4">
						<h1><?= $bus->name ?? '' ?></h1>
						<div><?= $bus->description ?? '' ?></div>
					</div>

					<!-- info row -->
					<div class="row invoice-info pl-2">
						<div class="col-sm-4 invoice-col card">
							<div class="card-body">
								Dari
								<address>
									<strong><?= $existingBook->city_from ?? $data['city_from'] ?></strong><br>
									<?= $existingBook->location_from ?? $data['location_from'] ?><br>
									Phone: <?= $this->Company_model->first()->phone ?><br>
									Email: <?= $this->Company_model->first()->email ?>
								</address>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-sm-4 invoice-col card ml-2">
							<div class="card-body">
								Ke
								<address>
									<strong><?= $existingBook->city_to ?? $data['city_to'] ?></strong><br>
									<?= $existingBook->location_to ?? $data['location_to'] ?><br>
									<!-- Phone: <?= $this->session->userdata('user')->phone ?><br>
									Email: <?= $this->session->userdata('user')->email ?> -->
								</address>
							</div>
						</div>
						<!-- /.col -->

						<!-- <div class="col-sm-4 invoice-col">
							<b>Invoice #007612</b><br>
							<br>
							<b>Order ID:</b> 4F3S8J<br>
							<b>Payment Due:</b> 2/22/2014<br>
							<b>Account:</b> 968-34567
						</div> -->
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row">
						<!-- accepted payments column -->
						<div class="col-6">
							<p class="lead">Payment Methods:</p>
							<img src="<?= base_url('assets/dist/img/credit/visa.png') ?>" alt="Visa">
							<img src="<?= base_url('assets/dist/img/credit/mastercard.png') ?>" alt="Mastercard">
							<img src="<?= base_url('assets/dist/img/credit/american-express.png') ?>" alt="American Express">
							<img src="<?= base_url('assets/dist/img/credit/paypal2.png') ?>" alt="Paypal">

							<p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
								<!-- Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
								plugg
								dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. -->
							</p>
						</div>
						<!-- /.col -->
						<div class="col-6">
							<!-- <p class="lead">Amount Due 2/22/2014</p> -->

							<div class="table-responsive">
								<table class="table">
									<tr>
										<th style="width:50%">Harga Perhari:</th>
										<td>Rp. <?= number_format($bus->price_daily) ?></td>
									</tr>
									<tr>
										<th></th>
										<?php
										$startDates = (new DateTime($start_date));
										?>
										<td><?= $startDates->diff(new DateTime($end_date))->days ?> hari * <?= $bus->price_daily ?></td>
									</tr>
									<tr>
										<th>Total:</th>
										<td>Rp. <?= number_format($startDates->diff(new DateTime($end_date))->days * $bus->price_daily) ?></td>
									</tr>
								</table>
							</div>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- this row will not appear when printing -->
					<div class="row no-print">
						<div class="col-12">
							<?php if($existingBook && $existingBook->status != 'pending'): ?>
							<a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
							<button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
								<i class="fas fa-download"></i> Generate PDF
							</button>
							<?php else: ?>
							<form action="<?= base_url('member/book/getToken') ?>" method="post">
								<input type="hidden" name="bus_id" value="<?= $bus->id ?>" />
								<input type="hidden" name="start_book" value="<?= $start_date ?>" />
								<input type="hidden" name="end_book" value="<?= $end_date ?>" />
								<button type="submit" class="btn btn-success float-right btn-pay"><i class="far fa-credit-card"></i>
									Bayar Sekarang
								</button>
							</form>
							<script type="text/javascript"
										src="https://app.sandbox.midtrans.com/snap/snap.js"
										data-client-key="SB-Mid-client-86RRXTySbEI4j9Ls"></script>
							<script>
								$(document).ready(function() {
									$('form').submit(function(e) {
										try {
											$.post($(this).attr('action'), {bus_id:'<?= $bus->id ?>',start_book:'<?= $start_date ?>',end_book: '<?= $end_date ?>'}, (r) => {
												const resp = JSON.parse(r)
												<?php if(!$existingBook): ?>
												pollingInterval = setInterval(function() {
													checkStatus(resp.id);
												}, 5000); // Poll every 5 seconds (adjust as needed)
												<?php endif; ?>
												window.snap.pay(resp.token, {
													onSuccess: function(result){
														/* You may add your own implementation here */
														checkStatus(resp.id)
														// Swal.fire('Berhasil', 'Pembayaran anda berhasil, Silahkan cek status transaksi di menu transaksi', 'success')
													},
													onPending: function(result){
														/* You may add your own implementation here */
														Swal.fire('Info', 'Menunggu pembayaran', 'info')
													},
													onError: function(result){
														/* You may add your own implementation here */
														Swal.fire('Info', 'Pembayaran gagal!', 'error')
													},
													onClose: function(){
														/* You may add your own implementation here */
														Swal.fire(
															'Informasi',
															'Silahkan bayar terlebih dahulu',
															'info'
														)
													}
												});
											})
										} catch (error) {
											alert('Server error!')
										}
										e.preventDefault()
										return false
									})
								})
							</script>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<!-- /.invoice -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?php $this->load->view('layout-footer-dashboard') ?>
