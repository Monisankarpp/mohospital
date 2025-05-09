<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;


class PatientController extends Controller
{
    public function index()
    {
        $doctorId = auth()->user()->doctor->id;

        // Step 1: Get distinct patient IDs ordered by latest appointment
        $patientIds = Appointment::whereHas('slot', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
            ->orderByDesc('created_at')
            ->pluck('patient_id')
            ->unique()
            ->toArray(); // Convert to array for pagination

        // Step 2: Query users table based on those patient IDs
        $recentPatients = User::whereIn('id', $patientIds)
            ->orderByRaw("FIELD(id, " . implode(',', $patientIds) . ")") // keep order
            ->paginate(8);

        // dd($recentPatients);

        return view('doctor.patient', compact('recentPatients'));
    }


}
