<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Rescheduled</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .content {
            margin-top: 20px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .content p strong {
            color: #007bff;
        }

        .content .appointment-details {
            background-color: #f1f5f8;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #6c757d;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>Appointment Rescheduled</h1>
        </div>

        <div class="content">
            <p>Hello {{ optional($appointment->patient)->name ?? 'Patient' }},</p>

            <p>We would like to inform you that your appointment has been successfully <strong>rescheduled</strong>.</p>

            <div class="appointment-details">
                <p><strong>New Date & Time:</strong>
                    {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('F j, Y \a\t h:i A') }}</p>
                <p><strong>Doctor:</strong> {{ optional($appointment->slot->doctor->user)->name ?? 'Doctor' }}</p>
            </div>

            <p>If you have any questions or need further assistance, feel free to reach out to us.</p>

            <a href="{{ url('patient/appointments') }}" class="button">View Appointment Details</a>
        </div>

        <div class="footer">
            <p>Thank you for your understanding and cooperation.</p>
            <p>If you no longer wish to receive these notifications, you can <a href="">unsubscribe</a> from our
                emails.</p>
        </div>
    </div>

</body>

</html>
