<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            // 2. Buat instance notifikasi Midtrans
            $notification = new Notification();

            // 3. Ambil data order_id dan status transaksi
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            // 4. Lakukan verifikasi signature key untuk keamanan
            $signature = hash('sha512', $orderId . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));
            if ($signature !== $notification->signature_key) {
                // Signature tidak valid, abaikan notifikasi
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // 5. Cari payment berdasarkan reference (order_id dari Midtrans)
            $payment = Payment::where('reference', $orderId)->firstOrFail();

            // 6. Handle status transaksi
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Pembayaran berhasil dan dianggap aman
                    $this->updatePaymentAndBookingStatus($payment, 'paid', 'confirmed');
                }
            } else if ($transactionStatus == 'settlement') {
                // Pembayaran berhasil diselesaikan
                $this->updatePaymentAndBookingStatus($payment, 'paid', 'confirmed');
            } else if ($transactionStatus == 'pending') {
                // Pembayaran masih menunggu
                $this->updatePaymentAndBookingStatus($payment, 'unpaid', 'pending');
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Pembayaran gagal, dibatalkan, atau kadaluarsa
                $this->updatePaymentAndBookingStatus($payment, 'failed', 'cancelled');
            }

            // 7. Beri respons OK ke Midtrans agar tidak mengirim notifikasi berulang
            return response()->json(['message' => 'Notification handled successfully']);
        } catch (\Exception $e) {
            // Tangani jika ada error
            return response()->json(['message' => 'Error handling notification: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Helper function untuk update status payment dan booking.
     */
    protected function updatePaymentAndBookingStatus(Payment $payment, string $paymentStatus, string $bookingStatus)
    {
        // Update status pembayaran
        $payment->status = $paymentStatus;
        $payment->paid_at = ($paymentStatus === 'paid') ? now() : null;
        $payment->save();

        // Update status booking terkait
        $booking = $payment->booking;
        if ($booking) {
            $booking->status = $bookingStatus;
            $booking->save();

            // TODO: Di sini Anda bisa memicu pengiriman email konfirmasi ke pelanggan
        }
    }
}
