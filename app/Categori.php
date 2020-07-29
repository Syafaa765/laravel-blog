<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Artikel;

class Categori extends Model
{
    protected $table='table_categories';
    protected $guarded=['id'];


    public function setSlugAttribute ($value)
    {
    $this->attributes['slug'] = Str::slug($value,'-');
    }

    public function getRoutekeyName()
    {
        return 'slug';
    }
    public function Artikel()
    {
        return $this->hasMany(\App\Artikel::class,'categories_id','id');
    }
}
