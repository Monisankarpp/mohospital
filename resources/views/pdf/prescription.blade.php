<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Prescription</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 30px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .header h2 {
            margin: 0;
            color: #007BFF;
        }

        .subheader {
            font-size: 14px;
            margin-top: 4px;
        }

        .line {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .info-table,
        .meds-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td,
        .meds-table td,
        .meds-table th {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .meds-table th {
            background-color: #f8f8f8;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .thank-you {
            margin-top: 30px;
            font-style: italic;
            text-align: center;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>{{ $appointment->slot->doctor->user->name }}</h2>
        <div class="subheader">Specialist in General Medicine</div>
        <div class="subheader">Phone: +91-XXXXXXX | Email: doctor@example.com</div>
    </div>

    <div class="line"></div>

    <div class="section-title">Patient Details</div>
    <table class="info-table">
        <tr>
            <td><strong>Name:</strong> {{ $appointment->patient->name }}</td>
            <td><strong>Appointment ID:</strong> #{{ $appointment->id }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('M j, Y') }}
            </td>
            <td><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}</td>
        </tr>
    </table>

    <div class="section-title">Diagnosis</div>
    <p>Patient presents with symptoms of [your diagnosis here]. Based on clinical evaluation, the diagnosis is [insert
        diagnosis].</p>

    <div class="section-title">Prescribed Medicines</div>
    <table class="meds-table">
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Dosage</th>
                <th>Frequency</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Paracetamol 500mg</td>
                <td>1 tablet</td>
                <td>Twice a day</td>
                <td>5 days</td>
            </tr>
            <tr>
                <td>Amoxicillin 250mg</td>
                <td>1 capsule</td>
                <td>Thrice a day</td>
                <td>7 days</td>
            </tr>
            <!-- You can dynamically loop medicines if stored in DB -->
        </tbody>
    </table>

    <div class="section-title">Doctor's Advice</div>
    <p>Stay hydrated, take plenty of rest, and avoid cold beverages. Please return for a follow-up in one week or
        earlier if symptoms worsen.</p>

    <div class="signature">
        <strong>{{ $appointment->slot->doctor->user->name }}</strong><br>
        <span>Doctor's Signature</span>
    </div>

    <div class="thank-you">
        Thank you for visiting. Wishing you a speedy recovery!
    </div>

</body>

</html>
