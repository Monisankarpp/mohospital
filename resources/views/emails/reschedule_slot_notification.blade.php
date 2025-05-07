<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Appointment Cancellation</title>
</head>

<body
    style="margin:0; padding:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fbfc; color: #333333;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05); padding: 30px;">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <img src="https://via.placeholder.com/120x40?text=MoHospital" alt="MoHospital Logo"
                    style="height: 40px;">
            </td>
        </tr>

        <tr>
            <td>
                <h2 style="color: #2a3f54;">Hello {{ $patient->name }},</h2>

                <p style="font-size: 16px; line-height: 1.6;">
                    We regret to inform you that your upcoming appointment has been <strong
                        style="color: #e74c3c;">cancelled</strong> by your doctor due to unforeseen circumstances.
                </p>

                <div
                    style="background-color: #f4f8fb; border-left: 4px solid #3498db; padding: 15px; border-radius: 6px; margin: 20px 0;">
                    <p style="margin: 0;"><strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('l, d M Y') }}</p>
                    <p style="margin: 0;"><strong>Time:</strong>
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} –
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</p>
                </div>

                <p style="font-size: 16px; line-height: 1.6;">
                    We sincerely apologize for the inconvenience this may cause. Your health and time are our top
                    priority.
                </p>

                <p style="font-size: 16px;">
                    You can easily <a href="{{ url('patient/dashboard') }}"
                        style="color: #3498db; text-decoration: underline;">reschedule your appointment here</a>.
                </p>

                <p style="font-size: 16px;">
                    Need help? Our support team is happy to assist you at <a href="mailto:support@mohospital.com"
                        style="color: #3498db;">support@mohospital.com</a> or call <strong>+1 (800) 123-4567</strong>.
                </p>

                <p style="font-size: 16px;">
                    Thank you for your understanding.
                </p>

                <p style="font-size: 16px; color: #2a3f54;">
                    Warm regards,<br>
                    <strong>The MoHospital Care Team</strong>
                </p>
            </td>
        </tr>

        <tr>
            <td style="padding-top: 30px;">
                <hr style="border: none; border-top: 1px solid #eaeaea;">
                <p style="font-size: 12px; color: #888888; text-align: center; margin-top: 10px;">
                    This is an automated message. Please do not reply directly.
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
