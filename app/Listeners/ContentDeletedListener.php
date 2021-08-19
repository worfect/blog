<?php

namespace App\Listeners;

use App\Events\ContentDeleted;

class ContentDeletedListener
{
    /**
     * Handle the event.
     *
     * @param ContentDeleted $event
     * @return void
     */
    public function handle(ContentDeleted $event)
    {
        $event->model->comments()->delete();
    }
}
