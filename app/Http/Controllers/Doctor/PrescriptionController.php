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




class PrescriptionController extends Controller
{
	public function index()
	{
		$patients = User::where('role', 'Patient')->get();

		return view('doctor.prescription-upload', compact('patients'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
			'notes' => 'required|string|max:1000',
			'patient_id' => 'required|exists:users,id',
		]);

		$user = auth()->user();

		$doctor = Doctor::where('user_id', $user->id)->first();

		if (!$doctor) {
			return redirect()->back()->with('error', 'Doctor record not found for this user.');
		}

		$file = $request->file('file');
		if (!$file) {
			return redirect()->back()->with(['error', 'File upload failed. Please select a file.']);
		}

		$filename = 'prescription_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
		$fileUrl = $file->storeAs('prescriptions', $filename, 'public');

		$prescription = Prescription::create([
			'doctor_id' => $doctor->id,
			'patient_id' => $validated['patient_id'],
			'notes' => strip_tags($validated['notes']),
			'file_url' => $fileUrl,
		]);

		Notification::create([
			'user_id' => $validated['patient_id'],
			'title' => 'New Prescription Uploaded',
			'message' => 'A new prescription has been uploaded by your doctor. Click to view/download.',
			'is_read' => false,
		]);

		return redirect('doctor/dashboard')->with('success', 'Prescription uploaded and patient notified.');
	}

}