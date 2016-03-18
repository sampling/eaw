<?php

namespace App\Http\Controllers\Backend\Maps;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Map\MapContract;
use App\Http\Requests\Backend\Map\CreateMapRequest;
use App\Http\Requests\Backend\Map\EditMapRequest;
use App\Http\Requests\Backend\Map\StoreMapRequest;
use App\Http\Requests\Backend\Map\UpdateMapRequest;
use App\Http\Requests\Backend\Map\DeleteMapRequest;


/**
 * Class MapController
 */
class MapController extends Controller
{
    /**
     * @var UserContract
     */
    protected $users;

    /**
    * @var MapContract
    */
    protected $maps;

    /**
     * @param UserContract                 $users
     * @param MapContract                  $maps
     */
    public function __construct(
        UserContract $users,
        MapContract $maps
    )
    {
        $this->users       = $users;
        $this->maps        = $maps;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('backend.map.index')
            ->withMaps($this->maps->getMapsPaginated(config('access.maps.default_per_page'), 1));
    }

    /**
     * @param  CreateMapRequest $request
     * @return mixed
     */
    public function create(CreateMapRequest $request)
    {
        return view('backend.map.create')
            ->withUsers($this->users->getAllUsers('name', 'asc', true));
    }

    /**
     * @param  StoreMapRequest $request
     * @return mixed
     */
    public function store(StoreMapRequest $request)
    {
        $this->maps->create(
            $request->except('assignees_users'),
            $request->only('assignees_users')
        );
        return redirect()->route('admin.maps.index')->withFlashSuccess(trans('alerts.backend.maps.created'));
    }

    /**
     * @param  $id
     * @param  EditUserRequest $request
     * @return mixed
     */
    public function edit($id, EditUserRequest $request)
    {
        $user = $this->users->findOrThrowException($id, true);
        return view('backend.access.edit')
            ->withUser($user)
            ->withUserRoles($user->roles->lists('id')->all())
            ->withRoles($this->roles->getAllRoles('sort', 'asc', true))
            ->withUserPermissions($user->permissions->lists('id')->all())
            ->withPermissions($this->permissions->getAllPermissions());
    }

    /**
     * @param  $id
     * @param  UpdateMapRequest $request
     * @return mixed
     */
    public function update($id, UpdateMapRequest $request)
    {
        $this->users->update($id,
            $request->except('assignees_maps'),
            $request->only('assignees_users')
        );
        return redirect()->route('admin.maps.index')->withFlashSuccess(trans('alerts.backend.maps.updated'));
    }

    /**
     * @param  $id
     * @param  DeleteMapRequest $request
     * @return mixed
     */
    public function delete($id, DeleteMapRequest $request)
    {
        $this->maps->delete($id);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.maps.deleted'));
    }

    /**
     * @return mixed
     */
    public function deleted()
    {
        return view('backend.access.deleted')
            ->withUsers($this->users->getDeletedUsersPaginated(25));
    }
}
