<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\Doctor;
use App\Http\Requests\StorePrescriptionRequest;
use Illuminate\Support\Str;
use App\Notifications\PrescriptionUploaded;
use Mews\Purifier\Facades\Purifier;




class PrescriptionController extends Controller
{
	public function index()
	{
		$patients = User::where('role', 'Patient')->get();

		return view('doctor.prescription-upload', compact('patients'));
	}



	public function store(Request $request)
	{
		// Validate input
		$validated = $request->validate([
			'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
			'patient_id' => 'required|exists:users,id',
			'notes' => 'required|string',
			'medications' => 'nullable|string',
		]);
		$medications = json_decode($validated['medications'], true) ?? [];


		// Find doctor from authenticated user
		$doctor = Doctor::where('user_id', auth()->id())->first();
		if (!$doctor) {
			return redirect()->back()->with('error', 'Doctor record not found.');
		}

		// Handle file upload
		if (!$request->hasFile('file')) {
			return redirect()->back()->with('error', 'Please select a file to upload.');
		}

		$file = $request->file('file');
		$filename = 'prescription_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
		$fileUrl = $file->storeAs('prescriptions', $filename, 'public');

		// Store medications JSON inside notes column
		$medications = $validated['medications'] ?? [];
		$encodedNotes = json_encode($medications);

		// Create prescription
		$prescription = Prescription::create([
			'doctor_id' => $doctor->id,
			'patient_id' => $validated['patient_id'],
			'notes' => $encodedNotes,
			'file_url' => $fileUrl,
		]);

		// Notify patient
		Notification::create([
			'user_id' => $validated['patient_id'],
			'title' => 'New Prescription Uploaded',
			'message' => 'Your doctor has uploaded a new prescription.',
			'is_read' => false,
			'created_at' => now(),
			'updated_at' => now(),
		]);

		return redirect()->route('doctor.dashboard')->with('success', 'Prescription uploaded and patient notified.');
	}


}