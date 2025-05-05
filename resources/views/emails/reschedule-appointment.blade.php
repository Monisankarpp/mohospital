@component('mail::message')
    # Appointment Cancelled

    Dear {{ $appointment->patient->name }},

    Your appointment with **Dr. {{ $appointment->slot->doctor->user->name }}** on
    **{{ $appointment->slot->start_time->format('l, F j, Y') }} at {{ $appointment->slot->start_time->format('h:i A') }}**
    has been **cancelled** due to unavailability.

    We apologize for the inconvenience.

    @component('mail::button', ['url' => route('patient.appointments.reschedule')])
        Reschedule Now
    @endcomponent

    Thank you,
    {{ config('app.name') }} Team
@endcomponent
