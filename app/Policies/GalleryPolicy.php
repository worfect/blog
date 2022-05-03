<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class GalleryPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  string  $ability
     * @return bool|void
     */
    public function before(User $user, $ability)
    {
        return $user->isAdministrator() ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     *
     */
    public function viewAny(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     */
    public function view(User $user, Gallery $gallery): void
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     */
    public function create(User $user)
    {
        return $user->isActive();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     */
    public function restore(User $user, Gallery $gallery)
    {
        return $user->id === $gallery->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     */
    public function forceDelete(User $user, Gallery $gallery): void
    {
        //
    }
}
