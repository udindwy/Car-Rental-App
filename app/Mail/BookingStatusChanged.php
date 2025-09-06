<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Menentukan subjek email secara dinamis berdasarkan status pemesanan
        $subject = 'Status Pemesanan Anda Telah Diperbarui - #' . $this->booking->id;
        if ($this->booking->status == 'confirmed') {
            $subject = 'Pemesanan Anda Telah Dikonfirmasi - #' . $this->booking->id;
        } elseif ($this->booking->status == 'cancelled') {
            $subject = 'Pemesanan Anda Telah Dibatalkan - #' . $this->booking->id;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Menentukan file view yang akan digunakan sebagai template email
        return new Content(
            view: 'emails.booking-status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
