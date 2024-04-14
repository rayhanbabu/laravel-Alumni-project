<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WithdrawController extends Controller
{
    public function index(){
        return view('admin.withdraw');
    }

  public function fetch(){
    if(Session::has('admin')){
      $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
      $data=Withdraw::where('admin_name',$admin->admin_name)
         ->orderBy('id','desc')->paginate(15);
       return view('admin.withdraw_data',compact('data'));
    }
   }

   public function store(Request $request){
    $admin= Admin::where('admin_name',$request->input('admin_name'))->first();
        $validator=\Validator::make($request->all(),[  
           'withdraw_amount' => 'required|numeric',
         ],
       );
    
   if($validator->fails()){
         return response()->json([
           'status'=>700,
           'message'=>$validator->messages(),
         ]);
   }else{
          
              $app= new Withdraw;
              $app->withdraw_amount=$request->input('withdraw_amount');
              $app->bank_route=$admin->bank_route;
              $app->bank_account=$admin->bank_account;
              $app->bank_name=$admin->bank_name;
              $app->withdraw_submited_time=date('Y-m-d H:i:s');
              $app->admin_name=$admin->admin_name;
              $app->save();
             return response()->json([
               'status'=>200,  
                'message'=>'Inserted Data',
             ]);   
       }
     
    }


   


   public function destroy($id){
      $app=Withdraw::find($id);
      $app->withdraw_status=5;
      $app->update();
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
      $data = Withdraw::where('admin_name',$admin->admin_name)
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
