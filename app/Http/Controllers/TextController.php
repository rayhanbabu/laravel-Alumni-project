<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;
use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Collection;
use App\Models\Testimonial;
use App\Models\Member;
use DB;
use Session;

class TextController extends Controller
{
    
    public function index() {
        return view('admin.text');
    }

   public function store(Request $request){
      $admin_name = $request->header('admin_name'); 
      $admin = Admin::where('admin_name', $admin_name)->first();
   
    $validator=\Validator::make($request->all(),[
             
      'blood' => 'required',
      'name' => 'required',
      'phone' => 'required',
      'workplace' => 'required',
 ]);

   if($validator->fails()){
     return response()->json([
       'status'=>700,
       'validate_err'=>$validator->messages(),
   ]);
   }else{
     
    $data= Text::where('admin_name',$admin->admin_name)->where('phone',$request->input('phone'))->count('id');
    $data1= Text::where('admin_name',$admin->admin_name)->count('id');
    if($data>=1){
      return response()->json([
          'status'=>600,
          'errors'=> 'Phone number already exist',
     ]); 

    }else if($data1>=$admin->blood_size){  
      return response()->json([
        'status'=>600,
        'errors'=> 'Row Insert Permision is '.$admin->blood_size. '. More Details Contact service Provider',
     ]);

    }else{
             $text= new Text;
             $text->admin_name=$admin->admin_name;
             $text->name=$request->input('name');
             $text->workplace=$request->input('workplace');
             $text->current_address=$request->input('current_address');
             $text->permanent_address=$request->input('permanent_address');
             $text->blood=$request->input('blood');
             $text->phone=$request->input('phone');

             $text->save();

       return response()->json([
        'status'=>400,  
        'message'=>'Inserted Data',
      ]);
     }

     }

   }




    
   public function fetchAll(Request $request) {
      $admin_name = $request->header('admin_name'); 
      $admin = Admin::where('admin_name', $admin_name)->first();
    $data = Text::where('admin_name',$admin->admin_name)->get();
    $output=' <h5 class="text-success"> Total Row : '.$data->count().' </h5>';	
    if ($data->count()> 0) {
       $output .= '<table class="table table-bordered table-sm text-start align-middle">
       <thead>
         <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Blood </th>
            <th>Last Blood Donate date</th>
            <th>Blood Status</th>
            <th>Donate Blood </th>
            <th>Current Address</th>
            <th>Permanent Address</th>
            <th>WorkPlace </th>
            <th>Action</th>
         </tr>
       </thead>
       <tbody>';
       foreach ($data as $row) {

        if(empty($row->blood_date)){
          $comment='<a href="#"class="btn btn-info btn-sm">No_Comment</a>';
     }else if(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d",strtotime($row->blood_date)))>10540800){
          $comment='<a href="#"class="btn btn-success btn-sm">Available</a>';
     }else{
           $comment='<a href="#"class="btn btn-danger btn-sm">Waiting</a>';
      }

           $output .= '<tr>
           <td>' . $row->name . '</td>
           <td>' . $row->phone . '</td>
           <td>' . $row->blood . '</td>
           <td>' . $row->blood_date . '</td>
           <td>' . $comment . '</td>
           <td>' . $row->bloodno .' Bag'. '</td>
           <td>' . $row->current_address .'</td>
           <td>' . $row->permanent_address. '</td>
           <td>' . $row->workplace . '</td>
           <td>
           <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

           <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
         </td>
     </tr>';
     }
       $output .= '</tbody></table>';
       echo $output;
    } else {
       echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
    }
   
  }


public function edit(Request $request) {
  $id = $request->id;
  $data = Text::find($id);
  return response()->json([
    'status'=>200,  
    'data'=>$data,
  ]);
}

public function update(Request $request){
           
      
  $text=Text::find($request->input('edit_id'));
   if($text){
      $text->name=$request->input('name');
      $text->workplace=$request->input('workplace');
      $text->current_address=$request->input('current_address');
      $text->permanent_address=$request->input('permanent_address');
      $text->blood=$request->input('blood');
      $text->phone=$request->input('phone');
      $text->blood_date=$request->input('blood_date');
      $text->bloodno=$request->input('bloodno');
      $text->update();
         
      return response()->json([
          'status'=>400,
        'message'=>'Data Updated'
      ]);
  }else{
      return response()->json([
          'status'=>404,  
          'message'=>'Student not found',
        ]);
  }
}


public function delete(Request $request) {
  $text=Text::find($request->input('id'));
  $text->delete();
  return response()->json([
     'status'=>200,  
     'message'=>'Deleted Data',
   ]);
}


public function bloodsearch() {
  return view('admin.bloodsearch');
}

public function bloodsearchview(Request $request) {
    $admin_name = $request->header('admin_name'); 
    $admin = Admin::where('admin_name', $admin_name)->first();
     $data = Member::where('admin_name',$admin->admin_name)->where('blood',$request->input('blood1'))->get();
    $output='';	
    if ($data->count()> 0) {
       $output .= '<table class="table table-bordered table-sm text-start align-middle">
       <thead>
         <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Blood </th>
            <th>Email </th>
            <th>Country</th>
            <th>City</th>
        
          
         </tr>
       </thead>
       <tbody>';
       foreach ($data as $row) {
           if(empty($row->blood_date)){
                $comment='<a href="#"class="btn btn-info btn-sm">NA</a>';
           }else if(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d",strtotime($row->blood_date)))>10540800){
                $comment='<a href="#"class="btn btn-success btn-sm">Available</a>';
           }else{
                 $comment='<a href="#"class="btn btn-danger btn-sm">Waiting</a>';
            }

           $output .= '<tr>
               <td>' . $row->name . '</td>
               <td>' . $row->phone . '</td>
               <td>' . $row->blood . '</td>
               <td>' . $row->email . '</td>
               <td>' . $row->country . '</td>
               <td>' . $row->city. '</td>
              
       </tr>';
     }
       $output .= '</tbody></table>';
       echo $output;
    } else {
       echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
    }
  }

  }
