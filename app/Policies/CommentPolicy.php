<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class CommentPolicy
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
    public function view(User $user, Comment $comment): void
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
     */
    public function update(User $user, Comment $comment): void
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     */
    public function delete(User $user, Comment $comment): void
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     */
    public function restore(User $user, Comment $comment): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     */
    public function forceDelete(User $user, Comment $comment): void
    {
        //
    }
}
