<?php

namespace App\Policies;

use App\Models\Panen;
use App\Models\User;

class PanenPolicy
{
    public function update(User $user, Panen $panen): bool
    {
        return $user->isAdmin() || $user->id === $panen->user_id;
    }

    public function delete(User $user, Panen $panen): bool
    {
        return $user->isAdmin() || $user->id === $panen->user_id;
    }
}
