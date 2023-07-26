<?php $this->load->view('layout-header-dashboard') ?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body">
            <!-- Date Range Filter -->
            <div class="form-group">
               <label for="date-range">Filter by Date Range:</label>
               <input type="text" id="date-range" class="form-control mb-3">
               <form action="<?php echo base_url('admin/transaction/cetak'); ?>" method="POST" target="_blank">
                <div class="row">
                    <div class="col-md-3">
                        <label for="awal">Tanggal Awal</label>
                        <input type="date" name="awal" id="awal" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="akhir">Tanggal Akhir</label>
                        <input type="date" name="akhir" id="akhir" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="bus">Armada</label>
                        <select name="bus" id="bus" class="form-control">
                            <option value=""></option>
                            <?php 
                            $host = mysqli_connect("localhost","root","","bus_booking");
                            $query_mysql = mysqli_query($host, "SELECT * FROM busses")or die(mysqli_error());
                            while($dt = mysqli_fetch_array($query_mysql)){
                                ?>
                            <option value="<?= $dt['id'] ?>"><?= $dt['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="cetak" style="color: #fff;">p</label>
                        <button type="submit" class="btn btn-primary" id="cetak" style="width: 100%">Cetak</button>
                    </div>
                </div>
               </form>
            </div>
            <!-- DataTables table -->
            <table id="myTable" class="table table-stripped">
               <thead>
                  <tr>
                     <th>#TX</th>
                     <th>Nama Bus</th>
                     <th>Informasi</th>
                     <th>Tanggal Transaksi</th>
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
                        <?php if ($book->payment_date) : ?>
                        <div class="badge badge-success">Status pembayaran <?= $book->status ?></div>
                        <br />
                        <div class="badge badge-success">Pembayaran Berhasil</div>
                        <br />
                        <div class="badge badge-info">Tanggal sewa mulai <?= $book->start_book ?></div>
                        <br />
                        <div class="badge badge-info">Tanggal sewa berakhir <?= $book->end_book ?></div>
                        <br />
                        <?php else : ?>
                        <div class="badge badge-warning">Status <?= $book->status ?></div>
                        <?php endif; ?>
                        <div class="card card-outlined mt-1">
                           <div class="card-body">
                              <small class="btn-block">Kota Penjemputan: <?= $book->city_from ?> <br />Lokasi Penjemputan: <?= $book->location_from ?></small>
                              <small class="">Kota Tujuan: <?= $book->city_to ?> <br />Alamat Tujuan: <?= $book->location_to ?></small>
                           </div>
                        </div>
                     </td>
                     <td>
                        <?= $book->payment_date ?>
                     </td>
                     <td>
                        <?php if ($book->payment_date) : ?>
                        <a target="_blank" href="<?= base_url('admin/transaction/invoice/' . $book->id) ?>" class="btn btn-sm btn-primary">Invoice</a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/transaction/delete/' . $book->id) ?>" class="btn btn-sm btn-danger delete-btn" data-id="<?= $book->id ?>">Hapus</a>
                     </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
               </tbody>
            </table>
            <!-- Line Chart -->
            <div class="chart-container">
               <canvas id="lineChart"></canvas>
            </div>
            <hr />
            <!-- Line Chart -->
            <div class="chart-container">
               <canvas id="lineCharts"></canvas>
            </div>
            <hr />
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<!-- /.content -->
<script>
   var sd = null;
   var ed = null;
   var s = null;
     $(document).ready(function() {
			   // Custom filtering function which will search data in column four between two values
	 DataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = new Date(sd);
    let max = new Date(ed);
		// console.log(new Date(data[3]))
    let date = new Date(data[3]);
 
    if (
        (sd === null && sd === null) ||
        (sd === null && date <= max) ||
        (min <= date && sd === null) ||
        (min <= date && date <= max)
    ) {
        return true;
    }
    return false;
});
         // Initialize DataTables
         var table = $('#myTable').DataTable({
         initComplete: function() {
             // Apply search to "Nama Bus" column only
             var searchInput = $('#myTable_filter input');
             searchInput.unbind().bind('keyup', function() {
                 var searchTerm = $(this).val().toLowerCase();
                 table.columns(1).search(searchTerm, true, false).draw();
   						s = $(this).val()
   						// Fetch data for line chart based on selected date range
   		$.ajax({
   			url: '<?= base_url('admin/transaction/fetch_data') ?>',
   			method: 'GET',
   			data: {
   					startDate: sd,
   					endDate: ed,
   					search: s
   			},
   			success: function(response) {
   					var labels = [];
   					var data = [];
   					JSON.parse(response).forEach(function(item) {
   							labels.push(item.date);
   							data.push(item.total);
   					});
   
   					// Create Line Chart using Chart.js
   					var ctx = document.getElementById('lineChart').getContext('2d');
   					var lineChart = new Chart(ctx, {
   							type: 'line',
   							data: {
   									labels: labels,
   									datasets: [{
   											label: 'Gross Amount',
   											data: data,
   											borderColor: 'rgba(255, 99, 132, 1)',
   											backgroundColor: 'rgba(255, 99, 132, 0.2)',
   									}]
   							},
   							options: {
   									responsive: true,
   									scales: {
   											y: {
   													beginAtZero: true
   											}
   									}
   							}
   					});
   			},
   			error: function(error) {
   					console.log(error);
   			}
   	});
		 $.ajax({
     url: '<?= base_url('admin/transaction/fetch_datab') ?>',
     method: 'GET',
     data: {
   					startDate: sd,
   					endDate: ed,
   					search: s
   			},
     success: function(response) {
         var labels = [];
         var data = [];
         JSON.parse(response).forEach(function(item) {
             labels.push(item.date);
             data.push(item.total);
         });
   
         // Create Pie Chart using Chart.js
         var ctx = document.getElementById('lineCharts').getContext('2d');
         var pieChart = new Chart(ctx, {
             type: 'pie',
             data: {
                 labels: labels,
                 datasets: [{
                     label: 'Bus',
                     data: data,
                     backgroundColor: [
                         'rgba(255, 99, 132, 0.2)',
                         'rgba(54, 162, 235, 0.2)',
                         'rgba(255, 206, 86, 0.2)',
                         // Add more colors as needed
                     ],
                     borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                         // Add more colors as needed
                     ],
                     borderWidth: 1,
                 }]
             },
             options: {
                 responsive: true,
             }
         });
     },
     error: function(error) {
         console.log(error);
     }
   });
   		
             });
         }
     });
   
         // Initialize Date Range Picker
         $('#date-range').daterangepicker({
             autoUpdateInput: false,
             locale: {
                 cancelLabel: 'Clear'
             }
         });
   
   		// Fetch data for line chart based on selected date range
   		$.ajax({
   				url: '<?= base_url('admin/transaction/fetch_data') ?>',
   				method: 'GET',
   				data: {},
   				success: function(response) {
   						var labels = [];
   						var data = [];
   						JSON.parse(response).forEach(function(item) {
   								labels.push(item.date);
   								data.push(item.total);
   						});
   
   						// Create Line Chart using Chart.js
   						var ctx = document.getElementById('lineChart').getContext('2d');
   						var lineChart = new Chart(ctx, {
   								type: 'line',
   								data: {
   										labels: labels,
   										datasets: [{
   												label: 'Gross Amount',
   												data: data,
   												borderColor: 'rgba(255, 99, 132, 1)',
   												backgroundColor: 'rgba(255, 99, 132, 0.2)',
   										}]
   								},
   								options: {
   										responsive: true,
   										scales: {
   												y: {
   														beginAtZero: true
   												}
   										}
   								}
   						});
   				},
   				error: function(error) {
   						console.log(error);
   				}
   		});
   
   		$.ajax({
     url: '<?= base_url('admin/transaction/fetch_datab') ?>',
     method: 'GET',
     data: {},
     success: function(response) {
         var labels = [];
         var data = [];
         JSON.parse(response).forEach(function(item) {
             labels.push(item.date);
             data.push(item.total);
         });
   
         // Create Pie Chart using Chart.js
         var ctx = document.getElementById('lineCharts').getContext('2d');
         var pieChart = new Chart(ctx, {
             type: 'pie',
             data: {
                 labels: labels,
                 datasets: [{
                     label: 'Bus',
                     data: data,
                     backgroundColor: [
                         'rgba(255, 99, 132, 0.2)',
                         'rgba(54, 162, 235, 0.2)',
                         'rgba(255, 206, 86, 0.2)',
                         // Add more colors as needed
                     ],
                     borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                         // Add more colors as needed
                     ],
                     borderWidth: 1,
                 }]
             },
             options: {
                 responsive: true,
             }
         });
     },
     error: function(error) {
         console.log(error);
     }
   });
   

         // Filter table based on selected date range
         $('#date-range').on('apply.daterangepicker', function(ev, picker) {
             var startDate = picker.startDate.format('YYYY-MM-DD');
             var endDate = picker.endDate.format('YYYY-MM-DD');
   
   				sd = startDate
   				ed = endDate
						// console.log(table)
						// .columns(4).search(startDate + ' - ' + endDate)
             table.draw();
   
             // Fetch data for line chart based on selected date range
             $.ajax({
                 url: '<?= base_url('admin/transaction/fetch_data') ?>',
                 method: 'GET',
                 data: {
                     startDate: startDate,
                     endDate: endDate,
										 search: s
                 },
                 success: function(response) {
                     var labels = [];
                     var data = [];
                     JSON.parse(response).forEach(function(item) {
                         labels.push(item.date);
                         data.push(item.total);
                     });
   
                     // Create Line Chart using Chart.js
                     var ctx = document.getElementById('lineChart').getContext('2d');
                     var lineChart = new Chart(ctx, {
                         type: 'line',
                         data: {
                             labels: labels,
                             datasets: [{
                                 label: 'Gross Amount',
                                 data: data,
                                 borderColor: 'rgba(255, 99, 132, 1)',
                                 backgroundColor: 'rgba(255, 99, 132, 0.2)',
                             }]
                         },
                         options: {
                             responsive: true,
                             scales: {
                                 y: {
                                     beginAtZero: true
                                 }
                             }
                         }
                     });
                 },
                 error: function(error) {
                     console.log(error);
                 }
             });
						 $.ajax({
     url: '<?= base_url('admin/transaction/fetch_datab') ?>',
     method: 'GET',
     data: {
                     startDate: startDate,
                     endDate: endDate,
										 search: s
                 },
     success: function(response) {
         var labels = [];
         var data = [];
         JSON.parse(response).forEach(function(item) {
             labels.push(item.date);
             data.push(item.total);
         });
   
         // Create Pie Chart using Chart.js
         var ctx = document.getElementById('lineCharts').getContext('2d');
         var pieChart = new Chart(ctx, {
             type: 'pie',
             data: {
                 labels: labels,
                 datasets: [{
                     label: 'Bus',
                     data: data,
                     backgroundColor: [
                         'rgba(255, 99, 132, 0.2)',
                         'rgba(54, 162, 235, 0.2)',
                         'rgba(255, 206, 86, 0.2)',
                         // Add more colors as needed
                     ],
                     borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                         // Add more colors as needed
                     ],
                     borderWidth: 1,
                 }]
             },
             options: {
                 responsive: true,
             }
         });
     },
     error: function(error) {
         console.log(error);
     }
   });
         });
   
   		
   
         // Clear table filter when date range is cleared
         $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
             $('#myTable').DataTable().columns(4).search('').draw();
         });
     });
</script>
<?php $this->load->view('layout-footer-dashboard') ?>
