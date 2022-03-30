<?php

namespace App\Policies;

use App\Models\Child;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class ChildPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create()
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Child $child)
    {
        return  $user->user_detail->family_id === $child->family_id
                    ? Response::allow()
                    : Response::deny('このページにアクセスする権限がありません。');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Child $child)
    {
        return $user->user_detail->family_id === $child->family_id
                    ? Response::allow()
                    : Response::deny('権限がありません。');
    }

}
