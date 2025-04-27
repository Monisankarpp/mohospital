@component('mail::message')
    # Appointment Confirmation

    Thank you for booking your appointment with Dr. {{ $appointment->doctor->name }}.

    **Appointment Details:**
    **Date:** {{ $appointment->appointment_date->format('F j, Y') }}
    **Time:** {{ $appointment->appointment_time }}
    **Notes:** {{ $appointment->notes ?? 'None' }}

    **Payment Details:**
    **Amount Paid:** ${{ number_format($appointment->fee, 2) }}
    **Payment Status:** Paid

    You can view or manage your appointment by logging into your account.

    @component('mail::button', ['url' => route('appointments.show', $appointment)])
        View Appointment
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
