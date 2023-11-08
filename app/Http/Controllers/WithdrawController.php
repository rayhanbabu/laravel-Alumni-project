<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin;
use DB;
use Illuminate\Support\Facades\Session;

class WithdrawController extends Controller
{
    public function index(){
        return view('admin.withdraw');
    }

  public function fetch($admin_category){
    if(Session::has('admin')){
      $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
      $data=APP::where('admin_name',$admin->admin_name)->where('admin_category',$admin_category)
      ->orderBy('id', 'desc')->paginate(15);
       return view('admin.app_data',compact('data'));
    }
   }

   public function store(Request $request){

    if(Session::has('admin')){
       $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
       $validator=\Validator::make($request->all(),[  
         'withdraw_amount' => 'required|numeric',
      ],
     );
    
   if($validator->fails()){
         return response()->json([
           'status'=>400,
           'validate_err'=>$validator->messages(),
         ]);
   }else{
          if($admin->online_amount)
              $app= new App;
              $app->amount=$request->input('amount');
              $app->status=$request->input('status');
              $app->category=$request->input('category');
              $app->admin_category=$request->input('admin_category');
              $app->admin_name=$admin->admin_name;
              $app->save();
             return response()->json([
               'status'=>200,  
                'message'=>'Inserted Data',
             ]);
       }
      }
    }


      public function edit($id){
          $edit_value=App::find($id);
          if($edit_value){
             return response()->json([
                  'status'=>200,  
                  'edit_value'=>$edit_value,
                ]);
           }else{
               return response()->json([
                  'status'=>404,  
                  'message'=>'Student not found',
                ]);
           }
   }


   public function update(Request $request, $id){

    $validator=\Validator::make($request->all(),[
                  
       'category' => 'required',
       'amount' => 'required',
   ]);

   if($validator->fails()){
    return response()->json([
      'status'=>400,
      'validate_err'=>$validator->messages(),
    ]);
    }else{
          $app=App::find($id);
          if($app){
               $app->amount=$request->input('amount');
               $app->status=$request->input('status');
               $app->category=$request->input('category');
               $app->update();   
            return response()->json([
                'status'=>200,
                'message'=>'Data Updated'
             ]);
           }else{
              return response()->json([
                  'status'=>404,  
                  'message'=>'Student not found',
                ]);
          }

       }
   }  


   public function destroy($id){
      $notice=App::find($id);
      $notice->delete();
      return response()->json([
         'status'=>200,  
         'message'=>'Deleted Data',
       ]);
  }
  


  function fetch_data(Request $request,$admin_category)
  {
   if($request->ajax())
   {
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
    $sort_by = $request->get('sortby');
    $sort_type = $request->get('sorttype'); 
          $search = $request->get('search');
          $search = str_replace(" ", "%", $search);
    $data = App::where('admin_name',$admin->admin_name)
            ->where('admin_category',$admin_category)
            ->where(function($query) use ($search) {
                $query->orwhere('category', 'like', '%'.$search.'%');
                $query->orWhere('amount', 'like', '%'.$search.'%');
                })
                  ->orderBy($sort_by, $sort_type)
                  ->paginate(15);
                  return view('admin.app_data', compact('data'))->render();
                 
   }
  }
 
}
