<?php
namespace App\Http\Controllers\CommitteeCustomize;

use App\Http\Controllers\Controller;

use App\Models\Committeeunit;
use App\Models\Committeeyear;
use Illuminate\Http\Request;
use App\Models\App;
use Illuminate\Support\Facades\validator;
use App\Models\Admin;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class CommitteeYearController extends Controller
{
    
    public function index(Request $request){
         $admin_name = $request->header('admin_name'); 
           $committeeunit=Committeeunit::where('admin_name',$admin_name)->where('unit_status',1)
             ->orderBy('id','desc')->get();
          if(isset($_GET['committeeunit_id'])){
                $committeeunit_id=Committeeunit::where('admin_name',$admin_name)->where('unit_status',1)
                 ->where('id',$_GET['committeeunit_id'])->first();  
             }else{
                 $committeeunit_id='';  
             }
            return view('committeecustomize.year',['committeeunit'=>$committeeunit, 
                   'committeeunit_id'=>$committeeunit_id]);    
      }
                  
          
        

    public function fetch(Request $request,$committeeunit_id){
        $admin_name = $request->header('admin_name'); 
        $data=Committeeyear::where('admin_name',$admin_name)
        ->where('committeeunit_id',$committeeunit_id)->orderBy('id','desc')->paginate(15);
         return view('committeecustomize.year_data',compact('data'));
     }


    public function store(Request $request){
         $admin_name = $request->header('admin_name'); 
          $validator=\Validator::make($request->all(),[  
              'committeeunit_id' => 'required',
              'year_name' => 'required',
            ],
        );
      
     if($validator->fails()){
           return response()->json([
             'status'=>400,
             'validate_err'=>$validator->messages(),
           ]);
     }else{
                $app= new Committeeyear;
                $app->year_name=$request->input('year_name');
                $app->committeeunit_id=$request->input('committeeunit_id');
                $app->year_status=$request->input('year_status');
                $app->year_status=0;
                $app->admin_name=$admin_name;
                $app->save();
               return response()->json([
                 'status'=>200,  
                  'message'=>'Inserted Data',
               ]);
         }
      }


        public function edit($id){
            $edit_value=Committeeyear::find($id);
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
           'year_name' => 'required',
        ]);

      if($validator->fails()){
        return response()->json([
          'status'=>400,
          'validate_err'=>$validator->messages(),
       ]);
      }else{
            $app=Committeeyear::find($id);
            if($app){
              $app->year_name=$request->input('year_name');
              $app->year_status=$request->input('year_status');
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
            $post = Committeeyear::find($id);  
            $post->delete();
               return response()->json([
                   'status'=>200,  
                    'message'=>'Deleted Data',
                 ]);
       }
    


    function fetch_data(Request $request,$committeeunit_id)
    {
     if($request->ajax())
     {

      $admin_name = $request->header('admin_name'); 
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype'); 
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
      $data = Committeeyear::where('admin_name',$admin_name)
             ->where('committeeunit_id',$committeeunit_id)
              ->where(function($query) use ($search) {
                  $query->orwhere('year_name', 'like', '%'.$search.'%');
                  $query->orWhere('year_status', 'like', '%'.$search.'%');
                  })
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(15);
                    return view('committeecustomize.year_data', compact('data'))->render();
                   
     }
    }
}
