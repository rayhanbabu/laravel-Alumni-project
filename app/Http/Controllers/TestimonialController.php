<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Homepage;
use App\Models\App;
use App\Models\Admin;
use App\Models\Maintain;
use App\Models\Magazine;
use App\Models\Notice;
use App\Models\expre;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Member;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;
use Exception;

class TestimonialController extends Controller
{
     public function index($member) {
         return view('admin.testimonial',['member'=>$member]);
     }

   public function store(Request $request){

    if(Session::has('admin')){
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
      $validator=\Validator::make($request->all(),[       
         'serial' => 'required',
         'name' => 'required',
         'category' => 'required',
         'workplace' => 'required',
         'image' => 'image|mimes:jpeg,png,jpg|max:512000',
      ]);

     if($request->input('category')=='Executive'){
         $count=$admin->executive_size;
     }else if($request->input('category')=='Senior'){
       $count=$admin->senior_size;
    }else if($request->input('category')=='Advisor'){
      $count=$admin->advisor_size;
     }else if($request->input('category')=='General'){
      $count=$admin->general_size;
     }

   if($validator->fails()){
    return response()->json([
      'status'=>700,
      'validate_err'=>$validator->messages(),
    ]);
  }else{
  
    $data= Testimonial::where('serial',$request->input('serial'))->where('category',$request->input('category'))
    ->where('admin_name',$admin->admin_name)->count('serial');
    $data1= Testimonial::where('admin_name',$admin->admin_name)->count('serial');
     if($data>=1){
         return response()->json([
              'status'=>600,
              'errors'=> 'Serial Number Already Exist',
         ]);  
      }else if($data1>=$admin->member_size){
          
         return response()->json([
             'status'=>500,
             'errors'=> 'Row Insert Permision is '.$admin->member_size. '. More Details Contact service Provider',
          ]);  
       }else{
      $testimonial= new Testimonial;
      $testimonial->serial=$request->input('serial');
      $testimonial->category=$request->input('category');
      $testimonial->admin_name=$admin->admin_name;
      $testimonial->name=$request->input('name');
      $testimonial->workplace=$request->input('workplace');
      $testimonial->current_address=$request->input('current_address');
      $testimonial->permanent_address=$request->input('permanent_address');
      $testimonial->blood=$request->input('blood');
      $testimonial->blood_status=$request->input('blood_status');
      $testimonial->phone=$request->input('phone');
      $testimonial->phone_status=$request->input('phone_status');
      $testimonial->email=$request->input('email');
      $testimonial->text1=$request->input('text1');
      $testimonial->email_status=$request->input('email_status');
      $testimonial->fb_link=$request->input('fb_link');
      $testimonial->verify_status=1;
    
       if($request->hasfile('image')){
        $file=$_FILES['image']['tmp_name'];
        $hw=getimagesize($file);
        $w=$hw[0];
        $h=$hw[1];	 
            if($w<310 && $h<310){
             $image= $request->file('image'); 
             $new_name = rand() . '.' . $image->getClientOriginalExtension();
             $image->move('uploads/admin', $new_name);
             $testimonial->image=$new_name;
          }else{
            return response()->json([
                'status'=>300,  
               'message'=>'Image size must be 300*300 ',
             ]);
            }
        }
       $testimonial->save();
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
    $admin=Session::get('admin');
    $data = Testimonial::where('category',$member)->where('admin_name',$admin->admin_name)->get();
      $output=' <h5 class="text-success"> Total Member : '.$data->count().' </h5>';	
    if ($data->count()> 0) {
       $output .= '<table class="table table-bordered table-sm text-start align-middle">
       <thead>
         <tr>
           <th>Serial Number</th>
           <th>Image</th>
           <th>Name</th>
           <th>Workplace</th>
           <th>Session</th>
           <th>Current Address</th>
           <th>Permanent Address</th>
           <th>Blood,Status </th>
           <th>Last Blood, Donate No </th>
           <th>Phone, E-mail </th>
           <th>Verify Status </th>
           <th>Action</th>
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
           <td>' . $row->serial . '</td>
           <td><img src="/uploads/admin/'. $row->image. '" width="70" class="img-thumbnail" alt="Image"></td>
           <td>' . $row->name .'</td>
           <td>' . $row->workplace. '</td>
           <td>' . $row->text2. '</td>
           <td>' . $row->current_address . '</td>
           <td>' . $row->permanent_address . '</td>
           <td>' . $row->blood .','. $row->blood_status .', '.$comment. '</td>
           <td>' . $row->blood_date .' ,'. $row->bloodno . '</td>
           <td>' . $row->phone .','. $row->phone_status .', '. $row->email .','. $row->email_status . '</td>
           <td>' . $row->verify_status. '</td>
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
  $data = Testimonial::find($id);
  return response()->json([
    'status'=>200,  
    'data'=>$data,
  ]);
}

public function update(Request $request ){
           
      
  $validator=\Validator::make($request->all(),[
             
    'serial' => 'required',
    'name' => 'required',
    'category' => 'required',
    'workplace' => 'required',
    'image' => 'image|mimes:jpeg,png,jpg|max:512000',
  ]);

if($validator->fails()){
 return response()->json([
   'status'=>700,
   'validate_err'=>$validator->messages(),
 ]);
}else{

  $testimonial=Testimonial::find($request->input('edit_id'));
  if($testimonial){
         $testimonial->serial=$request->input('serial');
         $testimonial->category=$request->input('category');
         $testimonial->name=$request->input('name');
         $testimonial->workplace=$request->input('workplace');
         $testimonial->current_address=$request->input('current_address');
         $testimonial->permanent_address=$request->input('permanent_address');
         $testimonial->blood=$request->input('blood');
         $testimonial->blood_status=$request->input('blood_status');
         $testimonial->phone=$request->input('phone');
         $testimonial->phone_status=$request->input('phone_status');
         $testimonial->email=$request->input('email');
         $testimonial->text1=$request->input('text1');
         $testimonial->email_status=$request->input('email_status');
         $testimonial->fb_link=$request->input('fb_link');
         $testimonial->verify_status=$request->input('verify_status');
         $testimonial->text2=$request->input('text2');
         $testimonial->bloodno=$request->input('bloodno');
         $testimonial->blood_date=$request->input('blood_date');
      if($request->hasfile('image')){
         $file=$_FILES['image']['tmp_name'];
         $hw=getimagesize($file);
         $w=$hw[0];
         $h=$hw[1];	 
            if($w<310 && $h<310){
             $path='uploads/admin/'.$testimonial->image;
             if(File::exists($path)){
              File::delete($path);
              }
             $image = $request->file('image');
             $new_name = rand() . '.' . $image->getClientOriginalExtension();
             $image->move('uploads/admin/', $new_name);
             $testimonial->image=$new_name;
             } 
             else{
             return response()->json([
                'status'=>200,  
                'message'=>'Image size must be 300*300 ',
              ]);
             } 
            }  
            $testimonial->update();   
       return response()->json([
           'status'=>400,
           'message'=>' Data  Updated'
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
  $testimonial=Testimonial::find($request->input('id'));
  $path='uploads/admin/'.$testimonial->image;
      if(File::exists($path)){
         File::delete($path);
      }
  $testimonial->delete();
  return response()->json([
     'status'=>200,  
     'message'=>'Deleted Data',
   ]);
}

 
  //website

    public function websearch() {
       return view('web.websearch');
     }

     
    function fetch_data(Request $request)
    {
     if($request->ajax())
     {
        $search = $request->get('search');
        $data = Admin::where('name', 'like', '%'.$search.'%')
                       ->orWhere('nameen', 'like', '%'.$search.'%')
                       ->orWhere('admin_name', 'like', '%'.$search.'%')
                       ->orWhere('address', 'like', '%'.$search.'%')
                       ->get();

     
    if ($data->count()> 0) {
       
       foreach ($data as $row) {
            $output= '<div class="col-md-4 my-3">
                  <div class="card shadow">
                  <div class="card-body">';

            $output.='
            <h5 class="card-text text-center">'.$row->name.'</h5>
            <p class="card-text text-center">'.$row->address.'</p>
                <div class="text-center">
            <a href="/' . $row->admin_name . '" class="btn btn-primary" >View Website<a>  
            ';

            $output .= ' </div> </div></div></div>';
           echo $output;
        }
     
       
    } else {
       echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
    }
                   
       }
    }


         public function webcontact() {
              return view('web.contact');
          }

    
       public function admin_name($admin_name) {
             $admin= Admin::where('admin_name',$admin_name)->select('id','name','nameen','address','email',
                     'mobile','admin_name','header_size','resheader_size')->first();
            if($admin){
                Cookie::queue('cook_user',$admin->admin_name,60/6); // 60 minutes
                return redirect('/');   
             }else{
                return redirect('/web/search');  
             }
           
       }


  

          public function apiusername($username){
                return response()->json(['username'=>$username]);
           }

          public function apihome($username){
                  $admin= Admin::where('admin_name',$username)->select('id','name','nameen','address','email',
                     'mobile','admin_name','header_size','resheader_size','text1','text2','text3')->first();
                  $slide = Magazine::where('category','Slide')->where('text4','Slide')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->get();
                  $slide1 = Magazine::where('category','Slide')->where('text4','Slide')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->first();
                  $welcome = Magazine::where('category','Welcome')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->get();
                  $test = Magazine::where('category','Testimonial')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->get();
                  $logu = Magazine::where('category','Slide')->where('text4','Logu')->where('admin_name',$admin->admin_name)->first();
                  $logu = Magazine::where('category','Slide')->where('text4','HeaderLogu')->where('admin_name',$admin->admin_name)->first();
                  

               $category=App::where('admin_name',$admin->admin_name)->where('admin_category','Member')->orderBy('id','asc')->get();

                     if($category[0]){
                        $count1=DB::table('members')->where('admin_name',$admin->admin_name)->where('member_verify',1)->where('category_id',$category[0]['id'])->count();
                        $row1=[
                           'category'=>$category[0]['category'],
                           'count'=>$count1
                        ];
                      }else{
                        $row1=[
                           'category'=>"NA",
                           'count'=>0
                         ];
                      }

                      if($category[1]){
                        $count2=DB::table('members')->where('admin_name',$admin->admin_name)->where('member_verify',1)->where('category_id',$category[1]['id'])->count();
                        $row2=[
                           'category'=>$category[1]['category'],
                           'count'=>$count2
                        ];
                      }else{
                        $row2=[
                           'category'=>"NA",
                           'count'=>0
                         ];
                      }


                      if($category[2]){
                        $count3=DB::table('members')->where('admin_name',$admin->admin_name)->where('member_verify',1)->where('category_id',$category[2]['id'])->count();
                        $row3=[
                           'category'=>$category[2]['category'],
                           'count'=>$count3
                        ];
                      }else{
                        $row3=[
                           'category'=>"NA",
                           'count'=>0
                         ];
                      }

                      if($category[3]){
                        $count4=DB::table('members')->where('admin_name',$admin->admin_name)->where('member_verify',1)->where('category_id',$category[3]['id'])->count();
                        $row4=[
                           'category'=>$category[3]['category'],
                           'count'=>$count4
                        ];
                      }else{
                        $row4=[
                           'category'=>"NA",
                           'count'=>0
                         ];
                      }


                     $homecount=[
                      'row1'=>$row1,
                      'row2'=>$row2,
                      'row3'=>$row3,
                      'row4'=>$row4,
                  ];

               
                   return response()->json([
                       'admin'=>$admin,'slide'=>$slide,'slide1'=>$slide1,
                       'welcome'=>$welcome,'test'=>$test,'logu'=>$logu,'homecount'=>$homecount
                   ]);

             }


             public function apinotice($username,$category) {
              $admin= Admin::where('admin_name',$username)->select('id','name','nameen','address','email',
                   'mobile','admin_name','header_size','resheader_size')->first();
              $data = Notice::where('admin_name',$admin->admin_name)->where('category',$category)->orderBy("id",'desc')->get();
              $logu = Magazine::where('category','Slide')->where('text4','HeaderLogu')->where('admin_name',$admin->admin_name)->first();
              
                 return response()->json([
                      'admin'=>$admin 
                      ,'logu'=>$logu
                      ,'data'=>$data
                      
                      
                  ]);
            }


        
     public function apimember(request $request ,$username,$category_id){
    
        $query=Member::query();
        if($search=$request->search){
           $query->whereRaw("name LIKE '%".$search."%'")
              ->orWhereRaw("email LIKE '%".$search."%'");
         }

         //if($sort=$request->sort){
         // $query->orderBy("member_card",$sort);}

          
        $perPage=$request->input('perPage',18);
        $page=$request->input('page',1);
       
        $query->leftjoin('apps','apps.id','=','members.category_id');

        $query->where('members.category_id',$category_id)->where('members.admin_name',$username)
            ->where('member_verify',1);

        $query->select('members.id','members.admin_name','category_id','name','email'
          ,'members.phone','degree_category','passing_year','profile_image','member_card'
          ,'gender','birth_date','blood','country','city','occupation','organization','designation'
          ,'blood_status','phone_status','email_status','fb_link','web_link','affiliation'
          ,'training','expertise','apps.category');

          $total=$query->count();
          $query->orderBy("serial", 'asc');
          $result=$query->offset(($page-1) * $perPage)->limit($perPage)->get();
        

        return response()->json([
          'message'=>"Successfully fetched",
          'data'=>$result, 
          'total'=>$total,
          'page'=>$page,
          'last_page'=>ceil($total/$perPage)
        ]);
    }


    public function apiviewmember(Request $request,$username) {
      $id = $request->id;
      $data = Member::leftjoin('apps','apps.id','=','members.category_id')
      ->where('members.id',$id)->where('members.admin_name',$username)
      ->where('member_verify',1)->orderBy('serial','asc')->
       select('members.id','members.admin_name','category_id','name','email','member_card'
           ,'members.phone','degree_category','passing_year','profile_image'
           ,'gender','birth_date','blood','country','city','occupation','organization','designation'
           ,'blood_status','phone_status','email_status','fb_link','web_link','affiliation'
           ,'training','expertise','apps.category','division_id','district_id'
           ,'upazilla_id','union_id','word_id','village','bn_name','mother_name'
           ,'father_name','nid','about_self')->get();
      return response()->json([
        'status'=>200,  
        'data'=>$data,
      ]);
    }

    public function apimembersearch(Request $request,$username) {
        $search = $request->get('search');
        $search = str_replace(" ", "%", $search);
        $data=Member::Where('admin_name',$username)->where('member_verify',1)->where(function($query) use ($search) {
          $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('phone', 'like', '%'.$search.'%')
            ->orWhere('member_card', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%');
       })->select('members.id','members.admin_name','category_id','name','email','member_card'
           ,'members.phone','degree_category','passing_year','profile_image'
           ,'gender','birth_date','blood','country','city','occupation','organization','designation'
           ,'blood_status','phone_status','email_status','fb_link','web_link','affiliation'
           ,'training','expertise')->orderBy('id','asc')->paginate(20);

       return response()->json([
        'status'=>200,  
        'data'=>$data,
      ]);
    }

    public function apimembercategory($username){
      $data= App::where('admin_name',$username)->where('admin_category','Member')
      ->where('status',1)->select('id','category')->get();
     
       return response()->json([
           'status'=>200,
            'data'=>$data 
      ]);
    }
    
    public function apimagazine($username,$category){
          $admin= Admin::where('admin_name',$username)->select('id','name','nameen','address','email',
                     'mobile','admin_name','header_size','resheader_size')->first();
          $data = Magazine::where('category',$category)->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->get();
          $logu = Magazine::where('category','Slide')->where('text4','HeaderLogu')->where('admin_name',$admin->admin_name)->first();
          
           return response()->json([
              'admin'=>$admin,
              'logu'=>$logu,
              'data'=>$data
              
          ]);
     }
    
    

    public function apiexpre($username) {
         $admin= Admin::where('admin_name',$username)->select('id','name','nameen','address','email',
              'mobile','admin_name','header_size','resheader_size')->first();
          $data1 = expre::where('category','President')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->get();
          $data2 = expre::where('category','Secretary')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->get();
          $logu = Magazine::where('category','Slide')->where('text4','Logu')->where('admin_name',$admin->admin_name)->first();
          
          return response()->json([
                  'admin'=>$admin 
                  ,'logu'=>$logu
                  ,'data1'=>$data1
                  ,'data2'=>$data2
                  
           ]);
    }


    public function apidivisions($username){
       $divisions = DB::table('divisions')->orderBy('id', 'asc')->get();
         return response()->json([
             'status'=>'success'
            ,'divisions'=>$divisions  
         ],200); 
     }

     public function apidistricts($username,$division_id){
      $districts = DB::table('districts')->where('division_id',$division_id)->orderBy('id', 'asc')->get();
        return response()->json([
            'status'=>'success'
            ,'districts'=>$districts  
        ],200); 
    }

    
    public function apiupazilas($username,$district_id){
      $upazilas = DB::table('upazilas')->where('district_id',$district_id)->orderBy('id', 'asc')->get();
        return response()->json([
            'status'=>'success'
            ,'upazilas'=>$upazilas  
        ],200); 
    }


    public function apiunions($username,$upazilla_id){
        $upazilas = DB::table('unions')->where('upazilla_id',$upazilla_id)->orderBy('id','asc')->get();
         return response()->json([
             'status'=>'success'
             ,'upazilas'=>$upazilas  
          ],200); 
     }



     public function apidu_homepage() {
        $data = Homepage::where('babu','DUCLUB')->first();
        return response()->json([
          'data'=>$data  
          ]);
     }



    
 

  


public function testimonial() {
   $lang=Lang::getLocale();

   $test=DB::select("select * from  
      testimonials where babu='1' AND lang='Null' OR  babu='1' AND lang='$lang'");
 
   prx($test);
    die();
    return response()->json([
        'status'=>200,  
        'testimonial'=>$test,
        'lang'=>Lang::getLocale(),
     ]);
}

   public function langhome() {
       $lang=Lang::getLocale();
       $test=DB::select("select * from  
       testimonials where babu='1' AND lang='Null' OR  babu='1' AND lang='$lang'");
        return view('admin.langhome',['test'=>$test]);
   }



}
