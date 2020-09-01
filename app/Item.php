<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const TYPE_FEEDBACK   = 1;
    const TYPE_SERVICE    = 2;
    const TYPE_COMMENT    = 3;

    const STATUS_ACTIVE   = 1;
    const STATUS_REMOVED  = 2;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type'   => Item::TYPE_FEEDBACK,
        'status' => Item::STATUS_ACTIVE,
        'hidden' => false,
    ];

    protected $fillable = [
        'user_id',
        'parent_id',
        'location_id',
        'category_id',
        'specification_id',
        'status',
        'type',
        'title',
        'description',
        'hidden'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function parent()
    {
        return $this->hasOne('App\Item');
    }

    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function category()
    {
        return $this->hasOne('App\Category');
    }

    public function specification()
    {
        return $this->hasOne('App\Specification');
    }

    public function reactions()
    {
        return $this->hasMany('App\Reaction');
    }

    public function getReactionsAmount()
    {
        $reactionsAmount = Array();
        $reactions = $this->find($this->id)->reactions->groupBy('text');
        
        $reactionNames = $reactions->keys();

        foreach($reactionNames as $reactionName) {
            $reactionsAmount[$reactionName] = $reactions[$reactionName]->count();
        }
        
        return $reactionsAmount;
    }

    public function hasReactions()
    {
        return $this->find($this->id)->reactions->count();
    }

}
