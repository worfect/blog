<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ContentRestored;
use Illuminate\Support\Facades\DB;

final class ContentRestoredListener
{
    public function handle(ContentRestored $event): void
    {
        if (method_exists($event->model, 'comments')) {
            $event->model->comments()->restore();
            $id = $event->model->comments()->get()->modelKeys();
            DB::table('attitudes')->where('attitudeable_type', 'App\Models\Comment')
                                        ->whereIn('attitudeable_id', $id)
                                        ->whereNotNull('deleted_at')
                                        ->update(['deleted_at' => null]);
        }
        if (method_exists($event->model, 'attitude')) {
            $event->model->attitude()->restore();
        }
    }
}
