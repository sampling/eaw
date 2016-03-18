<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\Map\Traits\Map as MapTrait;
use App\Models\Map\Traits\Attribute\MapAttribute;
use App\Models\Map\Traits\Relationship\MapRelationship;

/**
 * Class Map
 * @package App\Models\Map
 */
class Map extends Model
{
    use MapTrait, MapAttribute, MapRelationship;

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
