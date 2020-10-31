<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Style extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'styles';
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function lights()
    {
        return $this->hasMany('App\Models\Light');
    }

    public function products()
    {
        return $this -> hasManyThrough('App\Models\Product', 'App\Models\Light', 'style_id', 'id', 'id', 'product_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        // Global visibility scope
        static::addGlobalScope('visibility', function (Builder $builder) {
            $builder->where(['visible' => 1])
                    // ->whereNotNull('image')
                    ->whereNotNull('background')
                    ->orderBy('lft', 'ASC');
        });
    }

    public function clearGlobalScopes()
    {
        static::$globalScopes = [];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this -> slug != '') {
            return $this -> slug;
        }

        return $this -> name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // TODO: !!! bring into compliance with DRY principle

    /**
     * Sets image attribute
     * @param string $value
     */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        // TODO: !!! move variables to config
        $disk = "public";
        $destination_path = "uploads/models/style";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // make the image
            $image = \Image::make($value);
            // generate a filename.
            $filename = md5($value.time()).'.jpg';
            // store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }

    /**
     * Sets background attribute
     * @param string $value
     */
    public function setBackgroundAttribute($value)
    {
        $attribute_name = "background";
        // TODO: !!! move variables to config
        $disk = "public";
        $destination_path = "uploads/models/style";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // make the image
            $image = \Image::make($value);
            // generate a filename.
            $filename = md5($value.time()).'.jpg';
            // store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }
}
