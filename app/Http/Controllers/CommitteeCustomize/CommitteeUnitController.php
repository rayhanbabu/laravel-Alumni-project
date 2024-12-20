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
             'unit_name' => 'required',
          ]);

       if($validator->fails()){
            return response()->json([
              'status'=>400,
              'validate_err'=>$validator->messages(),
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
         $validator=\Validator::make($request->all(),[          
            'unit_name' => 'required',
            'unit_status' => 'required',
         ]);

     if($validator->fails()){
        return response()->json([
          'status'=>400,
          'validate_err'=>$validator->messages(),
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


     public function destroy($id){
        $notice=Committeeunit::find($id);
        $notice->delete();
        return response()->json([
           'status'=>200,  
           'message'=>'Deleted Data',
         ]);
    }
    

}
