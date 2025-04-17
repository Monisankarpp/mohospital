<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generatePDF($id)
    {
        $prescription = Prescription::with(['doctor', 'patient'])->findOrFail($id);

        $medications = [];
        if ($prescription->medications) {
            $decoded = json_decode($prescription->medications, true);
            if (is_array($decoded)) {
                $medications = $decoded;
            }
        }

        $data = [
            'prescription' => $prescription,
            'medications' => $medications,
            'date' => now()->format('m/d/Y'),
            'invoice_no' => 'INV-' . str_pad($prescription->id, 6, '0', STR_PAD_LEFT)
        ];
        $pdf = PDF::loadView('pdf.invoice', $data);

        return $pdf->download('invoice-' . $prescription->id . '.pdf');
    }

    public function view($id)
    {
        $prescription = Prescription::with(['doctor', 'patient'])->findOrFail($id);

        $medications = [];
        if ($prescription->medications) {
            $decoded = json_decode($prescription->medications, true);
            if (is_array($decoded)) {
                $medications = $decoded;
            }
        }

        $data = [
            'prescription' => $prescription,
            'medications' => $medications,
            'date' => now(),
            'invoice_no' => 'INV-' . str_pad($prescription->id, 6, '0', STR_PAD_LEFT)
        ];

        return view('pdf.invoice', $data);
    }


}
