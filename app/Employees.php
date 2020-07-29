<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Iluminate\Support\Str;
use App\Companies;
class Employees extends Model
{
    protected $table='table_employees';
    protected $guarded=['id'];

    public function Companies()
    {
        return $this->hasMany(\App\Companies::class,'companies_id','id');
    }
}
