<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #dddddd;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #333333;
        }

        .content {
            padding: 20px 0;
        }

        .content p {
            line-height: 1.6;
            color: #555555;
        }

        .booking-details {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .booking-details th,
        .booking-details td {
            padding: 12px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        .booking-details th {
            background-color: #f8f8f8;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Status Pemesanan Anda</h1>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $booking->user->name }}</strong>,</p>
            <p>Terima kasih telah melakukan pemesanan di rental kami. Berikut adalah status terbaru untuk pemesanan Anda
                dengan ID <strong>#{{ $booking->id }}</strong>:</p>

            <table class="booking-details">
                <tr>
                    <th>Mobil</th>
                    <td>{{ $booking->vehicle->name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengambilan</th>
                    <td>{{ $booking->pickup_datetime->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengembalian</th>
                    <td>{{ $booking->dropoff_datetime->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Total Biaya</th>
                    <td><strong>Rp {{ number_format($booking->grand_total) }}</strong></td>
                </tr>
                <tr>
                    <th>Status Saat Ini</th>
                    <td>
                        <strong
                            style="color: 
                        @if ($booking->status == 'confirmed') green;
                        @elseif($booking->status == 'cancelled') red;
                        @else orange; @endif
                    ">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </strong>
                    </td>
                </tr>
            </table>

            <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
            <p>Terima kasih,<br>Tim Rental Anda</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Car Rental. Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>

</body>

</html>
