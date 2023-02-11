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
}
