<?php

namespace App\Http\Controllers;

use App\Models\expre;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Collection;
use DB;
use Session;

class ExpreController extends Controller
{
    public function index() {
        return view('admin.expre');
    }

   public function store(Request $request){
  if(Session::has('admin')){
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
   
    $validator=\Validator::make($request->all(),[        
       'serial' => 'required',
       'name' => 'required',
       'image' => 'image|mimes:jpeg,png,jpg|max:512000',
    ]);

   if($validator->fails()){
     return response()->json([
        'status'=>700,
        'validate_err'=>$validator->messages(),
     ]);
   }else{
     
    $data= expre::where('admin_name',$admin->admin_name)->where('category',$request->input('category'))
    ->where('serial',$request->input('serial'))->count('id');
    if($data>=1){
      return response()->json([
          'status'=>600,
          'errors'=> 'Serial Number already exist',
     ]); 

    }else{
             $text= new expre;
             $text->admin_name=$admin->admin_name;
             $text->name=$request->input('name');
             $text->serial=$request->input('serial');
             $text->category=$request->input('category');
             $text->date1=$request->input('date1');
             $text->date2=$request->input('date2');
             if($request->hasfile('image')){
              $file=$_FILES['image']['tmp_name'];
              $hw=getimagesize($file);
              $w=$hw[0];
              $h=$hw[1];	 
                  if($w<310 && $h<310){
                   $image= $request->file('image'); 
                   $new_name = rand() . '.' . $image->getClientOriginalExtension();
                   $image->move('uploads/admin', $new_name);
                   $text->image=$new_name;
                }else{
                  return response()->json([
                      'status'=>300,  
                     'message'=>'Image size must be 300*300 ',
                   ]);
                  }
              }

             $text->save();

       return response()->json([
        'status'=>400,  
        'message'=>'Inserted Data',
      ]);
     }

    }
   }

   }




    
   public function fetchAll() {
    if(Session::has('admin')){
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
    $data = expre::where('admin_name',$admin->admin_name)->get();
    $output=' <h5 class="text-success"> Total Row : '.$data->count().' </h5>';	
    if ($data->count()> 0) {
       $output .= '<table class="table table-bordered table-sm text-start align-middle">
       <thead>
         <tr>
            <th>Serial No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category </th>
            <th>From date </th>
            <th>To date </th>
            <th>Action</th>
         </tr>
       </thead>
       <tbody>';
       foreach ($data as $row) {

       

           $output .= '<tr>
           <td>' . $row->serial . '</td>
           <td><img src="/uploads/admin/'. $row->image. '" width="70" class="img-thumbnail" alt="Image"></td>
           <td>' . $row->name . '</td>
           <td>' . $row->category . '</td>
           <td>' . $row->date1 . '</td>
           <td>' . $row->date2 . '</td>
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
}


public function edit(Request $request) {
  $id = $request->id;
  $data = expre::find($id);
  return response()->json([
    'status'=>200,  
    'data'=>$data,
  ]);
}

  public function update(Request $request){
           
    $validator=\Validator::make($request->all(),[        
      'serial' => 'required',
      'name' => 'required',
      'image' => 'image|mimes:jpeg,png,jpg|max:512000',
   ]);

  if($validator->fails()){
    return response()->json([
       'status'=>700,
       'validate_err'=>$validator->messages(),
    ]);
  }else{
      
    $text=expre::find($request->input('edit_id'));
    if($text){
        $text->name=$request->input('name');
        $text->serial=$request->input('serial');
        $text->category=$request->input('category');
        $text->date1=$request->input('date1');
        $text->date2=$request->input('date2');
        if($request->hasfile('image')){
          $file=$_FILES['image']['tmp_name'];
          $hw=getimagesize($file);
          $w=$hw[0];
          $h=$hw[1];	 
             if($w<310 && $h<310){
              $path='uploads/admin/'.$text->image;
              if(File::exists($path)){
               File::delete($path);
               }
              $image = $request->file('image');
              $new_name = rand() . '.' . $image->getClientOriginalExtension();
              $image->move('uploads/admin/', $new_name);
              $text->image=$new_name;
              } 
              else{
              return response()->json([
                 'status'=>200,  
                 'message'=>'Image size must be 300*300 ',
               ]);
              } 
             }  
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

    }


  public function delete(Request $request) {
    $text=expre::find($request->input('id'));
    $path='uploads/admin/'.$text->image;
    if(File::exists($path)){
         File::delete($path);
    }
    $text->delete();
    return response()->json([
       'status'=>200,  
       'message'=>'Deleted Data',
     ]);
   }


}
