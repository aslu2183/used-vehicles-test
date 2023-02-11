<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = ['name'];

    public function brand(){
        return $this->hasMany(Brand::class,'category_id','category_id');
    }

    public function vehicle(){
        return $this->hasMany(Vehicle::class,'category_id','category_id');
    }
}
