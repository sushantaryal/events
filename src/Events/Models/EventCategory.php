<?php

namespace Taggers\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class EventCategory extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /*****************/
    /* Relationships */
    /*****************/
    public function events()
    {
        return $this->belongsToMany(Event::class, 'category_event', 'category_id', 'event_id');
    }

    /**********************/
	/* Additional Methods */
	/**********************/
	public function delete()
	{
        $this->events()->detach();
        parent::delete();
	}
}
