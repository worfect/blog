<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @return bool
     */
    public function before(User $user)
    {
        return $user->isAdministrator() ? true : null;
    }

    /**
     * Determine whether the user can update user information
     *
     */
    public function update(User $user, int $id): bool
    {
        return $user->id === $id;
    }
}
