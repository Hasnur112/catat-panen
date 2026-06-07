<?php

namespace App\Policies;

use App\Models\Panen;
use App\Models\User;

class PanenPolicy
{
    public function update(User $user, Panen $panen): bool
    {
        if ($user->isAdminOrSuper()) {
            return true;
        }
        return $user->id === $panen->user_id && $panen->status === 'Pending';
    }

    public function delete(User $user, Panen $panen): bool
    {
        if ($user->isAdminOrSuper()) {
            return true;
        }
        return $user->id === $panen->user_id && $panen->status === 'Pending';
    }
}
