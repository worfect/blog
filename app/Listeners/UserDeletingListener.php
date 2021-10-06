<?php

namespace App\Listeners;

use App\Events\UserDeleting;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserDeletingListener
{
    /**
     * Handle the event.
     *
     * @param UserDeleting $event
     * @return void
     */
    public function handle(UserDeleting $event)
    {
        DB::beginTransaction();

        try {
            $user = $event->model;
            $user->status = USER::STATUS_DELETED;
            $user->save();

            $names = ['gallery','blog','attitudes','news','comments'];

            foreach($names as $name){
                if (method_exists($user, $name)) {
                    $contentModel = $user->$name()->getRelated();
                    if (method_exists($contentModel, 'comments')) {
                        $contents = $contentModel->where('user_id', $user->id)->get();
                        foreach($contents as $content){
                            $id = $content->comments()->get()->modelKeys();
                            DB::table('attitudes')->where('attitudeable_type', 'App\Models\Comment')
                                ->whereIn('attitudeable_id', $id)
                                ->update(['deleted_at' => Carbon::now()]);

                            $content->comments()->delete();
                            $content->attitude()->delete();
                        }
                    }
                    $user->$name()->delete();
                }
            }
            DB::table('social_accounts')->where('user_id', $user->id)
                ->update(['deleted_at' => Carbon::now()]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            abort(520);
        }

    }
}
