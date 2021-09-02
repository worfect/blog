<?php

namespace App\Listeners;

use App\Events\ContentRestored;

class ContentRestoredListener
{
    /**
     * Handle the event.
     *
     * @param ContentRestored $event
     * @return void
     */
    public function handle(ContentRestored $event)
    {
        if (method_exists($event->model, 'comments')){
            $event->model->comments()->restore();
        }
        if (method_exists($event->model, 'attitude')){
            $event->model->attitude()->restore();
        }
    }
}
