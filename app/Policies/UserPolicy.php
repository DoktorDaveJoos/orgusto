<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $this->allowIfUserIsResponsibleForModel($user, $model);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $this->allowIfUserIsResponsibleForModel($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $this->allowIfUserIsResponsibleForModel($user, $model);
    }

    /**
     * Checks if the authorized user is responsible for the {@code User} model which
     * an operation is requested for.
     *
     * @param User $user - the authorized user
     * @param User $model - the model to operate on
     * @return Response - allows if responsible else deny
     */
    private function allowIfUserIsResponsibleForModel(User $user, User $model)
    {
        if ($user !== 'registered') return Response::deny();

        if ($model->type === 'anonymous') {
            return $user->firstRestaurant()->id === $model->firstRestaurant()->id
                ? Response::allow()
                : Response::deny();
        } else {
            return $user->id === $model->id
                ? Response::allow()
                : Response::deny();
        }
    }

}
