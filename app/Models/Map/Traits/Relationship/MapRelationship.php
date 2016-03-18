<?php

namespace App\Models\Map\Traits\Relationship;

/**
 * Class MapRelationship
 * @package App\Models\Map\Traits\Relationship
 */
trait MapRelationship
{
    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), config('maps.assigned_maps_table'), 'map_id', 'user_id');
    }
}
