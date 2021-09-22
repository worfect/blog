<?php

namespace App\Listeners;

use App\Events\ContentDeleted;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            $id = $event->model->comments()->get()->modelKeys();
            DB::table('attitudes')->where('attitudeable_type', 'App\Models\Comment')
                                        ->whereIn('attitudeable_id', $id)
                                        ->update(['deleted_at' => Carbon::now()]);

            $event->model->comments()->delete();
        }
        if (method_exists($event->model, 'attitude')){
            $event->model->attitude()->delete();
        }
    }
}
