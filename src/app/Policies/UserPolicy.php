<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //family_id設定済の場合
        if (isset($user->user_detail->family))
        {
            return  $user->user_detail->family_id === $model->user_detail->family_id
                        ? Response::allow()
                        : Response::deny('このページにアクセスする権限がありません。');

        } else {
        //family_id未設定の場合

            return $user->id === $model->id
                        ? Response::allow()
                        : Response::deny('このページにアクセスする権限がありません。');
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create()
    {
        return  true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        //family_id設定済の場合
        if (isset($user->user_detail->family))
        {
            return  $user->user_detail->family_id === $model->user_detail->family_id
                        ? Response::allow()
                        : Response::deny('このページにアクセスする権限がありません。');

        } else {
        //family_id未設定の場合

            return $user->id === $model->id
                        ? Response::allow()
                        : Response::deny('このページにアクセスする権限がありません。');
        }

    }

}
