<?php

namespace App\Http\Controllers;

 use App\Models\Magazine;
 use Illuminate\Http\Request;
 use App\Models\Testimonial;
 use App\Models\Text;
 use App\Models\Admin;
 use Illuminate\Support\Facades\File;
 use Illuminate\Support\Facades\validator;
 use Illuminate\Support\Collection;
 use Illuminate\Support\Facades\Lang;
 use Illuminate\Support\Facades\URL;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Session;
 use Illuminate\Support\Facades\Cookie;


class MagazineController extends Controller
{
    
     public function index($member){
         return view('admin.magazine',['member'=>$member]);
     }


     public function store(Request $request){
      if(Session::has('admin')){
       $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
        $validator=\Validator::make($request->all(),[                 
            'serial' => 'required',
            'title' => 'required',
            'category' => 'required',
            'text1' => 'required',
            'image' => 'mimes:jpeg,png,jpg,pdf|max:750',
         ]);

       


        $count=$admin->magazine_size;
      
       if($validator->fails()){
        return response()->json([
          'status'=>700,
          'validate_err'=>$validator->messages(),
        ]);

       }else{
        $data1= Magazine::where('category',$request->input('category'))
        ->where('admin_name',$admin->admin_name)->count('id');
         if($data1>=$count){
          
           return response()->json([
               'status'=>600,
               'errors'=> 'Row Insert Permision is '.$count. '. More Details Contact service Provider',
           ]); 
 
        }else{
          $model= new Magazine;
          $model->serial=$request->input('serial');
          $model->category=$request->input('category');
          $model->admin_name=$admin->admin_name;
          $model->name=$request->input('name');
          $model->workplace=$request->input('workplace');
          $model->title=$request->input('title');
          $model->text1=$request->input('text1');
          $model->text2=$request->input('text2');
          
          
        
           if($request->hasfile('image')){

            if($request->input('category')=='Link'){
              $image= $request->file('image'); 
              $new_name = rand() . '.' .$image->getClientOriginalExtension();
              $image->move(public_path('uploads/admin'),$new_name);
              $model->image=$new_name;
            }
           else if($request->input('category')=='Slide' OR $request->input('category')=='Gallery'){
              $file=$_FILES['image']['tmp_name'];
              $hw=getimagesize($file);
              $w=$hw[0];
              $h=$hw[1];	 
             // if($w<1930 && $h<1090){
                 $uploadedFile = $request->file('image');
                 $fileName = time() . '.' .$uploadedFile->getClientOriginalExtension();
                 $uploadedFile->move(public_path('uploads/admin'),$fileName);
                 $model->image=$fileName;
              // }else{
              //     return response()->json([
              //       'status'=>300,  
              //       'message'=>'Image size must be 1920*1080 ',
              //      ]);
              //     }

             $model->text4=$request->input('text4');
            }else{
            $file=$_FILES['image']['tmp_name'];
              $hw=getimagesize($file);
              $w=$hw[0];
              $h=$hw[1];	 
             // if($w<310 && $h<310){
                 $image= $request->file('image'); 
                 $new_name = rand() . '.' .$image->getClientOriginalExtension();
                 $image->move(public_path('uploads/admin'),$new_name);
                 $model->image=$new_name;
              // }else{
              //     return response()->json([
              //       'status'=>300,  
              //       'message'=>'Image size must be 300*300 ',
              //      ]);
              //   }

              }   

            }

           $model->save();
           return response()->json([
            'status'=>400,  
            'message'=>'Inserted Data',
          ]);
          
         
          }
    
      }

    }
   }


       public function fetchAll($member) {
        if(Session::has('admin')){
        $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
        $data = Magazine::where('category',$member)->where('admin_name',$admin->admin_name)->orderBy('serial','desc')->orderBy('id','asc')->get();
          $output=' <h5 class="text-success"> Total Row : '.$data->count().' </h5>';	
        if ($data->count()> 0 ) {
          if($member=='Link'){
            $output .= '<table class="table table-bordered table-sm text-start align-middle">
            <thead>
              <tr>
                 <th>Image/Pdf Link</th>
                 <th>Title</th>
                 <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($data as $row) {
                $output .= '<tr>
                <td> <a href="' . URL::to('uploads/admin/'.$row->image) . '" id="" > ' . URL::to('uploads/admin/'.$row->image)  . '  </a> </td>
                <td>' . $row->title . '</td>
                <td>
                <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
     
                <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
              </td>
          </tr>';
          }
            $output .= '</tbody></table>';
            echo $output;

          } else if($member=='Slide' || $member=='Gallery'){
              $output .= '<table class="table table-bordered table-sm text-start align-middle">
              <thead>
                <tr>
                  <th>Serial Number</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>';
              foreach ($data as $row) {
                  $output .= '<tr>
                  <td>' . $row->serial . '</td>
                  <td><img src="/uploads/admin/'. $row->image. '" width="70" class="img-thumbnail" alt="Image"></td>
                  <td>' . $row->title . '</td>
                  <td>' . $row->text4 . '</td>
                  <td>
                  <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
       
                  <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
            </tr>';
            }
              $output .= '</tbody></table>';
              echo $output;
            }else{
           $output .= '<table class="table table-bordered table-sm text-start align-middle">
           <thead>
             <tr>
               <th>Serial Number</th>
               <th>Image</th>
               <th>Title</th>
               <th>Text 1</th>
               <th>Text 2</th>
               <th>Name</th>
               <th>Workplace</th>
               <th>Action</th>
             </tr>
           </thead>
           <tbody>';
           foreach ($data as $row) {
               $output .= '<tr>
               <td>' . $row->serial . '</td>
               <td><img src="/uploads/admin/'. $row->image. '" width="70" class="img-thumbnail" alt="Image"></td>
               <td>' . $row->title . '</td>
               <td>' . $row->text1 . '</td>
               <td>' . $row->text2 . '</td>
               <td>' . $row->name .'</td>
               <td>' . $row->workplace. '</td>
              
               <td>
               <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
    
               <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
             </td>
         </tr>';
         }
           $output .= '</tbody></table>';
           echo $output;

        }


        } else {
           echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }

      }
    }
    
    
    public function edit(Request $request) {
      $id = $request->id;
      $data = Magazine::find($id);
      return response()->json([
        'status'=>200,  
        'data'=>$data,
      ]);
    }


    public function update(Request $request ){
           
      $validator=\Validator::make($request->all(),[
                 
             'serial' => 'required',
            'title' => 'required',
            'text1' => 'required',
            'image' => 'mimes:jpeg,png,jpg,pdf|max:716800',
      ]);
    
    if($validator->fails()){
     return response()->json([
       'status'=>700,
       'validate_err'=>$validator->messages(),
     ]);
    }else{
    
      $model=Magazine::find($request->input('edit_id'));
      if($model){
                $model->serial=$request->input('serial');
                $model->name=$request->input('name');
                $model->workplace=$request->input('workplace');
                $model->title=$request->input('title');
                $model->text1=$request->input('text1');
                $model->text2=$request->input('text2');
                 $model->text4=$request->input('text4');
          if($request->hasfile('image')){


            if($model->category=='Link'){

                   $filePath = public_path('uploads/admin') . '/' . $model->image;
                   if(File::exists($filePath)){
                        File::delete($filePath);
                    }
              $image= $request->file('image'); 
              $new_name = rand() . '.' .$image->getClientOriginalExtension();
              $image->move(public_path('uploads/admin'),$new_name);
              $model->image=$new_name;
            }
           else if($model->category=='Slide' || $model->category=='Gallery'){
            $file=$_FILES['image']['tmp_name'];
            $hw=getimagesize($file);
            $w=$hw[0];
            $h=$hw[1];	 
               //if($w<1930 && $h<1090){

                $filePath = public_path('uploads/admin') . '/' . $model->image;
                        if(File::exists($filePath)){
                           File::delete($filePath);
                          }
                   $uploadedFile = $request->file('image');
                   $fileName = time() . '.' .$uploadedFile->getClientOriginalExtension();
                   $uploadedFile->move(public_path('uploads/admin'),$fileName);
                   $model->image=$fileName;
                //} 
                // else{
                // return response()->json([
                //    'status'=>200,  
                //    'message'=>'Image size must be 1920*1080 ',
                //  ]);
                // } 

           }else{
             $file=$_FILES['image']['tmp_name'];
             $hw=getimagesize($file);
             $w=$hw[0];
             $h=$hw[1];	 
                //if($w<310 && $h<310){
                  $filePath = public_path('uploads/admin') . '/' . $model->image;
                   if(File::exists($filePath)){
                        File::delete($filePath);
                    }
                 $image = $request->file('image');
                 $new_name = rand() . '.' . $image->getClientOriginalExtension();
                 $image->move(public_path('uploads/admin'), $new_name);
                 $model->image=$new_name;
                //  } 
                //  else{
                //  return response()->json([
                //     'status'=>200,  
                //     'message'=>'Image size must be 300*300 ',
                //   ]);
                //  } 
             }

                }  
                $model->update();   
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
          $model=Magazine::find($request->input('id'));
          $filePath = public_path('uploads/admin') . '/' . $model->image;
             if(File::exists($filePath)){
                   File::delete($filePath);
              }
          $model->delete();
       return response()->json([
          'status'=>200,  
          'message'=>'Deleted Data',
       ]);
    }



    

   
  
}
