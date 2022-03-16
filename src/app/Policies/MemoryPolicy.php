<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Memory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class MemoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny()
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Memory $memory)
    {
        //family_id設定済の場合
        if ($user->user_detail->family)
        {
            return $user->user_detail->family->id === $memory->family_id
                        ? Response::allow()
                        : Response::deny('このページにアクセスする権限がありません。');

        } else {
        //family_id未設定の場合

            return $user->id === $memory->user_id
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Memory $memory)
    {
        return $user->id === $memory->user_id
                    ? Response::allow()
                    : Response::deny('このページにアクセスする権限がありません。');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Memory $memory)
    {
        return $user->id === $memory->user_id
                    ? Response::allow()
                    : Response::deny('権限がありません。');
    }

}
