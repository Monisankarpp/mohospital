<?php

namespace App\Policies;

use App\Models\Slot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlotPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('doctor');
    }

    public function view(User $user, Slot $slot)
    {
        return $user->hasRole('doctor') && $slot->doctor_id === $user->doctor->id;
    }

    public function create(User $user)
    {
        return $user->hasRole('doctor');
    }

    public function update(User $user, Slot $slot)
    {
        return $user->hasRole('doctor') &&
            $slot->doctor_id === $user->doctor->id;
    }

    public function delete(User $user, Slot $slot)
    {
        return $user->hasRole('doctor') &&
            $slot->doctor_id === $user->doctor->id;
    }
}