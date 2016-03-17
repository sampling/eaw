<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Access\Role\Traits\RoleAccess;
// use App\Models\Access\Role\Traits\Attribute\RoleAttribute;
// use App\Models\Access\Role\Traits\Relationship\RoleRelationship;

/**
 * Class Map
 * @package App\Models\Map
 */
class Map extends Model
{
    // use RoleAccess, RoleAttribute, RoleRelationship;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     *
     */
    public function __construct()
    {
        $this->table = config('maps');
    }
}
