<?php

namespace App\Http\Controllers;

use App\Models\Donorwithdraw;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\File;


class DonorwithdrawController extends Controller
{
    public function donorwithdraw_index(){
         $admin= Admin::all();
         return view('maintain.donorwithdraw',['admin'=>$admin]);
    }

   public function donorwithdraw_fetch(Request $request){
       $admin_name = $request->header('admin_name');
       $data=Donorwithdraw::orderBy('id','desc')->paginate(15);
         return view('maintain.donorwithdraw_data',compact('data'));
    }

    function donorwithdraw_fetch_data(Request $request)
    {
      if($request->ajax())
      {
       $admin_name = $request->header('admin_name'); 
       $sort_by = $request->get('sortby');
       $sort_type = $request->get('sorttype'); 
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
        $data = Donorwithdraw::where(function($query) use ($search) {
                 $query->orwhere('bank_name', 'like', '%'.$search.'%');
                 $query->orwhere('admin_name', 'like', '%'.$search.'%');
                 $query->orWhere('withdraw_amount', 'like', '%'.$search.'%');
                 })
                   ->orderBy($sort_by, $sort_type)
                   ->paginate(15);
                   return view('maintain.donorwithdraw_data', compact('data'))->render();      
         }
       }


       public function store(Request $request){
            $validator=\Validator::make($request->all(),[  
               'withdraw_amount' => 'required|numeric',
               'admin_name' => 'required',
             ],
           );
        
       if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
             ]);
       }else{
          $admin= Admin::where('admin_name',$request->input('admin_name'))->first();
                  $app= new Donorwithdraw;
                  $app->withdraw_amount=$request->input('withdraw_amount');
                  $app->bank_route=$admin->bank_route;
                  $app->bank_account=$admin->bank_account;
                  $app->bank_name=$admin->bank_name;
                  $app->withdraw_submited_time=date('Y-m-d H:i:s');
                  $app->admin_name=$request->input('admin_name');
                  $app->save();
                 return response()->json([
                   'status'=>200,  
                    'message'=>'Inserted Data',
                 ]);   
           }     
        }


        public function donorwithdraw_update(Request $request)
        {
           $validated = $request->validate([
                'image' =>'image|mimes:jpeg,png,jpg|max:512000',
                'withdraw_info'=>'required',
                'withdraw_status'=>'required',
            ]);
    
           $model = Donorwithdraw::find($request->input('id'));
           $model->withdraw_info=$request->input('withdraw_info');
           $model->withdraw_info_update="Admin";
           $model->updated_by=maintain_access()->maintain_name;
           $model->updated_by_time=date('Y-m-d H:i:s');
           $model->withdraw_status=$request->input('withdraw_status');
    
           if($request->hasfile('image')){
               $path=public_path('uploads/admin/').$model->image;
               if(File::exists($path)){
                File::delete($path);
                }
                $image= $request->file('image');
                $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/admin'), $file_name);
                $model->image=$file_name;
            }
           $model->save();
    
           return redirect()->back()->with('success','Data Updated Successfuly');
      }



      public function admin_donorwithdraw_index(){
          return view('admin.donorwithdraw');
      }

     public function admin_donorwithdraw_fetch(Request $request){
        $admin_name = $request->header('admin_name');
        $data=Donorwithdraw::where('admin_name',$admin_name)->orderBy('id','desc')->paginate(15);
        return view('admin.donorwithdraw_data',compact('data'));
   }

   function admin_donorwithdraw_fetch_data(Request $request)
   {
     if($request->ajax())
     {
      $admin_name = $request->header('admin_name'); 
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype'); 
           $search = $request->get('search');
           $search = str_replace(" ", "%", $search);
       $data = Donorwithdraw::where('admin_name',$admin_name)
                ->where(function($query) use ($search) {
                $query->orwhere('bank_name', 'like', '%'.$search.'%');
                $query->orwhere('admin_name', 'like', '%'.$search.'%');
                $query->orWhere('withdraw_amount', 'like', '%'.$search.'%');
                })
                  ->orderBy($sort_by, $sort_type)
                  ->paginate(15);
                  return view('admin.donorwithdraw_data', compact('data'))->render();      
        }
      }
    


}
