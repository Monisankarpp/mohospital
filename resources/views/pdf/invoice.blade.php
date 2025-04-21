<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prescription Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">


    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        :root {
            --primary: #4f81c7;
            --secondary: #63b3ed;
            --accent: #68d391;
            --light: #f7fafc;
            --dark: #2d3748;
            --text: #4a5568;
            --border: #e2e8f0;
        }

        html,
        body {
            background: white;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            color: var(--text);
            font-size: 14px;
            line-height: 1.5;
        }

        .prescription-card {
            max-width: 100%;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 1.5rem;
        }

        .prescription-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .prescription-title {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .prescription-subtitle {
            font-size: 0.9rem;
        }

        .watermark {
            position: absolute;
            opacity: 0.07;
            font-size: 120px;
            font-weight: bold;
            color: white;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            z-index: 0;
            pointer-events: none;
        }

        .info-card {
            background-color: var(--light);
            border-left: 4px solid var(--primary);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .info-card.patient {
            border-left-color: var(--accent);
        }

        .info-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .prescription-content {
            background: #f8fafc;
            border: 1px solid var(--border);
            padding: 1rem;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            margin-bottom: 1.5rem;
        }

        .medication-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        .medication-table th,
        .medication-table td {
            padding: 0.6rem;
            border: 1px solid var(--border);
        }

        .medication-table th {
            background-color: var(--primary);
            color: white;
            font-size: 0.85rem;
        }

        .medication-table td {
            font-size: 0.85rem;
        }

        .signature-area {
            margin-top: 2rem;
            text-align: right;
        }

        .signature-line {
            border-top: 1px solid var(--dark);
            width: 180px;
            margin-top: 1.5rem;
        }

        .footer {
            text-align: center;
            font-size: 0.75rem;
            margin-top: 2rem;
            color: var(--text);
            opacity: 0.6;
        }

        @media print {
            .container {
                padding: 0;
            }

            .prescription-card {
                box-shadow: none;
                page-break-after: avoid;
            }

            .footer {
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="prescription-card">
            <div class="prescription-header" style="background-color: #4f81c7; color: white;">
                <div class="watermark">Rx</div>
                <h1 class="prescription-title"> Mo-Hospital Prescription</h1>
                <p class="prescription-subtitle">Invoice #{{ $invoice_no }} • {{ $date }}</p>
            </div>

            <div class="prescription-body mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-card">
                            <h3 class="info-title"><i class="bi bi-person-heart me-2"></i>Patient Information</h3>
                            <p><strong>{{ $prescription->patient->name }}</strong></p>
                            <p>ID: PT{{ $prescription->patient->id . rand(911, 9999) }}</p>
                            <p>DOB: {{ $prescription->patient->dob ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card patient">
                            <h3 class="info-title"><i class="bi bi-heart-pulse me-2"></i>Prescribing Physician</h3>
                            <p><strong>Dr. {{ $prescription->doctor->user->name }}</strong></p>
                            <p>{{ $prescription->doctor->specialization }}</p>
                            <p>License #: RMD-{{ rand(91111, 999999) }}</p>
                        </div>
                    </div>
                </div>

                <h4 class="mt-3 mb-2" style="color: var(--primary);">
                    <i class="bi bi-prescription2 me-2"></i>Treatment Plan
                </h4>
                @php
                    $rawNotes = stripslashes($prescription->notes);
                    $rawNotes = trim($rawNotes, "\"");
                    $maybeString = json_decode($rawNotes, true);

                    if (is_string($maybeString)) {
                        $medications = json_decode($maybeString, true);
                    } else {
                        $medications = $maybeString;
                    }
                    if (json_last_error() !== JSON_ERROR_NONE || !is_array($medications)) {
                        echo "<div class='alert alert-danger'>JSON Decode Error: " . json_last_error_msg() . '</div>';
                        $medications = null;
                    }
                @endphp


                @if (is_array($medications) && count($medications))
                    <div class="card mt-4 border-0" style="box-shadow: 0 0 15px rgba(0,0,0,0.05);">
                        <div class="card-header py-3"
                            style="background-color: #5d87ff; color: white; border-bottom: 0;">
                            <div class="d-flex align-items-center">
                                <div
                                    style="background-color: rgba(255,255,255,0.2); width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-right: 12px;">
                                    <i class="fas fa-pills fs-5" style="color: white;"></i>
                                </div>
                                <h5 class="mb-0" style="font-weight: 600; font-size: 1.1rem;">PRESCRIBED MEDICATIONS
                                </h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0" style="width: 100%;">
                                    <thead style="background-color: #f5f9ff;">
                                        <tr>
                                            <th class="py-3 ps-4"
                                                style="font-weight: 600; color: #5d87ff; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Medication</th>
                                            <th class="py-3"
                                                style="font-weight: 600; color: #5d87ff; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Dosage</th>
                                            <th class="py-3"
                                                style="font-weight: 600; color: #5d87ff; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Frequency</th>
                                            <th class="py-3 pe-4"
                                                style="font-weight: 600; color: #5d87ff; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">
                                                Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medications as $med)
                                            <tr style="border-top: 1px solid #f0f0f0;">
                                                <td class="ps-4" style="padding-top: 16px; padding-bottom: 16px;">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            style="background-color: #ebf3ff; color: #5d87ff; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-right: 12px;">
                                                            <i class="fas fa-capsules" style="font-size: 0.8rem;"></i>
                                                        </div>
                                                        <div>
                                                            <div style="font-weight: 600; color: #2a3547;">
                                                                {{ $med['name'] ?? 'N/A' }}</div>
                                                            @if (isset($med['composition']))
                                                                <div
                                                                    style="color: #878787; font-size: 0.75rem; margin-top: 2px;">
                                                                    {{ $med['composition'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        style="display: inline-flex; align-items: center; background-color: #e8fdeb; color: #49be25; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 500;">
                                                        {{ $med['dosage'] ?? '—' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        style="display: inline-flex; align-items: center; background-color: #fff8e6; color: #ffae1f; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 500;">
                                                        {{ $med['frequency'] ?? '—' }}
                                                    </span>
                                                </td>
                                                <td class="pe-4" style="text-align: right;">
                                                    <span
                                                        style="display: inline-flex; align-items: center; background-color: #e6f3ff; color: #5d87ff; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 500;">
                                                        {{ $med['duration'] ?? '0' }} days
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer"
                            style="background-color: #f5f9ff; border-top: 1px solid #f0f0f0; padding: 12px 20px;">
                            <div style="color: #5d87ff; font-size: 0.8rem; display: flex; align-items: center;">
                                <i class="fas fa-info-circle me-2" style="font-size: 0.9rem;"></i>
                                Please take medications as directed by your healthcare provider
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert mt-4 border"
                        style="box-shadow: 0 0 15px rgba(0,0,0,0.05); border-radius: 8px; border-color: #e0e0e0; display: flex; align-items: center; padding: 16px; background-color: white;">
                        <div
                            style="background-color: #ebf3ff; color: #5d87ff; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-right: 14px;">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div>
                            <h6 style="font-weight: 600; color: #5d87ff; margin-bottom: 4px; font-size: 0.9rem;">No
                                Medications Prescribed</h6>
                            <p style="color: #878787; margin-bottom: 0; font-size: 0.8rem;">No medication details
                                available in prescription notes.</p>
                        </div>
                    </div>
                @endif


                <div class="signature-area">
                    <p class="mt-2">
                        <strong>Dr. {{ $prescription->doctor->user->name }}</strong><br>
                        {{ $prescription->doctor->specialization }}
                    </p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Generated by MoHospital EMR System • {{ now()->format('F j, Y') }}</p>
            <p>This is an electronically generated document and does not require a physical signature.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
