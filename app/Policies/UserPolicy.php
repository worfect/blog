<?php


namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        return $user->isAdministrator() ? true : null;
    }

    /**
     * Determine whether the user can update user information
     *
     * @param User $user
     * @param int $id
     * @return bool
     */
    public function update(User $user, int $id): bool
    {
        return $user->id === $id;
    }

}
