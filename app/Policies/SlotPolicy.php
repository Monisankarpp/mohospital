<?php
namespace App\Policies;

use App\Models\Slot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlotPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Slot $slot)
    {
        return $user->id === $slot->doctor->user_id;
    }

    public function delete(User $user, Slot $slot)
    {
        return $user->id === $slot->doctor->user_id;
    }
}