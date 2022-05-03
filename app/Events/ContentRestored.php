<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

final class ContentRestored
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     */
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
