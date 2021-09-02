<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class ContentRestored
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var Model
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
