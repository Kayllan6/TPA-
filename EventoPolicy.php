<?php

namespace App\Policies;

use App\Models\Evento;
use App\Models\User;

class EventoPolicy
{
    public function moderate(User $user, Evento $evento): bool
    {
        return (int) $evento->user_id === (int) $user->id;
    }
}
