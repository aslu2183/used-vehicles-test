<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'model_id';
    
    protected $table      = 'models';

    protected $fillable   = ['name','brand_id']; 

    protected $hidden     = ['brand_id'];

    public function variant(){
        return $this->hasMany(Trim::class,'model_id','model_id');
    }
 
}
