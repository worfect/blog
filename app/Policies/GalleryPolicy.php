<?php

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        return $user->isAdministrator() ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
            //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Gallery $gallery
     * @return mixed
     */
    public function view(User $user, Gallery $gallery)
    {
            //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isVerified();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Gallery $gallery
     * @return mixed
     */
    public function update(User $user, Gallery $gallery): bool
    {
        return $user->id == $gallery->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->id == $gallery->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function restore(User $user, Gallery $gallery)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function forceDelete(User $user, Gallery $gallery)
    {
        //
    }
}
