<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;
use App\Models\App;
use Illuminate\Support\Facades\validator;
use App\Models\Admin;
use DB;
use Illuminate\Support\Facades\Session;

class CommitteeController extends Controller
{
    
    public function index($admin_category){
           $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
           $committee=App::where('admin_name',$admin->admin_name)->where('admin_category',$admin_category)
             ->orderBy('id','desc')->get();
          if(isset($_GET['committee_id'])){
                $committee_id=App::where('admin_name',$admin->admin_name)->where('admin_category',$admin_category)
                 ->where('id',$_GET['committee_id'])->first();  
             }else{
                 $committee_id='';  
             }
            return view('admin.committee',['admin_category'=>$admin_category,'committee'=>$committee, 
                   'committee_id'=>$committee_id]);    
      }
                  
          
        

    public function fetch($admin_category,$committee_id){
      if(Session::has('admin')){
        $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
        $data=Committee::where('admin_name',$admin->admin_name)->where('category',$admin_category)
        ->where('committee_id',$committee_id)->orderBy('id','desc')->paginate(15);
         return view('admin.committee_data',compact('data'));
      }
     }


    public function store(Request $request){
      if(Session::has('admin')){
          $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
          $validator=\Validator::make($request->all(),[  
             'category' => 'required',
             'name' => 'required',
             'committee_id' => 'required',
           ],
       );
      
     if($validator->fails()){
           return response()->json([
             'status'=>400,
             'validate_err'=>$validator->messages(),
           ]);
     }else{
                $app= new Committee;
                $app->name=$request->input('name');
                $app->status=$request->input('status');
                $app->category=$request->input('category');
                $app->committee_id=$request->input('committee_id');
                $app->designation=$request->input('designation');
                $app->link=$request->input('link');
                $app->serial=$request->input('serial');
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
            $edit_value=Committee::find($id);
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
          'name' => 'required',
          'designation' => 'required',
        ]);

      if($validator->fails()){
        return response()->json([
          'status'=>400,
          'validate_err'=>$validator->messages(),
       ]);
      }else{
            $app=Committee::find($id);
            if($app){
              $app->name=$request->input('name');
              $app->status=$request->input('status');
              $app->designation=$request->input('designation');
              $app->link=$request->input('link');
              $app->serial=$request->input('serial');
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
          $notice=Committee::find($id);
          $notice->delete();
          return response()->json([
             'status'=>200,  
             'message'=>'Deleted Data',
           ]);
      }
    


    function fetch_data(Request $request,$admin_category,$committee_id)
    {
     if($request->ajax())
     {
      $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
     
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype'); 
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
      $data = Committee::where('admin_name',$admin->admin_name)->where('category',$admin_category)
             ->where('committee_id',$committee_id)
              ->where(function($query) use ($search) {
                  $query->orwhere('name', 'like', '%'.$search.'%');
                  $query->orWhere('designation', 'like', '%'.$search.'%');
                  $query->orWhere('serial', 'like', '%'.$search.'%');
                  })
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(15);
                    return view('admin.committee_data', compact('data'))->render();
                   
     }
    }



}
