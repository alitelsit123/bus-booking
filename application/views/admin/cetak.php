<!DOCTYPE html>
<html>
<head>
    <title>Bus Booking Invoice</title>
    <style>
        /* CSS styles for the invoice */
        body {
            font-family: Arial, sans-serif;
            width: 100%;
        }

        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details p {
            margin: 0;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th, .invoice-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-total {
            text-align: right;
        }

        .invoice-total p {
            margin: 0;
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, td, th{
            border: 1px solid #000;
        }
        td, th{
            padding: 5px 10px;
        }
    </style>
</head>
<body onload="window.print()">
    <h1>LAPORAN TRANSAKSI BUS</h1>
    <?php if ($cek){ ?>
    <h4>Mulai Tanggal <?= date("d-m-Y", strtotime($awal1)) ?> Sampai Tanggal <?= date("d-m-Y", strtotime($akhir1)) ?></h4>
    <?php } else { ?>
    <?php } ?>
    <table id="myTable" class="table table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>#TX</th>
                <th>Nama Bus</th>
                <th>Kota Asal</th>
                <th>Kota Tujuan</th>
                <th>Biaya</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // isi nama host, username mysql, dan password mysql anda
            $host = mysqli_connect("localhost","root","","bus_booking");
            $jumlah = 0;
            
            // isikan dengan nama database yang akan di hubungkan
            // $db = mysqli_select_db("bus_booking");
            if($cek == '1'){
                if($bus){
                    $query_mysql = mysqli_query($host, "SELECT * FROM bookings WHERE bus_id = $bus AND date BETWEEN '$awal1' and '$akhir1'")or die(mysqli_error());
                }else{
                    $query_mysql = mysqli_query($host, "SELECT * FROM bookings WHERE date BETWEEN '$awal1' and '$akhir1'")or die(mysqli_error());
                }
            }else{
                if($bus){
                    $query_mysql = mysqli_query($host, "SELECT * FROM bookings WHERE bus_id = $bus")or die(mysqli_error());
                }else{
                    $query_mysql = mysqli_query($host, "SELECT * FROM bookings")or die(mysqli_error());
                }
            }
            $nomor = 1;
            while($dt = mysqli_fetch_array($query_mysql)){
                ?>
                  <tr>
                    <td><?= $nomor++ ?></td>
                     <td><?= $dt['code'] ?></td>
                     <td><?= $this->Bus_model->find($dt['bus_id'])->name ?? '' ?></td>
                     <td><?= $dt['city_from'] ?></td>
                     <td><?= $dt['city_to'] ?></td>
                     <td>Rp. <?= number_format($dt['gross_amount'],0,'','.') ?></td>
                     <td><?= date("d-m-Y", strtotime($dt['payment_date'])) ?></td>
                  </tr>
                <?php
                $jumlah = $jumlah + $dt['gross_amount'];
                }
                ?>
                <tr>
                    <td colspan="5">Total</td>
                    <td colspan="2">Rp. <?= number_format($jumlah,0,'','.') ?></td>
                </tr>
        </tbody>
    </table>
    
</body>
</html>
