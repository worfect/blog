<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

final class UserRestored
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     */
    public User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
