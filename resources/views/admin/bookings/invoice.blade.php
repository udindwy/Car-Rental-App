<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $booking->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Arial', sans-serif;
            color: #333;
            font-size: 13px;
            background: #f9f9f9;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #0d6efd;
            letter-spacing: 2px;
        }

        .header p {
            margin: 3px 0;
            color: #555;
            font-size: 13px;
        }

        .invoice-details {
            margin: 20px 0;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details td {
            padding: 6px;
            vertical-align: top;
            font-size: 13px;
        }

        .items-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }

        .items-table th {
            background-color: #f1f3f5;
            font-weight: 600;
            color: #444;
        }

        .total-section {
            margin-top: 25px;
            text-align: right;
        }

        .total-section table {
            width: 40%;
            float: right;
            border-collapse: collapse;
        }

        .total-section th,
        .total-section td {
            padding: 10px;
            font-size: 14px;
        }

        .total-section th {
            text-align: left;
        }

        .total-section strong {
            font-size: 16px;
            color: #0d6efd;
        }

        .footer {
            clear: both;
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>INVOICE</h1>
            <p><strong>Nama Rental Anda</strong></p>
            <p>Alamat Rental Anda, Kota, Kode Pos</p>
            <p>Telp: (021) 123-4567 | Email: kontak@rentalanda.com</p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <table>
                <tr>
                    <td>
                        <strong>Ditagihkan Kepada:</strong><br>
                        {{ $booking->user->name }}<br>
                        {{ $booking->user->email }}
                    </td>
                    <td style="text-align: right;">
                        <strong>Invoice #:</strong> {{ $booking->id }}<br>
                        <strong>Tanggal Dibuat:</strong> {{ $booking->created_at->format('d M Y') }}<br>
                        <strong>Status:</strong> {{ ucfirst($booking->status) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Tanggal Sewa</th>
                    <th>Durasi</th>
                    <th>Harga per Hari</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Sewa {{ $booking->vehicle->name }}</strong><br>
                        <small>{{ $booking->vehicle->brand->name }}</small>
                    </td>
                    <td>{{ $booking->pickup_datetime->format('d M Y') }} -
                        {{ $booking->dropoff_datetime->format('d M Y') }}</td>
                    <td>{{ $booking->duration_days }} hari</td>
                    <td>Rp {{ number_format($booking->vehicle->base_price_day) }}</td>
                    <td>Rp {{ number_format($booking->subtotal) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="total-section">
            <table>
                <tr>
                    <th>Subtotal:</th>
                    <td>Rp {{ number_format($booking->subtotal) }}</td>
                </tr>
                <tr>
                    <th><strong>Grand Total:</strong></th>
                    <td><strong>Rp {{ number_format($booking->grand_total) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menggunakan jasa kami.</p>
        </div>
    </div>
</body>

</html>
