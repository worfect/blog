<?php

namespace App\Listeners;

use App\Events\ContentRestored;
use Illuminate\Support\Facades\DB;

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
            $id = $event->model->comments()->get()->modelKeys();
            DB::table('attitudes')->where('attitudeable_type', 'App\Models\Comment')
                                        ->whereIn('attitudeable_id', $id)
                                        ->whereNotNull ('deleted_at')
                                        ->update(['deleted_at' => null]);
        }
        if (method_exists($event->model, 'attitude')){
            $event->model->attitude()->restore();
        }
    }
}
