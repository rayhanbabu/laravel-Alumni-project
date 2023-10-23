<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use App\Models\Admin;
use DB;
use Hash;
use Mail;
use Session;



class FormController extends Controller
{
  
    public function registration(Request $request){

        $validator=\Validator::make($request->all(),[  
             'name' => 'required',
             'phone' => 'required',
           ],
           [
             'phone.required'=>'Phone Number is required',
             'name.required'=>'Name is required',
           ]);
         
        if($validator->fails()){
              return response()->json([
                'status'=>400,
                'validate_err'=>$validator->messages(),
              ]);
         }else{
               $model= new Form;
               $model->admin_name=$request->input('admin_name');
               $model->name=$request->input('name');
               $model->phone=$request->input('phone');
               $model->email=$request->input('email')?$request->input('email'):"";
               $model->custom1=$request->input('custom1')?$request->input('custom1'):"";
               $model->custom2=$request->input('custom2')?$request->input('custom2'):"";
               $model->custom3=$request->input('custom3')?$request->input('custom3'):"";
               $model->custom4=$request->input('custom4')?$request->input('custom4'):"";
               $model->custom5=$request->input('custom5')?$request->input('custom5'):"";
               $model->custom6=$request->input('custom6')?$request->input('custom6'):"";
               $model->custom7=$request->input('custom7')?$request->input('custom7'):"";
               $model->custom8=$request->input('custom8')?$request->input('custom8'):"";
               $model->custom9=$request->input('custom9')?$request->input('custom9'):"";
               $model->custom10=$request->input('custom10')?$request->input('custom10'):"";
               $model->save();
            return response()->json([
                  'status'=>200,  
                  'message'=>'Registration Successfull',
              ]);
         }

    }


    public function customize(Request $request){
         if(Session::has('admin')){
              $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->get();
          }

        return view('admin.formcustomize',['admin'=>$admin]);
      }

      public function customize_update(Request $request){

            $admin_name=$request->input('admin_name');
       
            $admin=Admin::where('admin_name',$admin_name)->first();
        
             if($admin){
                $model=Admin::find($request->input('edit_id'));
                $model->formname=$request->input('formname');
                $model->phone=$request->input('phone');
                $model->header=$request->input('header');
                $model->footer=$request->input('footer');
                $model->registration=$request->input('registration');
                $model->custom1=$request->input('custom1')?$request->input('custom1'):"";
                $model->custom2=$request->input('custom2')?$request->input('custom2'):"";
                $model->custom3=$request->input('custom3')?$request->input('custom3'):"";
                $model->custom4=$request->input('custom4')?$request->input('custom4'):"";
                $model->custom5=$request->input('custom5')?$request->input('custom5'):"";
                $model->custom6=$request->input('custom6')?$request->input('custom6'):"";
                $model->custom7=$request->input('custom7')?$request->input('custom7'):"";
                $model->custom8=$request->input('custom8')?$request->input('custom8'):"";
                $model->custom9=$request->input('custom9')?$request->input('custom9'):"";
                $model->custom10=$request->input('custom10')?$request->input('custom10'):"";
                $model->update();
                return back()->with('success','data Update'); 
                      
              }else{
                   return back()->with('success','Something rong'); 
             }
      }


      public function form_data(Request $request){
         if(Session::has('admin')){
                $data= Form::where('admin_name',Session::get('admin')->admin_name)->get();
          }
         return view('admin.formdata',['data'=>$data]);
     }
     
     
        public function form_update(Request $request){

        
            $model=Form::find($request->input('edit_id'));
            $model->name=$request->input('name');
            $model->phone=$request->input('phone');
            $model->custom1=$request->input('custom1')?$request->input('custom1'):"";
            $model->custom2=$request->input('custom2')?$request->input('custom2'):"";
            $model->custom3=$request->input('custom3')?$request->input('custom3'):"";
            $model->custom4=$request->input('custom4')?$request->input('custom4'):"";
            $model->custom5=$request->input('custom5')?$request->input('custom5'):"";
            $model->custom6=$request->input('custom6')?$request->input('custom6'):"";
            $model->custom7=$request->input('custom7')?$request->input('custom7'):"";
            $model->custom8=$request->input('custom8')?$request->input('custom8'):"";
            $model->custom9=$request->input('custom9')?$request->input('custom9'):"";
            $model->custom10=$request->input('custom10')?$request->input('custom10'):"";
            $model->verify_status=$request->input('verify_status');
            $model->comment=$request->input('comment');
            $model->update();
            return back()->with('success','data Update'); 
                  
         
  }


  public function form_delete($id){
    $notice=Form::find($id);
    $notice->delete();
    return back()->with('success','data Deleted'); 
}


   
}
