<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class UserRestored
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var User
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
