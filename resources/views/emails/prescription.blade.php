<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Prescription Mail</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 30px; color: #333;">
    <table
        style="width: 100%; max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <tr>
            <td style="background-color: #007bff; color: white; text-align: center; padding: 20px 30px;">
                <h2 style="margin: 0;">Thank You for Visiting</h2>
                <p style="margin: 0;">Prescription from Dr. {{ $appointment->slot->doctor->user->name }}</p>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px;">
                <p>Dear {{ $appointment->patient->name }},</p>

                <p>Thank you for consulting with us on
                    {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('F j, Y') }} at
                    {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}.</p>

                <p>Your prescription has been prepared and is attached to this email.</p>

                <p><strong>Doctor:</strong> Dr. {{ $appointment->slot->doctor->user->name }}<br>
                    <strong>Appointment ID:</strong> #MOH-25-{{ $appointment->id }}<br>
                    <strong>Status:</strong> {{ ucfirst($appointment->status) }}
                </p>

                <p>If you have any further questions or need a follow-up, feel free to reach out through our portal or
                    support team.</p>

                <p style="margin: 30px 0;">
                    <a href="{{ $pdfUrl ?? '#' }}"
                        style="background-color: #28a745; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                        Download Prescription
                    </a>
                </p>

                <p>Wishing you a speedy recovery!</p>

                <p style="margin-top: 40px;">Regards,<br><strong>Dr.
                        {{ $appointment->slot->doctor->user->name }}</strong><br></p>
            </td>
        </tr>

        <tr>
            <td style="background-color: #f1f1f1; text-align: center; padding: 20px; font-size: 12px; color: #777;">
                © {{ now()->year }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>

</html>
