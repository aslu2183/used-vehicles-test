<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Trim;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    //
    public function createVehicle(Request $request){
        $request->validate([
            'name'     => 'required',
            'category' => 'required',
            'brand'    => 'required',
            'model'    => 'required',
        ]);

        $category = Category::where('name',$request->category)->first(); 
        if(!$category){
            return [
                'status' => false,
                'message'=> "Category not found"
            ];
        }
        $brand    = Brand::where('name',$request->brand)->first();
        if(!$brand){
            return [
                'status' => false,
                'message'=> "Brand not found"
            ];
        }
        $model    = VehicleModel::where('name',$request->model)->first();
        if(!$model){
            return [
                'status' => false,
                'message'=> "Model Not Found"
            ];
        }
        $trim_id     = null;
        if($request->has('trim')){
            $trim    = Trim::where('name',$request->trim)->first();
            $trim_id = $trim->trim_id;
        }    

        $file = null;
        if($request->has('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name = Str::slug($request->name, '-')."_".time().".".$extension;
            $file      = $request->file('image')->storeAs('vehicles',$file_name);
        }

        $insertData = [
            'name'          => $request->name,
            'category_id'   => $category->category_id,
            'brand_id'      => $brand->brand_id,
            'model_id'      => $model->model_id,
            'trim_id'       => $trim_id,
            'vehicle_image' => $file
        ];

        $inserted = Vehicle::create($insertData);
        if($inserted){
            return [
                'status' => true,
                'message'=> 'Vehicle Created',
                'data'   => $insertData
            ];
        }
        else{
            return [
                'status' => false,
                'message'=> 'Some thing went wrong'
            ];    
        }

        return $insertData;
    }

    public function getVehicles(Request $request){
        $limit= ($request->has('limit') && $request->limit > 0) ? $request->limit : 10;
        $page = $request->page ?? 1;
        $vehicles = Vehicle::paginate($limit,['*'],'vehicles',$page);
        return [
            'status' => true,
            'message'=> 'Vehicle listing',
            'data'   => [
                'vehicles' => $vehicles->toArray()['data'],
                'total'    => $vehicles->total()
            ] 
        ];
    }

    public function createCategory(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $exist = Category::where('name',$request->name)->first();
        if($exist){
            return [
                'status' => false,
                'message'=> 'Category already exist'
            ];
        }
        $inserted = Category::create(['name' => $request->name]);
        if($inserted){
            return [
                'status' => true,
                'message'=> 'New Category Added'
            ];
        }
        else{
            return [
                'status' => false,
                'message'=> 'Something went wrong'
            ];
        }
    }

    public function createBrand(Request $request){
        $request->validate([
            'name'     => 'required',
            'category' => 'required'
        ]);

        $category = Category::where("name",$request->category)->first();
        if(!$category){
            return [
                'status' => false,
                'message'=> 'Category Not Found'
            ];
        }
        
        $exist = Brand::where(['name' => $request->name, 'category_id' => $category->category_id])->first();
        if($exist){
            return [
                'status' => false,
                'message'=> 'Brand already exist for this category.'
            ];
        }

        $inserted = Brand::create(['name' => $request->name,'category_id' => $category->category_id]);
        if($inserted){
            return [
                'status' => true,
                'message'=> 'New Brand Added'
            ];
        }
        else{
            return [
                'status' => false,
                'message'=> 'Something went wrong'
            ];
        }
    }

    public function createModel(Request $request){
        $request->validate([
            'name'     => 'required',
            'brand'    => 'required'
        ]);

        $brand = Brand::where("name",$request->brand)->first();
        if(!$brand){
            return [
                'status' => false,
                'message'=> 'Brand Not Found'
            ];
        }
        
        $exist = VehicleModel::where(['name' => $request->name,'brand_id' => $brand->brand_id])->first();
        if($exist){
            return [
                'status' => false,
                'message'=> 'Model already exist for this brand.'
            ];
        }

        $inserted = VehicleModel::create(['name' => $request->name,'brand_id' => $brand->brand_id]);
        if($inserted){
            return [
                'status' => true,
                'message'=> 'New Model Added'
            ];
        }
        else{
            return [
                'status' => false,
                'message'=> 'Something went wrong'
            ];
        }
    }

    public function createVariant(Request $request){
        $request->validate([
            'name'     => 'required',
            'model'    => 'required'
        ]);

        $model = VehicleModel::where("name",$request->model)->first();
        if(!$model){
            return [
                'status' => false,
                'message'=> 'Vehicle model not found.'
            ];
        }
        
        $exist = Trim::where(['name' => $request->name,'model_id' => $model->model_id])->first();
        if($exist){
            return [
                'status' => false,
                'message'=> 'Variant already exist for this model'
            ];
        }

        $inserted = Trim::create(['name' => $request->name,'model_id' => $model->model_id]);
        if($inserted){
            return [
                'status' => true,
                'message'=> 'New Variant Added'
            ];
        }
        else{
            return [
                'status' => false,
                'message'=> 'Something went wrong'
            ];
        }
    }
}
