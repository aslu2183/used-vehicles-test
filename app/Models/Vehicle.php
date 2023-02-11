<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vehicle extends Model
{
    use HasFactory;
    protected $primaryKey = 'vehicle_id';

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'model_id',
        'trim_id',
        'vehicle_image'
    ];

    protected $appends = ['vehicle_image_url'];

    protected $with = [
        'category:category_id,name',
        'brand:brand_id,name',
        'model:model_id,name',
        'trim:trim_id,name'
    ];

    protected $hidden = [
        'category_id',
        'brand_id',
        'model_id',
        'trim_id',
        'vehicle_image'
    ];
    
    public function getVehicleImageUrlAttribute(){
        return Storage::url($this->vehicle_image);
    }

    public function category(){
        return $this->hasOne(Category::class,'category_id','category_id');
    }
    
    public function brand(){
        return $this->hasOne(Brand::class,'brand_id','brand_id');
    }

    public function model(){
        return $this->hasOne(VehicleModel::class,'model_id','model_id');
    }

    public function trim(){
        return $this->hasOne(Trim::class,'trim_id','trim_id');
    }

}
