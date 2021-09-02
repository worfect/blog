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
        if (method_exists($event->model, 'comments')){
            $event->model->comments()->delete();
        }
        if (method_exists($event->model, 'attitude')){
            $event->model->attitude()->delete();
        }
    }
}
