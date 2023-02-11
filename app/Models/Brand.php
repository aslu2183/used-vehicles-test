<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'name',
        'category_id'
    ];

    protected $hidden = ['category_id'];
    
    public function model(){
        return $this->hasMany(VehicleModel::class,'brand_id','brand_id');
    }

    public function vehicle(){
        return $this->hasMany(Vehicle::class,'brand_id','brand_id');
    }
}
