<?php

namespace App\Repositories\Backend\Map;

/**
 * Interface MapContract
 * @package App\Repositories\Map
 */
interface MapContract
{
    /**
     * @param  $per_page
     * @param  string      $order_by
     * @param  string      $sort
     * @param  $status
     * @return mixed
     */
    public function getMapsPaginated($per_page, $status = 1, $order_by = 'id', $sort = 'asc');


    /**
     * @param  string  $order_by
     * @param  string  $sort
     * @return mixed
     */
    public function getAllMaps($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @param $users
     * @return mixed
     */
    public function create($input, $users);

    /**
     * @param $id
     * @param $input
     * @param $users
     * @return mixed
     */
    public function update($id, $input, $users);


    /**
     * @param  $id
     * @return mixed
     */
    public function delete($id);
}
