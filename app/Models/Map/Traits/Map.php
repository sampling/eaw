<?php

namespace App\Models\Map\Traits;

/**
 * Class Map
 * @package App\Models\Map\Traits
 */
trait Map
{
    /**
     * Save the inputted users.
     *
     * @param  mixed  $inputUsers
     * @return void
     */
    public function saveUsers($inputUsers)
    {
        if (!empty($inputUsers)) {
            $this->users()->sync($inputUsers);
        } else {
            $this->users()->detach();
        }
    }

    /**
     * Attach user to current map.
     *
     * @param  object|array $user
     * @return void
     */
    public function attachUser($user)
    {
        if (is_object($user)) {
            $user = $user->getKey();
        }

        if (is_array($user)) {
            $user = $user['id'];
        }

        $this->users()->attach($user);
    }

    /**
     * Detach user form current map.
     *
     * @param  object|array $user
     * @return void
     */
    public function detachUser($user)
    {
        if (is_object($user)) {
            $user = $user->getKey();
        }

        if (is_array($user)) {
            $user = $user['id'];
        }

        $this->users()->detach($user);
    }

    /**
     * Attach multiple users to current map.
     *
     * @param  mixed  $users
     * @return void
     */
    public function attachUsers($users)
    {
        foreach ($users as $user) {
            $this->attachUser($user);
        }
    }

    /**
     * Detach multiple users from current map
     *
     * @param  mixed  $users
     * @return void
     */
    public function detachUsers($users)
    {
        foreach ($users as $user) {
            $this->detachUser($user);
        }
    }
}
