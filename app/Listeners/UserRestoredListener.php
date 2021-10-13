<?php

namespace App\Listeners;

use App\Events\UserRestored;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {
            $user = $event->model;
            $user->removeDeleted();

            $names = ['gallery','blog','attitudes','news','comments'];

            foreach($names as $name){
                if (method_exists($user, $name)) {
                    $contentModel = $user->$name()->getRelated();
                    if (method_exists($contentModel, 'comments')) {
                        $contents = $contentModel->withTrashed()->where('user_id', $user->id)->get();
                        foreach($contents as $content){
                            $content->comments()->restore();
                            $content->attitude()->restore();

                            $id = $content->comments()->get()->modelKeys();
                            DB::table('attitudes')->where('attitudeable_type', 'App\Models\Comment')
                                ->whereIn('attitudeable_id', $id)
                                ->whereNotNull ('deleted_at')
                                ->update(['deleted_at' => null]);
                        }
                    }
                    $user->$name()->restore();
                }
            }
            DB::table('social_accounts')->where('user_id', $user->id)
                ->update(['deleted_at' => null]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            abort(520);
        }
    }
}
