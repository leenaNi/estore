<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
use App\Models\Pincode;
use Input;
use Session;
use App\Library\Helper;


class CityController extends Controller
{
    public function index(){
        if(!empty(Input::get("city_name"))){
          $cities=City::where('city_name','like','%'.Input::get("city_name"). '%')->get();
                   
            
        }else{
            $cities=City::paginate(Config('constants.paginateNo'));  
        }
       
        return view(Config('constants.adminCitiesView') . '.index', compact('cities')); 
    }
 
  public function addEdit(){  
      $city=City::find(Input::get("id"));
      $states=State::orderBy('state_name')->get();
      $state=[];
    
      foreach($states as $value){
          //  dd($value['id']);
          $state[$value['id']]=$value['state_name'];
      }
      $action=route('admin.cities.save');
       return view(Config('constants.adminCitiesView') . '.addEdit', compact('state','action','city'));
  }
  
   public function save(){
       $city=City::findOrNew(Input::get("id"));
       $city->state_id=Input::get('state_id');
       $city->city_name=Input::get('city_name');
       $city->cod_status=Input::get('cod_status');
       $city->delivary_status=Input::get('delivary_status');
       $city->status=Input::get('status');
       $city->save();
       if(empty(Input::get("id"))){
          $data=['status'=>1,'message'=>'City added successfully.'];
          Session::flash("message","City added successfully.");
       }else{
           $data=['status'=>1,'message'=>'City updated successfully.'];
          Session::flash("message","City updated successfully."); 
       }
       $viewname='';
      return Helper::returnView($viewname, $data, $url = 'admin.cities.view'); 
   }
   
    public function changeDelivaryStatus(Request $request) {
        $type=$request->type;
        $city = City::find($request->id);
        
       
        if ($city->delivary_status == 1) {
           $city->delivary_status= 0;
           if($type=='1'){
          $pincodes=Pincode::where('city_id',$request->id)->update(['delivary_status'=>0]);  
        }
            $msg = "Delivary status disabled successfully.";
        } else if($city->delivary_status == 0) {
            if($type=='1'){
          $pincodes=Pincode::where('city_id',$request->id)->update(['delivary_status'=>1]);  
        }
           $city->delivary_status = 1;
            $msg = "Delivary status enabled successfully.";
        }
        $city->update();
        Session::flash("msg", $msg);
        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminContactView') . '.index';
      // return $city;
        return Helper::returnView($viewname, $data, $url = 'admin.cities.view');
    }
   
   public function changeCodStatus(Request $request) {
        $type=$request->type;
        $city = City::find($request->id);
        
       
        if ($city->cod_status == 1) {
           $city->cod_status= 0;
           if($type=='1'){
          $pincodes=Pincode::where('city_id',$request->id)->update(['cod_status'=>0]);  
        }
            $msg = "COD status disabled successfully.";
        } else if($city->cod_status == 0) {
            if($type=='1'){
          $pincodes=Pincode::where('city_id',$request->id)->update(['cod_status'=>1]);  
        }
           $city->cod_status = 1;
            $msg = "COD status enabled successfully.";
        }
        $city->update();
        Session::flash("msg", $msg);
        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminContactView') . '.index';
      // return $city;
        return Helper::returnView($viewname, $data, $url = 'admin.cities.view');
    } 
    
    public function changeStatus(Request $request) {
        $type=$request->type;
        $city = City::find($request->id);
        
       
        if ($city->status == 1) {
           $city->status= 0;
           if($type=='1'){
          $pincodes=Pincode::where('city_id',$request->id)->update(['status'=>0]);  
        }
            $msg = "Status disabled successfully.";
        } else if($city->status == 0) {
            if($type=='1'){
          $pincodes=Pincode::where('city_id',$request->id)->update(['status'=>1]);  
        }
           $city->status = 1;
            $msg = "Status enabled successfully.";
        }
        $city->update();
        Session::flash("msg", $msg);
        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminContactView') . '.index';
      // return $city;
        return Helper::returnView($viewname, $data, $url = 'admin.cities.view');
    } 
    
}
