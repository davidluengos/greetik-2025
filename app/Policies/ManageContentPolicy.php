<?php

namespace App\Policies;

use App\Models\User;

class ManageContentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    public function view(User $user, mixed $model): bool
    {
        return $user !== null;
    }

    public function create(User $user): bool
    {
        return $user !== null;
    }

    public function update(User $user, mixed $model): bool
    {
        return $user !== null;
    }

    public function delete(User $user, mixed $model): bool
    {
        return $user !== null;
    }
}
