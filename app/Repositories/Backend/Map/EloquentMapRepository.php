<?php

namespace App\Repositories\Backend\Map;

use App\Models\Map\Map;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\User\UserContract;

/**
 * Class EloquentMapRepository
 * @package App\Repositories\Map
 */
class EloquentMapRepository implements MapContract
{
    /**
     * @var UserContract
     */
    protected $user;

    /**
     * @param UserContract $user
     */
    public function __construct(
        UserContract $user
    )
    {
        $this->user = $user;
    }

    /**
     * @param  $id
     * @param  bool               $withRoles
     * @throws GeneralException
     * @return mixed
     */
    public function findOrThrowException($id, $withUsers = false)
    {
        if ($withUsers) {
            $map = Map::with('users')->find($id);
        } else {
            $map = Map::find($id);
        }

        if (!is_null($map)) {
            return $map;
        }

        throw new GeneralException(trans('exceptions.backend.access.maps.not_found'));
    }

    /**
     * @param  $per_page
     * @param  string      $order_by
     * @param  string      $sort
     * @param  int         $status
     * @return mixed
     */
    public function getMapsPaginated($per_page, $status = 1, $order_by = 'id', $sort = 'asc')
    {
        return Map::with('users')
            ->orderBy($order_by, $sort)
            ->paginate($per_page);
    }

    /**
     * @param  string  $order_by
     * @param  string  $sort
     * @return mixed
     */
    public function getAllMaps($order_by = 'id', $sort = 'asc')
    {
        return Map::orderBy($order_by, $sort)
            ->get();
    }

    /**
     * @param  $input
     * @param  $roles
     * @param  $permissions
     * @throws GeneralException
     * @throws UserNeedsRolesException
     * @return bool
     */
    public function create($input, $roles, $permissions)
    {
        $user = $this->createUserStub($input);

        if ($user->save()) {
            //User Created, Validate Roles
            $this->validateRoleAmount($user, $roles['assignees_roles']);

            //Attach new roles
            $user->attachRoles($roles['assignees_roles']);

            //Attach other permissions
            $user->attachPermissions($permissions['permission_user']);

            //Send confirmation email if requested
            if (isset($input['confirmation_email']) && $user->confirmed == 0) {
                $this->user->sendConfirmationEmail($user->id);
            }

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
    }

    /**
     * @param $id
     * @param $input
     * @param $roles
     * @param $permissions
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $roles, $permissions)
    {
        $user = $this->findOrThrowException($id);
        $this->checkUserByEmail($input, $user);

        if ($user->update($input)) {
            //For whatever reason this just wont work in the above call, so a second is needed for now
            $user->status    = isset($input['status']) ? 1 : 0;
            $user->confirmed = isset($input['confirmed']) ? 1 : 0;
            $user->save();

            $this->checkUserRolesCount($roles);
            $this->flushRoles($roles, $user);
            $this->flushPermissions($permissions, $user);

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
    }

    /**
     * @param  $id
     * @throws GeneralException
     * @return bool
     */
    public function delete($id)
    {
        $map = $this->findOrThrowException($id);
        if ($map->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.maps.delete_error'));
    }

    /**
     * Check to make sure at lease one role is being applied or deactivate user
     *
     * @param  $user
     * @param  $roles
     * @throws UserNeedsRolesException
     */
    private function validateRoleAmount($user, $roles)
    {
        //Validate that there's at least one role chosen, placing this here so
        //at lease the user can be updated first, if this fails the roles will be
        //kept the same as before the user was updated
        if (count($roles) == 0) {
            //Deactivate user
            $user->status = 0;
            $user->save();

            $exception = new UserNeedsRolesException();
            $exception->setValidationErrors(trans('exceptions.backend.access.users.role_needed_create'));

            //Grab the user id in the controller
            $exception->setUserID($user->id);
            throw $exception;
        }
    }


    /**
     * @param $roles
     * @param $user
     */
    private function flushRoles($roles, $user)
    {
        //Flush roles out, then add array of new ones
        $user->detachRoles($user->roles);
        $user->attachRoles($roles['assignees_roles']);
    }

    /**
     * @param $permissions
     * @param $user
     */
    private function flushPermissions($permissions, $user)
    {
        //Flush permissions out, then add array of new ones if any
        $user->detachPermissions($user->permissions);
        if (count($permissions['permission_user']) > 0) {
            $user->attachPermissions($permissions['permission_user']);
        }

    }

    /**
     * @param  $roles
     * @throws GeneralException
     */
    private function checkUserRolesCount($roles)
    {
        //User Updated, Update Roles
        //Validate that there's at least one role chosen
        if (count($roles['assignees_roles']) == 0) {
            throw new GeneralException(trans('exceptions.backend.access.users.role_needed'));
        }

    }

    /**
     * @param  $input
     * @return mixed
     */
    private function createUserStub($input)
    {
        $user                    = new User;
        $user->name              = $input['name'];
        $user->email             = $input['email'];
        $user->password          = bcrypt($input['password']);
        $user->status            = isset($input['status']) ? 1 : 0;
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed         = isset($input['confirmed']) ? 1 : 0;
        return $user;
    }
}
