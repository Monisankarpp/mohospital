<p>Dear Dr. {{ $appointment->slot->doctor->user->name }},</p>

<p>Your patient <strong>{{ $appointment->patient->name }}</strong> has rescheduled their appointment.</p>

<p>
    <strong>New Date:</strong> {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('F j, Y') }}<br>
    <strong>New Time:</strong> {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }} -
    {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
</p>

<p>Thank you,<br>{{ config('app.name') }}</p>
