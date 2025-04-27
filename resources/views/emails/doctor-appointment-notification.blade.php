@component('mail::message')
    # New Appointment Booking

    You have a new appointment with {{ $appointment->patient->name }}.

    **Appointment Details:**
    **Date:** {{ $appointment->appointment_date->format('F j, Y') }}
    **Time:** {{ $appointment->appointment_time }}
    **Notes:** {{ $appointment->notes ?? 'None' }}

    **Payment Details:**
    **Amount Received:** ${{ number_format($appointment->fee, 2) }}
    **Payment Status:** Received

    @component('mail::button', ['url' => route('doctor.appointments.show', $appointment)])
        View Appointment
    @endcomponent

    Regards,
    {{ config('app.name') }}
@endcomponent
