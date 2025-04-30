<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from Your Doctor</title>
    <style type="text/css">
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            color: #4a5568;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #3182ce;
            padding: 25px 30px;
            text-align: center;
        }

        .header img {
            max-height: 50px;
        }

        .content {
            padding: 30px;
        }

        h1 {
            color: #2d3748;
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 600;
        }

        p {
            margin-bottom: 20px;
            font-size: 15px;
        }

        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #3182ce;
            padding: 15px;
            margin: 25px 0;
            border-radius: 0 4px 4px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3182ce;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            margin: 15px 0;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            background-color: #f7fafc;
        }

        .signature {
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            color: #718096;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="header">
            <h1 style="color: #e2e8f0;font-size: 23px">MO - HOSPITAL</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1>New Message from Your Doctor</h1>

            <p>Dear {{ $patient->name }},</p>

            <p>You have received an important message from your healthcare provider at MoHospital.</p>

            <div class="message-box">
                <p style="margin-bottom: 0;">Please log in to your patient portal to view the full message and any
                    important updates regarding your care.</p>
            </div>

            <a href="http://mohospital.com/" class="button">View Message in Portal</a>

            <p>For your security, we don't include detailed medical information directly in this email.</p>

            <div class="signature">
                <p>Best regards,</p>
                <p><strong>The MoHospital Care Team</strong></p>
                <p>Phone: (123) 456-7890<br>
                    Email: support@mohospital.com</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2023 MoHospital. All rights reserved.</p>
            <p>123 Medical Center Drive, City, State 12345</p>
            <p>
                <a href="#" style="color: #3182ce; text-decoration: none;">Privacy Policy</a> |
                <a href="#" style="color: #3182ce; text-decoration: none;">Terms of Service</a>
            </p>
        </div>
    </div>
</body>

</html>
