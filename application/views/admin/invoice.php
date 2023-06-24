<!DOCTYPE html>
<html>
<head>
    <title>Bus Booking Invoice</title>
    <style>
        /* CSS styles for the invoice */
        body {
            font-family: Arial, sans-serif;
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
    </style>
</head>
<body>
    <div class="invoice" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%)">
        <div class="invoice-header">
            <h1>Invoice</h1>
        </div>
        <div class="invoice-details">
            <p><strong>No Invoice:</strong> #<?= $book->code ?></p>
            <p><strong>Tanggal:</strong> <?= (new DateTime($book->payment_date))->format('d, F Y H:i') ?></p>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Nama Bus</th>
                    <th>Jumlah Hari</th>
                    <th>Biaya per hari</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $this->Bus_model->find($book->bus_id)->name ?></td>
                    <?php  
										$startDate = new DateTime($book->start_book);
										$endDate = new DateTime($book->end_book);
										?>
										<td><?= $startDate->diff($endDate)->days ?> Hari</td>
                    <td>Rp. <?= number_format($this->Bus_model->find($book->bus_id)->price_daily) ?></td>
                    <td><?= $this->Users->find($book->user_id)->address ?></td>
                </tr>
            </tbody>
        </table>
        <div class="invoice-total">
						<p style="margin-bottom:0.5rem;"><strong>Tanggal Sewa:</strong> <?= $book->start_book ?></p>
						<p style="margin-bottom:1rem;"><strong>Tanggal Dikembalikan:</strong> <?= $book->end_book ?></p>
            <p><strong>Total Bayar:</strong> <?= number_format($book->gross_amount) ?></p>
        </div>
    </div>
</body>
</html>
