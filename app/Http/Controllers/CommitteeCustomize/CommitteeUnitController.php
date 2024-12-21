<?php
namespace App\Http\Controllers\CommitteeCustomize;

use App\Http\Controllers\Controller;

use App\Models\Committeeunit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use App\Models\Admin;
use DB;
use Yajra\DataTables\DataTables;


class CommitteeUnitController extends Controller
{

   public function index(Request $request){

      $admin_name = $request->header('admin_name'); 
    if ($request->ajax()) {
    
      $data = Committeeunit::where('admin_name',$admin_name)->latest()->get();
      return Datatables::of($data)
         ->addIndexColumn()
        ->addColumn('status', function($row){
          $statusBtn = $row->unit_status == '1' ? 
              '<button class="btn btn-success btn-sm">Active</button>' : 
              '<button class="btn btn-secondary btn-sm" >Inactive</button>';
          return $statusBtn;
        })
        ->addColumn('edit', function($row){
          $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
          return $btn;
      })
        ->addColumn('delete', function($row){
          $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
          return $btn;
      })
        ->rawColumns(['status','edit','delete'])
        ->make(true);
     }

        return view('committeecustomize.unit');  
    }


  
     public function store(Request $request){
         $admin_name = $request->header('admin_name'); 
         $admin= Admin::where('admin_name',$admin_name)->first();
         $validator=\Validator::make($request->all(),[  
          'unit_name' => 'required|unique:committeeunits,unit_name,NULL,id,admin_name,' . $admin_name,
          ]);

       if($validator->fails()){
            return response()->json([
              'status'=>400,
              'message'=>$validator->messages(),
           ]);
        }else{
                $app= new Committeeunit;
                $app->unit_name=$request->input('unit_name');
                $app->unit_status=1;
                $app->admin_name=$admin->admin_name;
                $app->save();
                return response()->json([
                 'status'=>200,  
                  'message'=>'Inserted Data',
                ]);
          }
      }


        public function edit($id){
            $edit_value=Committeeunit::find($id);
            if($edit_value){
               return response()->json([
                    'status'=>200,  
                    'value'=>$edit_value,
                  ]);
             }else{
                 return response()->json([
                    'status'=>404,  
                    'message'=>'Student not found',
                  ]);
             }
       }


     public function update(Request $request){
          $admin_name = $request->header('admin_name'); 
         $validator=\Validator::make($request->all(),[          
            'unit_name' => 'required|unique:committeeunits,unit_name,' . $request->input('edit_id') . 'NULL,id,admin_name,' . $admin_name,
            'unit_status' => 'required',
         ]);

     if($validator->fails()){
        return response()->json([
          'status'=>400,
          'message'=>$validator->messages(),
        ]);
      }else{
              $model=Committeeunit::find($request->input('edit_id'));
            if($model){
                 $model->unit_name=$request->input('unit_name');
                 $model->unit_status=$request->input('unit_status');
                 $model->update();   
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


     public function destroy(Request $request){
        $id=$request->id;
        $model=Committeeunit::find($id);
        $verify = DB::table('members')->where('committeeunit_id', $id)->where('admin_name', $model->admin_name)->count('id');
        if($verify > 0){
           return response()->json([
               'status'=>400,  
               'message'=>'Cannot delete this unit as it is assigned to members',
             ]);
        }else{
           $model->delete();
           return response()->json([
               'status'=>200,  
               'message'=>'Deleted Data',
             ]);
        }
      
    }
    

}
