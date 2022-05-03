<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

final class Registered
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     */
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
