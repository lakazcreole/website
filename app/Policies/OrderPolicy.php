<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can accept the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function accept(User $user, Order $order)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can decline the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function decline(User $user, Order $order)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can cancel the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function cancel(User $user, Order $order)
    {
        return $user->admin;
    }
}
