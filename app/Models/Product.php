<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

/**
 * Product model
 */
class Product extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function interior_images()
    {
        return $this->hasMany('App\Models\ProductInteriorImage');
    }

    public function light()
    {
        return $this->hasOne('App\Models\Light');
    }

    public function family()
    {
        return $this->hasManyThrough('App\Models\Family', 'App\Models\Light');
    }

    public function bulb()
    {
        return $this->hasOne('App\Models\Bulb');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('active', '1');
    }

    public function scopeListed($query)
    {
        return $query->where('listed', '1');
    }

    public function scopeOnlyCeiling($query)
    {
        return $query->whereHas('categories', function ($q) {
            $q->where('categories.id', 1);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MISC
    |--------------------------------------------------------------------------
    */

    // Global visibility scope
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('visibility', function (Builder $builder) {
            $builder -> where(['active' => 1,'listed' => 1]) ->
                        whereNotNull('image1dark') ->
                        has('light.collection')->
                        has('images');
        });
    }

    public function clearGlobalScopes()
    {
        static::$globalScopes = [];
    }
}
