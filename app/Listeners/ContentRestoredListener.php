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
        $event->model->comments()->restore();
    }
}
