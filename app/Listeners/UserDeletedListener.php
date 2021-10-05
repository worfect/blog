<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use App\Models\User;

class UserDeletedListener
{
    /**
     * Handle the event.
     *
     * @param UserDeleted $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        $event->model->status = USER::STATUS_DELETED;
        $event->model->save();
    }
}
