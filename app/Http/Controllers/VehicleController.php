<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Trim;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class VehicleController extends Controller
{
    //
    public function createVehicle(Request $request){
        $request->validate([
            'name'     => 'required',
            'category' => 'required',
        ]);

        $category = Category::where('name',$request->category)->first(); 
        if(!$category){
            return [
                'status' => false,
                'message'=> "Category not found"
            ];
        }

        $brand_id = null;
        if($request->has('brand')){
            $brand    = Brand::where('name',$request->brand)->first();
            if(!$brand){
                return [
                    'status' => false,
                    'message'=> "Brand not found"
                ];
            }
            $brand_id = $brand->brand_id;
        }

        $model_id = null;
        if($request->has('model')){
            $model = VehicleModel::where('name',$request->model)->first();
            if(!$model){
                return [
                    'status' => false,
                    'message'=> "Model Not Found"
                ];
            }
            $model_id = $model->model_id;
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
            'brand_id'      => $brand_id,
            'model_id'      => $model_id,
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
        $levels  = collect([0 => 'category',1 => 'brand',2 => 'model', 3 => 'variant']);
        // $limit   = ($request->has('limit') && $request->limit > 0) ? $request->limit : 10;
        $filters = $request->filter;
        // $i = 0;
        $vehicleData = [];
        $finalData = [];
        if(count($request->filter) > 0){
            $test = "HAs filter";
            foreach($filters as $filter){
                $filter_arr = [];
                $j = 0;
                foreach($filter as $res){
                    $value = 0;
                    if($levels[$j] == 'category'){
                        $cats  = Category::where('name',$res)->first();
                        if($cats){
                            $value = $cats->category_id;
                        }    
                        
                    }
                    if($levels[$j] == 'brand'){
                        $cats  = Brand::where('name',$res)->first();
                        if($cats){
                            $value = $cats->brand_id;
                        }    
                    }
                    if($levels[$j] == 'model'){
                        $cats  = VehicleModel::where('name',$res)->first();
                        if($cats){
                            $value = $cats->model_id;
                        }    
                    }
                    if($levels[$j] == 'variant'){
                        $cats  = Trim::where('name',$res)->first();
                        if($cats){
                            $value = $cats->trim_id;
                        }    
                    }
                    
                    if($value > 0){
                        $filter_arr[$levels[$j]] = $value;
                    }    
                    $j++;
                }
                $filter_collect = collect($filter_arr);
                $vehicles       = Vehicle::with(['category:category_id,name','brand:brand_id,name','model:model_id,name','variant:trim_id,name']);
                if($filter_collect->has('category')){
                    $vehicles = $vehicles->where('category_id',$filter_collect->get('category'));
                }
                if($filter_collect->has('brand')){
                    $vehicles = $vehicles->where('brand_id',$filter_collect->get('brand'));
                }
                if($filter_collect->has('model')){
                    $vehicles = $vehicles->where('model_id',$filter_collect->get('model'));
                }
                if($filter_collect->has('variant')){
                    $vehicles = $vehicles->where('trim_id',$filter_collect->get('variant'));
                }
                $vehicleData[] = $vehicles->get();
                
            }
            
            foreach($vehicleData as $vehicles){
                foreach($vehicles as $vehicle){
                    array_push($finalData,$vehicle);
                }
            }
        }
        else{
            $vehicles = Vehicle::with(['category:category_id,name','brand:brand_id,name','model:model_id,name','variant:trim_id,name'])->get();
            $finalData = $vehicles;
        }    
                         
        return [
            'status' => true,
            'message'=> 'Vehicle listing',
            'data'   => [
                'vehicles' => $finalData,
               
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

    public function getCategories(){
        $cats = Category::with('brand')->withCount('vehicle')->get();
       
        $tmp_arr = collect([]);
        foreach($cats as $item){

            if(!collect($item->brand)->isEmpty()){
                $brand_arr = collect([]);
                foreach($item->brand as $brand) {
                    $models = VehicleModel::where('brand_id',$brand->brand_id)->get();
                    $brand_vehicle_count = Vehicle::where('brand_id',$brand->brand_id)->count();
                    $models_arr = collect([]);
                    
                    foreach($models as $model){
                        $trims = Trim::where('model_id',$model->model_id)->get();
                        $model_vehicle_count = Vehicle::where('model_id',$model->model_id)->count();
                        
                        $trims_arr = collect([]);
                        foreach($trims as $trim){
                            $model_vehicle_count = Vehicle::where('trim_id',$trim->trim_id)->count();
                            $trims_arr->push([
                                'name'    => $trim->name,
                                'id'      => $trim->trim_id,
                                'vehicle_count' => $model_vehicle_count
                            ]);    
                        }
                        $models_arr->push([
                            'name'    => $model->name,
                            'id'      => $model->model_id,
                            'variant' => $trims_arr,
                            'vehicle_count' => $model_vehicle_count
                        ]); 
                    }
                    
                    $brand_arr->push([
                        'name' => $brand->name,
                        'id'   => $brand->brand_id,
                        'model'=> $models_arr,
                        'vehicle_count' => $brand_vehicle_count
                    ]);
                }
                $tmp_arr->push([
                    'name' => $item->name,
                    'id'   => $item->category_id,
                    'brand'=> $brand_arr,
                    'vehicle_count' => $item->vehicle_count
                ]);
            }
            else{
               $tmp_arr->push([
                    'name' => $item->name,
                    'id'   => $item->id,
                    'brand'=> [],
                    'vehicle_count' => $item->vehicle_count
                ]);
            }
            
        }
        return [
            'status' => true,
            'data'   => [
                'categories' => $tmp_arr,
                
            ],
            'message'=> "Listing Categories"
        ];
    }
}
