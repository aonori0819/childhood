<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class FamilyPolicy
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
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Family $family)
    {
        return $user->user_detail->family_id === $family->id
                    ? Response::allow()
                    : Response::deny('このページにアクセスする権限がありません。');
    }

}
