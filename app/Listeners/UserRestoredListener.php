<?php

namespace App\Listeners;

use App\Events\UserRestored;
use App\Models\User;

class UserRestoredListener
{
    /**
     * Handle the event.
     *
     * @param UserRestored $event
     * @return void
     */
    public function handle(UserRestored $event)
    {
        $event->model->status = USER::STATUS_WAIT;
        $event->model->save();
    }
}
