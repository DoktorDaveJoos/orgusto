<?php

namespace App\Policies;

use App\User;
use App\Table;
use Illuminate\Auth\Access\HandlesAuthorization;

class TablePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any restaurants.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the restaurant.
     *
     * @param  \App\User  $user
     * @param  \App\Restaurant  $restaurant
     * @return mixed
     */
    public function view(User $user, Table $table)
    {
        $tables = $user->restaurants->first()->tables()->get();
        return $tables->contains($table->id);
    }
}
