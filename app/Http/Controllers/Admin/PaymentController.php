<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Menampilkan log semua transaksi pembayaran.
     */
    public function index()
    {
        $payments = Payment::with('booking.user')->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }
}
