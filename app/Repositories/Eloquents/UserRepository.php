<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\User';
    }
}
