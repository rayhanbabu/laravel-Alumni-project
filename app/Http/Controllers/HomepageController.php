<?php

namespace App\Http\Controllers;

use App\Models\Homepage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomepageController extends Controller
{

     public function index() {
          return view('maintain.homepage');
     }


   public function store(Request $request){
    $data= Homepage::where('serial',$request->input('serial'))->where('babu',$request->input('babu'))->count('serial');
    if($data>=1){
      return response()->json([
          'status'=>600,
          'errors'=> 'Incorrect du Or Phone number',
     ]);  
    }else{
    if($request->hasfile('image')){ 
        $size = $request->file('image')->getsize(); 
        $file=$_FILES['image']['tmp_name'];
        $hw=getimagesize($file);
        $w=$hw[0];
        $h=$hw[1];	 
           if($size<819200){
           // if($w<520 && $h<520){
             $image= $request->file('image'); 
             $new_name = rand() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('uploads/admin'), $new_name);
             $homepage= new Homepage;
             $homepage->serial=$request->input('serial');
             $homepage->babu=$request->input('babu');
             $homepage->name=$request->input('name');
             $homepage->text=$request->input('text');
             $homepage->desig=$request->input('desig');
             $homepage->link1=$request->input('link1');
             $homepage->link2=$request->input('link2');
             $homepage->link3=$request->input('link3');
             $homepage->image=$new_name;
             $homepage->save();
               return response()->json([
                  'status'=>400,  
                  'message'=>'Data Inserted',
               ]);

         // }else{
         //   return response()->json([
          //      'status'=>300,  
          //     'message'=>'Image size 300*300 KB',
          //   ]);
           // }
         }else{
             return response()->json([
             'status'=>200,  
             'message'=>'Image Size geather than 500',
           ]);
         }
     }
      else{
             $homepage= new Homepage;
             $homepage->serial=$request->input('serial');
             $homepage->babu=$request->input('babu');
             $homepage->name=$request->input('name');
             $homepage->text=$request->input('text');
             $homepage->desig=$request->input('desig');
             $homepage->link1=$request->input('link1');
             $homepage->link2=$request->input('link2');
             $homepage->link3=$request->input('link3');
             $homepage->save();

       return response()->json([
        'status'=>400,  
        'message'=>'Inserted Data',
      ]);
     }

    }
   }




    
   public function fetchAll() {
    //$data = Testimonial::where('babu',1)->get();
    $data = Homepage::get();
    $output = '';
    if ($data->count()> 0) {
       $output .= '<table class="table table-bordered table-sm text-start align-middle">
       <thead>
         <tr>
           <th>ID</th>
           <th>Category</th>
           <th>Image</th>
           <th>Name</th>
           <th >Designation/Title</th>
           <th width="40%" >Description</th>
           <th>Link 1</th>
           <th>Link 2</th>
           <th>Link 3</th>
           <th>Action</th>
         </tr>
       </thead>
       <tbody>';
       foreach ($data as $row) {
           $output .= '<tr>
           <td>' . $row->serial . '</td>
           <td>' . $row->babu . '</td>
           <td><img src="/uploads/admin/'. $row->image. '" width="70" class="img-thumbnail" alt="Image"></td>
           <td>' . $row->name .'</td>
           <td>' . $row->desig. '</td>
           <td>' . $row->text . '</td>
           <td>' . $row->link1 . '</td>
           <td>' . $row->link2 . '</td>
           <td>' . $row->link3 . '</td>
           <td>
           <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i>Edit</a>

           <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i>Delete</a>
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
  $data = Homepage::find($id);
  return response()->json([
    'status'=>200,  
    'data'=>$data,
  ]);
}

public function update(Request $request ){
           
      
  $homepage=Homepage::find($request->input('edit_id'));
  if($homepage){
             $homepage->serial=$request->input('serial');
             $homepage->babu=$request->input('babu');
             $homepage->name=$request->input('name');
             $homepage->text=$request->input('text');
             $homepage->desig=$request->input('desig');
             $homepage->link1=$request->input('link1');
             $homepage->link2=$request->input('link2');
             $homepage->link3=$request->input('link3');
      if($request->hasfile('image')){
       $size = $request->file('image')->getsize(); 
             if($size<819200){
             $path=public_path('/uploads/admin/').$homepage->image;
             if(File::exists($path)){
              File::delete($path);
              }
             $image = $request->file('image');
             $new_name = rand() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('uploads/admin'), $new_name);
             $homepage->image=$new_name;
             } 
             else{
             return response()->json([
                'status'=>200,  
                'message'=>'Image Size geather than 500',
              ]);
             } 
            }  
            $homepage->update();   
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
    $homepage=Homepage::find($request->input('id'));
    $destination=public_path('uploads/admin/').$homepage->image;
        if(File::exists($destination)){
          File::delete($destination);
        }
    $homepage->delete(); 
    return response()->json([
       'status'=>200,  
       'message'=>'Deleted Data',
    ]);
   }







   public function homepage(Request $request){

       $HeaderText=Homepage::where('babu','HeaderText')->orderBy('serial','asc')->get();
       $HeaderImage=Homepage::where('babu','HeaderImage')->orderBy('serial','asc')->first();
       $Client=Homepage::where('babu','Client')->orderBy('serial','asc')->first();
       $FooterContact=Homepage::where('babu','FooterContact')->orderBy('serial','asc')->first();
       $FooterLink1=Homepage::where('babu','FooterLink1')->orderBy('serial','asc')->first();
       $FooterLink2=Homepage::where('babu','FooterLink2')->orderBy('serial','asc')->first();
          return view('home.index',['HeaderText'=>$HeaderText,'HeaderImage'=>$HeaderImage,'Client'=>$Client
               ,'FooterContact'=>$FooterContact,'FooterLink1'=>$FooterLink1,'FooterLink2'=>$FooterLink2]);
   }


   public function policy(Request $request){
          $policy=Homepage::where('babu','Policy')->orderBy('serial','asc')->get();
          $FooterContact=Homepage::where('babu','FooterContact')->orderBy('serial','asc')->first();
          $FooterLink1=Homepage::where('babu','FooterLink1')->orderBy('serial','asc')->first();
          $FooterLink2=Homepage::where('babu','FooterLink2')->orderBy('serial','asc')->first();

          return view('home.policy',['policy'=>$policy ,'FooterContact'=>$FooterContact,
                     'FooterLink1'=>$FooterLink1,'FooterLink2'=>$FooterLink2]);
     }


     public function term(Request $request){
        $term=Homepage::where('babu','Term')->orderBy('serial','asc')->get();
        $FooterContact=Homepage::where('babu','FooterContact')->orderBy('serial','asc')->first();
        $FooterLink1=Homepage::where('babu','FooterLink1')->orderBy('serial','asc')->first();
        $FooterLink2=Homepage::where('babu','FooterLink2')->orderBy('serial','asc')->first();

        return view('home.term',['term'=>$term ,'FooterContact'=>$FooterContact,
                   'FooterLink1'=>$FooterLink1,'FooterLink2'=>$FooterLink2]);
   }


   public function refund(Request $request){
      $term=Homepage::where('babu','Refund')->orderBy('serial','asc')->get();
      $FooterContact=Homepage::where('babu','FooterContact')->orderBy('serial','asc')->first();
      $FooterLink1=Homepage::where('babu','FooterLink1')->orderBy('serial','asc')->first();
      $FooterLink2=Homepage::where('babu','FooterLink2')->orderBy('serial','asc')->first();

       return view('home.refund',['term'=>$term ,'FooterContact'=>$FooterContact,
               'FooterLink1'=>$FooterLink1,'FooterLink2'=>$FooterLink2]);
  }



   public function cancel(Request $request){
       $cancel=Homepage::where('babu','Cancel')->orderBy('serial','asc')->get();
       $FooterContact=Homepage::where('babu','FooterContact')->orderBy('serial','asc')->first();
       $FooterLink1=Homepage::where('babu','FooterLink1')->orderBy('serial','asc')->first();
       $FooterLink2=Homepage::where('babu','FooterLink2')->orderBy('serial','asc')->first();

       return view('home.cancel',['cancel'=>$cancel ,'FooterContact'=>$FooterContact,
             'FooterLink1'=>$FooterLink1,'FooterLink2'=>$FooterLink2]);
   }



   public function du_term(Request $request){
     $du_term=Homepage::where('babu','TermDu')->orderBy('serial','asc')->get();
         return response()->json([
           'status'=>'success',  
            'data'=>$du_term,
         ]);
      }


    public function du_privacy(Request $request){
         $du_term=Homepage::where('babu','PolicyDu')->orderBy('serial','asc')->get();
           return response()->json([
             'status'=>'success',  
              'data'=>$du_term,
           ]);
       }






}
