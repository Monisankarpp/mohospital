<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionWithThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.prescription', ['appointment' => $this->appointment]);

        return $this->subject('Thank You - Your Prescription')
            ->markdown('emails.prescription')
            ->attachData($pdf->output(), 'prescription.pdf');
    }
}
