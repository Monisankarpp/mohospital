<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class PatientController extends Controller
{
    public function index()
    {
        $doctorId = auth()->user()->doctor->id;

        $recentPatients = Appointment::with('patient')
            ->whereHas('slot', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->orderByDesc('created_at')
            ->distinct('patient_id')
            ->paginate(8);

        return view('doctor.patient', compact('recentPatients'));
    }


}
