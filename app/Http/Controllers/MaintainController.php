<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Maintain;
use App\Models\Admin;
use App\Models\Onlinepayment;
use App\Models\Withdraw;
use Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Helpers\MaintainJWTToken;
use Illuminate\Support\Str;
use Exception;

class MaintainController extends Controller
{
   public function login(Request $request)
   {
      try{
          return view('maintain.login'); 
        }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
   }

   public function login_insert(Request $request){
        $validator=\Validator::make($request->all(),[    
           'phone'=>'required',
           'password'=>'required',
         ],
         [
           'phone.required'=>'Phone is required',
           'password.required'=>'Password is required',
         ]);

        if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]); 
       }else{
        $status=1;
        $username=Maintain::where('phone',$request->phone)->first();
        if($username){
                 if($username->maintain_password==$request->password){
                    if($username->status==$status){
                          $rand=rand(11111,99999);
                          DB::update("update maintains set login_code ='$rand' where phone = '$username->phone'");
                         // SendEmail($username->email,"Maintain Otp code","One Time OTP Code",$rand,"ANCOVA");  
                          return response()->json([
                               'status'=>200,
                               'phone'=>$username->phone,
                               'email'=>$username->email,
                           ]);               
                     }else{
                        return response()->json([
                           'status'=>600,
                           'message'=> 'Acount Inactive',
                        ]); 
                     }    
                 }else{
                   return response()->json([
                      'status'=>400,
                      'message'=> 'Invalid Password',
                   ]); 
                 }
        }else{
             return response()->json([
                 'status'=>300,
                 'message'=> 'Invalid Phone Number',
             ]); 
         }
    }
      //Email($maintain->email,"Maintain Otp code","One Time OTP Code",$otp,"Dining Name");  
        
  }


  public function login_verify(Request $request){
   $validator=\Validator::make($request->all(),[    
       'otp'=>'required|numeric',
      ],
       [
       'otp.required'=>'OTP is required',
      ]);

     if($validator->fails()){
          return response()->json([
            'status'=>700,
            'message'=>$validator->messages(),
         ]);
  }else{
     $username=Maintain::where('phone',$request->verify_phone)->where('email',$request->verify_email)
     ->where('login_code',$request->otp)->first();
     if($username){
            DB::update("update maintains set login_code ='null' where phone = '$username->phone'");
            $alumni_maintain=MaintainJWTToken::CreateToken($username->maintain_username,$username->email,
            $username->id,$username->role,$username->phone);
            Cookie::queue('alumni_maintain',$alumni_maintain, 60 * 96);
            return response()->json([
              'status'=>200,
              'message'=> 'success',
           ]);   
     }else{
         return response()->json([
             'status'=>300,
             'message'=> "Invalid OTP",
          ]); 
      }
 }
     
}




    function dashboard(Request $request){
          $maintain_id=$request->input('maintain_id');
          $maintain=DB::table('maintains')->where('id',$maintain_id)->first();
          return view('maintain.dashboard',['maintain'=>$maintain]); 
        // return $dashboard->name ;
     }


    public function logout(){
        if(Session::has('maintain')){
            Session::pull('maintain');
           return redirect('maintain/login');
        }
    }


    function password(){
        if(Session::has('maintain')){
            $maintain=Session::get('maintain');
       }
       return view('maintain.password',['maintain'=>$maintain]); 
        //return 'rayhan';
    }

    
  
  function passwordedit(Request $request)
    {
        $email=$request->input('email');
        $n_pass=$request->input('n_pass');
        $c_pass=$request->input('c_pass');
        if(Session::has('maintain')){
            $maintain=Session::get('maintain');
         }
         if($email==$maintain->email){
            if($n_pass==$c_pass){

             $password= Maintain::find($maintain->id);
             //$password->password=Hash::make($npass);
              $password->maintain_password=$n_pass;
              $password->update();
              return redirect('/maintain/password')->with('success','Passsword change  successfully');
            }else{
            return back()->with('fail','New Password and Confirm Password does not match');
         }
        }else{
         return back()->with('fail','Invalid E-mail');
    }
         
    }

    public function forget(){
        return view('maintain.forget');
       }


       public function forgetemail(request $request){
   
        $email=$request->input('email');
        $rand=rand(11111,99999);
        $email_exist=Maintain::where('email',$email)->count('email');
       if($email_exist>=1){
           DB::update(
              "update maintains set forget_code ='$rand' where email = '$email'"
            );
           

                $subject='Maintain Verification Code';  
                $title='Hi ';
                $body='Your one time recovery code';
                $link='';
                $name='ANCOVA';  
                $details = [
                 'subject' => $subject,
                 'title' => $title,
                 'otp_code' => $rand,
                 'link' => $link,
                 'body' => $body,
                 'name' => $name,
                ];
                Mail::to($email)->send(new \App\Mail\ForgetMail($details));


           return response()->json([
              'status'=>500,
              'errors'=> 'Email exist',
           ]); 
        }else{
            return response()->json([
              'status'=>600,
              'errors'=> 'Invalid  Email ',
           ]); 
        }   
  }   



  public function forgetcode(request $request){
        
    $email_id=$request->input('email_id');
    $forget_code=$request->input('forget_code');
    $code_exist=Maintain::where('email',$email_id)->where('forget_code',$forget_code)->count('email');
    if($code_exist>=1){ 
         return response()->json([
            'status'=>500,
            'errors'=> 'valid code',
         ]); 
    }else{
        return response()->json([
          'status'=>600,
          'errors'=> 'Invalid  Code',
       ]); 
    }   
}


public function confirmpass(request $request){
    
    $email_id_pass=$request->input('email_id_pass');
    $npass=$request->input('npass');
    $cpass=$request->input('cpass');
    //$password=Hash::make($npass);
    $password=$npass;
   
     if($npass == $cpass){
       DB::update(
          "update maintains set maintain_password ='$password' where email = '$email_id_pass'"
        );
         return response()->json([
            'status'=>500,
            'errors'=> 'valid code',
         ]); 

    }else{
        return response()->json([
           'status'=>600,
           'errors'=> 'New password & Confirm password Does not match',
       ]); 
    }   
}


public function adminview(){
     $admin=Admin::get();
     return view('maintain.admin',['admin'=>$admin]);
}

public function admininsert(request $request){

    $validated = $request->validate([
        'mobile' => 'required|unique:admins|max:255',
        'email' => 'required|unique:admins|max:255',
        'admin_name' => 'required|unique:admins|max:255',
    ]);

     $create_date=date("Y-m-d");
     $subscribe=3;
     $payment_duration=1;
     $payment=1000;
     $expired_date=date("Y-m-d",strtotime($create_date.$subscribe."month"));  // Server month hobe

     $admin= new Admin;
     $admin->name=$request->input('name');
     $admin->nameen=$request->input('nameen');
     $admin->address=$request->input('address');
     $admin->email=$request->input('email');
     $admin->email2=md5($request->input('email'));
     $admin->mobile=$request->input('mobile');
     $admin->admin_name=$request->input('admin_name');
     $admin->admin_password=$request->input('admin_password');
     $admin->role=$request->input('role');
     $admin->email_verify=0;
     $admin->payment=$payment;
     $admin->created_date=$create_date;
     $admin->expired_date=$expired_date;
     $admin->payment_duration=$payment_duration;
     $admin->subscribe= $subscribe;
     $admin->version_type=$request->input('version_type');
     $admin->save();
           
   return redirect()->back()->with('success','Admin Added Successfuly');

}

   public function webinsert(request $request){
             
        $validator=\Validator::make($request->all(),[  
            'name' => 'required',
            'nameen' => 'required',
            'address' => 'required',
            'password' => 'required|min:6|max:12',
            'username' => 'required|unique:admins,admin_name',
            'mobile' => 'required|unique:admins,mobile',
            'email' => 'required|unique:admins,email',
         ],
            [
                'name.required'=>'Organization name(Bangla) is required',
                'nameen.required'=>'Organization name(English) is required',
           ]
        );  

         if($validator->fails()){
            return response()->json([
              'status'=>400,
              'validate_err'=>$validator->messages(),
            ]);

        }else if($request->input('password')!=$request->input('password1')){
            return response()->json([
                'status'=>300,
                'password_match'=>'Password & Confirm Password Not Match',
              ]);

        }else{

            $maintain=Maintain::where('role','admin')->first();

            $create_date=date("Y-m-d");
            $subscribe=$maintain->subscribe;
            $payment_duration=$maintain->payment_duration;
            $payment=$maintain->payment;
            $expired_date=date("Y-m-d",strtotime($create_date.$subscribe."day"));  // Server month hobe

            $admin= new Admin;
            $admin->name=$request->input('name');
            $admin->nameen=$request->input('nameen');
            $admin->address=$request->input('address');
            $admin->email=$request->input('email');
            $admin->email2=md5($request->input('email'));
            $admin->mobile=$request->input('mobile');
            $admin->admin_name=$request->input('username');
            $admin->admin_password=$request->input('password');
            $admin->role='Admin';
            $admin->email_verify=0;
            $admin->payment=$payment;
            $admin->created_date=$create_date;
            $admin->expired_date=$expired_date;
            $admin->payment_duration=$payment_duration;
            $admin->subscribe= $subscribe;
            $admin->version_type=$maintain->version_type;
            $admin->magazine_size=$maintain->magazine_size;
            $admin->advisor_size=$maintain->advisor_size;
            $admin->blood_size=$maintain->blood_size;
            $admin->member_size=$maintain->member_size;
            $admin->header_size=$maintain->header_size;
            $admin->resheader_size=$maintain->resheader_size;
            $admin->executive_size=$maintain->executive_size;
            $admin->senior_size=$maintain->senior_size;
            $admin->general_size=$maintain->general_size;
            $admin->notice_size=$maintain->notice_size;
            $admin->welcome_size=$maintain->welcome_size;
            $admin->testimonial_size=$maintain->testimonial_size;
            $admin->slide_size=$maintain->slide_size;
            $admin->version_type='free';
            $admin->save();


             $model= new Onlinepayment;
             $model->admin_name=$request->input('username');
             $model->des1='Website Renew';
             $model->amount1=$payment;
             $model->payment=$payment;
             $model->subscribe=$subscribe;
             $model->payment_duration=$payment_duration;
             $model->created_date=$create_date;
             $model->expired_date=$expired_date;                    
             $model->save();

            $email=$request->input('email');
            $rand=rand(11111,99999);
            $subject='verify your Email ';  
            $title='Dear,  '.$request->input('nameen');
            $body='Please Click URL and verify your email to complete your account setup.';
            $link=URL::to('email_verify/'.md5($request->input('email')));
            $body1='Alternatively, paste the following URL into your browser:';
            $name='ancovabd.com , developed by ANCOVA';  
            $details = [
             'subject'=> $subject,
             'title'=>$title,
             'otp_code'=>$rand,
             'link'=>$link,
             'body'=>$body,
             'body1'=>$body1,
             'name'=>$name,
            ];
            Mail::to($email)->send(new \App\Mail\RegMail($details));

            return response()->json([
                'status'=>100,  
                'message'=>'Registration Successfull.Please Verify your E-mail.',
              ]);
        }  


   }

   public function email_verify($email2){
    $data=Admin::where('email2',$email2)->first();
   if($data){
    if($data->email_verify==1){
            return redirect('admin/login')->with('success','E-mial already verified'); 
       }else{
           $rand=1;
           DB::update(
            "update admins set email_verify ='$rand' where email2 = '$email2'"
           );
       
       $email=$data->email;
       $rand=rand(11111,99999);
       $subject='Mail by amderthikana.com ';  
       $title='Hi '.$data->name;
       $body='E-mail Verify Successfull. <br> Please wait account verify';
       $link='Website URL Link : https://amaderthikana.com/'.$data->admin_name.'<br>
       Admin  URL Link : https://amaderthikana.com/admin/login<br>
       UserName : '.$data->admin_name.'<br>
       Password : '.$data->admin_password.'<br>';

       $name='amderthikana.com ,<br> developed by ANCOVA <br>Phone:01750360044';  
       $details = [
        'subject' => $subject,
        'title' => $title,
        'otp_code' =>$rand,
        'link' => $link,
        'body' => $body,
        'name' => $name,
       ];
       Mail::to($email)->send(new \App\Mail\MailVerify($details));

       return  redirect('admin/login')->with('success','E-mail verified.Waiting for Account  verification');
       
      }

    
    }else{
            return redirect('admin/login')->with('fail','E-mial does not match');
         }



 }   





public function adminedit(request $request){

     $validated = $request->validate([
          'mobile' => 'required|unique:admins,mobile,'.$request->input('id'),
          'email' => 'required|unique:admins,mobile,'.$request->input('id'),
          'admin_name' => 'required|unique:admins,admin_name,'.$request->input('id'),
      ]);

    $admin= Admin::find($request->input('id'));
    $admin->name=$request->input('name');
    $admin->nameen=$request->input('nameen');
    $admin->address=$request->input('address');
    $admin->email=$request->input('email');
    $admin->mobile=$request->input('mobile');
    $admin->admin_password=$request->input('admin_password');
    $admin->role=$request->input('role');
    $admin->payment=$request->input('payment');
    $admin->header_size=$request->input('header_size');
    $admin->resheader_size=$request->input('resheader_size');
    $admin->magazine_size=$request->input('magazine_size');
    $admin->blood_size=$request->input('blood_size');
    $admin->member_size=$request->input('member_size');
    $admin->advisor_size=$request->input('advisor_size');
    $admin->fb_link=$request->input('fb_link');
    $admin->youtube_link=$request->input('youtube_link');
    $admin->other_link=$request->input('other_link');
    $admin->text1=$request->input('text1');
    $admin->text2=$request->input('text2');
    $admin->text3=$request->input('text3');
    $admin->text4=$request->input('text4');
    $admin->version_type=$request->input('version_type');
    $admin->executive_size=$request->input('executive_size');
    $admin->senior_size=$request->input('senior_size');
    $admin->general_size=$request->input('general_size');
    $admin->notice_size=$request->input('notice_size');
    $admin->welcome_size=$request->input('welcome_size');
    $admin->testimonial_size=$request->input('testimonial_size');
    $admin->slide_size=$request->input('slide_size');
    $admin->getway_fee=$request->input('getway_fee');
    $admin->bank_name=$request->input('bank_name');
    $admin->bank_account=$request->input('bank_account');
    $admin->bank_account_name=$request->input('bank_account_name');
    $admin->bank_route=$request->input('bank_route');
    $admin->updated_by=maintain_access()->maintain_name;
    $admin->updated_by_time=date('Y-m-d H:i:s');
    $admin->admin_login_email=$request->input('admin_login_email');
    $admin->address_phone=$request->input('address_phone');
    $admin->address_email=$request->input('address_email');
    $admin->update();
    return redirect()->back()->with('success','Admin Update Successfuly');
}

public function admindelete($id){
    $admin=Admin::find($id);
    $admin->delete();
    return redirect()->back()->with('success','Admin Deleted Successfuly');
}

public function adminstatus($type,$status,$id){

    if($status=='deactive'){
        $status0=0;
      }else{
       //$type=md5(1);
         $status0=1;
      }
      if($type=='email_verify'){
         DB::update(
            "update admins set email_verify ='$status0' where id = '$id'"
            );  
      }else if($type=='status'){
        DB::update(
            "update admins set status ='$status0' where id = '$id'"
           );  
      }
     
       return back()->with('success','Status Successful'); 
    }
   

      public function dataview(Request $request){
          $maintain=Maintain::get();
          return view('maintain.dataview',['maintain'=>$maintain]);
       }

      public function dataedit(Request $request){
              
        $admin= Maintain::find($request->input('id'));
        $admin->payment=$request->input('payment');
        $admin->payment_duration=$request->input('payment_duration');
        $admin->subscribe=$request->input('subscribe');
        $admin->header_size=$request->input('header_size');
        $admin->resheader_size=$request->input('resheader_size');
        $admin->magazine_size=$request->input('magazine_size');
        $admin->blood_size=$request->input('blood_size');
        $admin->member_size=$request->input('member_size');
        $admin->advisor_size=$request->input('advisor_size');
        $admin->fb_link=$request->input('fb_link');
        $admin->youtube_link=$request->input('youtube_link');
        $admin->other_link=$request->input('other_link');
        $admin->text1=$request->input('text1');
        $admin->text2=$request->input('text2');
        $admin->text3=$request->input('text3');
        $admin->text4=$request->input('text4');
        $admin->version_type=$request->input('version_type');
        $admin->executive_size=$request->input('executive_size');
        $admin->senior_size=$request->input('senior_size');
        $admin->general_size=$request->input('general_size');
        $admin->notice_size=$request->input('notice_size');
        $admin->welcome_size=$request->input('welcome_size');
        $admin->testimonial_size=$request->input('testimonial_size');
        $admin->slide_size=$request->input('slide_size');
        $admin->text2=$request->input('text2');
       
        $admin->store_id=$request->input('store_id');
        $admin->store_password=$request->input('store_password');
        $admin->currency=$request->input('currency');
        $admin->success_url=$request->input('success_url');
        $admin->fail_url=$request->input('fail_url');
        $admin->cancel_url=$request->input('cancel_url');
        $admin->init_url=$request->input('init_url');
        $admin->ipn_url=$request->input('ipn_url');

        $admin->update();
        return redirect()->back()->with('success','Maintain Update Successfuly');

      }

       

      public function reg(Request $request){
      
        return view('web.reg');

      }



    public function adminpdf(Request $request){
          $invoice=$request->input('invoice');
          $file='Payment_'.$invoice.'.pdf';
          $admin=Admin::get();

         $pdf = PDF::loadView('pdf.adminpdf',[
            'title' => 'PDF Title',
            'author' => 'PDF Author',
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 60,
            'margin_bottom' => 20,
            'margin_header' => 15,
            'margin_footer' => 10,
            'showImageErrors' => true,
            'admin' => $admin,
        ]);

        return $pdf->stream('pdf-file.pdf');
            //return $pdf->download('pdf-file.pdf');
         }

       


      public function adminexportview(){
         return view('maintain.adminexport');
      }
         


    public function adminexport(Request $request){
        $status=$request->input('status');
        return (new UserExport($status))->download('invoices.csv');   
    }

    public function adminimportview(){

        return view('maintain.adminimport');
    }

    public function adminimport(Request $request){
           
          //  Excel::Import(new UserImport, request()->file('file'));
          Excel::import(new UsersImport,request()->file('file'));
                
          return back()->with('status','Import Successful'); 
      }
      
      


      public function withdraw_index(){
           $admin= Admin::all();
           return view('maintain.withdraw',['admin'=>$admin]);
       }

  public function withdraw_fetch(){
        $data=Withdraw::orderBy('id', 'desc')->paginate(15);
          return view('maintain.withdraw_data',compact('data'));
      
   }



   function withdraw_fetch_data(Request $request,$admin_category)
   {
   if($request->ajax())
   {
    
    $sort_by = $request->get('sortby');
    $sort_type = $request->get('sorttype'); 
          $search = $request->get('search');
          $search = str_replace(" ", "%", $search);
    $data = Withdraw::where(function($query) use ($search) {
                $query->orwhere('admin_name', 'like', '%'.$search.'%');
                $query->orWhere('bank_account', 'like', '%'.$search.'%');
                $query->orWhere('bank_name', 'like', '%'.$search.'%');
                $query->orWhere('bank_info', 'like', '%'.$search.'%');
                })->orderBy($sort_by, $sort_type)->paginate(15);
         return view('maintain.app_data', compact('data'))->render();          
      }

  }


  public function withdraw_status($operator,$status,$id){
    
    if($operator=='status'){  
         if($status=='deactive'){
                $type=0;
                $payment_time=date('2010-10-10 10:10:10');
                $payment_type='';
           }else{
                $type=1;
                $payment_time=date('Y-m-d H:i:s');
                $payment_type=maintain_access()->maintain_name;
           }

           $payment_month= date('n');
           $payment_year= date('Y');

           $model=Withdraw::find($id);
           $model->withdraw_status=$type; 
           $model->withdraw_type=$payment_type; 
           $model->withdraw_time=$payment_time;
           $model->withdraw_year=$payment_year; 
           $model->withdraw_month=$payment_month;
           $model->updated_by=maintain_access()->maintain_name;
           $model->updated_by_time=date('Y-m-d H:i:s');  
           $model->update();

         return back()->with('success','Status update Successfull');        
      }
      else if($operator=='verify'){
           if($status=='deactive'){
                $type=0;
           }else{
                $type=1;
            }
         return back()->with('success','Status update Successfull');     
            
    }else{ return back()->with('fail','Something Rong');}


      //}catch (Exception $e) { return  'something is Rong'; }
    }


    public function withdraw_update(Request $request)
    {

       $validated = $request->validate([
            'image' =>'image|mimes:jpeg,png,jpg|max:512000',
            'withdraw_info'=>'required',
        ]);

       $model = Withdraw::find($request->input('id'));
       $model->withdraw_info=$request->input('withdraw_info');
       $model->withdraw_info_update="Admin";
       $model->updated_by=maintain_access()->maintain_name;
       $model->updated_by_time=date('Y-m-d H:i:s');

       if($request->hasfile('image')){
           $path=public_path('uploads/admin/').$model->image;
           if(File::exists($path)){
            File::delete($path);
            }
            $image= $request->file('image');
            $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin'), $file_name);
            $model->image=$file_name;
        }
       $model->save();

       return redirect()->back()->with('success','Data Updated Successfuly');
  }



   
  public function maintainview() {
    return view('maintain.maintainview');
 }


public function store(Request $request){
$validator=\Validator::make($request->all(),[    
   'name'=>'required',
   'phone'=>'required|unique:maintains,phone',
   'email'=>'required|unique:maintains,email',
   'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
   'image' => 'image|mimes:jpeg,png,jpg|max:400',
  ],
   [
    'password.regex'=>'password minimum six characters including one uppercase letter, 
     one lowercase letter and one number '
  ]);
if($validator->fails()){
    return response()->json([
      'status'=>700,
      'message'=>$validator->messages(),
   ]);
}else{           
   $model= new Maintain;
   $model->role='Maintain';
   $model->status=1;
   $model->maintain_password=$request->input('password');
   $model->name=$request->input('name');
   $model->maintain_name=Str::slug(substr($request->input('name'),0,8),'_');
   $model->email=$request->input('email');
   $model->phone=$request->input('phone');
   if($request->hasfile('image')){
      $imgfile='maintain-';
      $size = $request->file('image')->getsize(); 
      $file=$_FILES['image']['tmp_name'];
      $hw=getimagesize($file);
      $w=$hw[0];
      $h=$hw[1];	 
          if($w<310 && $h<310){
           $image= $request->file('image'); 
           $new_name = $imgfile.rand() . '.' . $image->getClientOriginalExtension();
           $image->move(public_path('uploads'), $new_name);
           $model->image=$new_name;
              }else{
                return response()->json([
                   'status'=>300,  
                   'message'=>'Image size must be 300*300px',
                 ]);
              }
      }
     $model->save();
        return response()->json([
          'status'=>200,  
          'message'=>'Data Added Successfull',
       ]);       
   }
}



public function fetchAll() {

$data= maintain::where('role','maintain')->get();


$output = '';
if ($data->count()> 0) {
$output.=' <h5 class="text-success"> Total Row : '.$data->count().' </h5>';	
 $output .= '<table class="table table-bordered table-sm text-start align-middle">
 <thead>
    <tr>
      <th>Image </th>
      <th>Name </th>
      <th>Phone </th>
      <th>Email </th>
      <th>Passsword </th>
      <th>Status </th>
      <th>Action </th>
    </tr>
 </thead>
 <tbody>';
 foreach ($data as $row){
  if(!$row->image){$image="";}else{$image='<i class="fa fa-download"></i>';}
  if($row->status==1){
   $status='<a href="#"class="btn btn-success btn-sm">Active</a>';
  }else{  $status='<a href="#"class="btn btn-danger btn-sm">Inactive</a>';}
  
   $output .= '<tr>
      <td> <a href=/uploads/'.$row->image.' download id="' . $row->id . '" class="text-success mx-1">'.$image.' </a></td>
      <td>'.$row->name.'</td>
      <td>'.$row->phone.'</td>
      <td>'.$row->email.'</td>
      <td>'.$row->maintain_password.'</td>
      <td>'.$status.'</td>
       <td>
          <a href="#" id="' . $row->id . '"class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i>Edit</a>
          <a href="#" id="' .$row->id . '"class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i>Delete</a>
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
$data = Maintain::find($id);
return response()->json([
  'status'=>200,  
  'data'=>$data,
 ]);
}


public function update(Request $request ){
$validator=\Validator::make($request->all(),[    
'name'=>'required',
'phone'=>'required|unique:maintains,phone,'.$request->input('edit_id'),
'email'=>'required|unique:maintains,email,'.$request->input('edit_id'),
'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
'image' => 'image|mimes:jpeg,png,jpg|max:400',
],
[
 'password.regex'=>'password minimum six characters including one uppercase letter, 
  one lowercase letter and one number '
]);

if($validator->fails()){
   return response()->json([
     'status'=>700,
     'message'=>$validator->messages(),
  ]);
}else{
$model=Maintain::find($request->input('edit_id'));
if($model){
$model->maintain_password=$request->input('password');
$model->name=$request->input('name');
$model->maintain_name=Str::slug(substr($request->input('name'),0,8),'_');
$model->email=$request->input('email');
$model->phone=$request->input('phone');
$model->status=$request->input('status');

$model->issue_view=$request->input('issue_view');
$model->issue_edit=$request->input('issue_edit');
$model->payment_view=$request->input('payment_view');
$model->payment_edit=$request->input('payment_edit');
$model->admin_view=$request->input('admin_view');
$model->admin_edit=$request->input('admin_edit');

  if($request->hasfile('image')){
    $imgfile='maintain-';
    $size = $request->file('image')->getsize(); 
    $file=$_FILES['image']['tmp_name'];
    $hw=getimagesize($file);
    $w=$hw[0];
    $h=$hw[1];	 
         if($w<310 && $h<310){
           $path=public_path('uploads/'.$model->image);
            if(File::exists($path)){
                File::delete($path);
             }
          $image = $request->file('image');
          $new_name = $imgfile.rand() . '.' . $image->getClientOriginalExtension();
          $image->move(public_path('uploads'), $new_name);
          $model->image=$new_name;
         }else{
           return response()->json([
               'status'=>300,  
              'message'=>'Image size must be 300*300px',
            ]);
           }
       }
  
    $model->update();   
      return response()->json([
         'status'=>200,
         'message'=>'Data Updated Successfull'
      ]);

   } 
}
}


public function delete(Request $request) { 
   $model=Maintain::find($request->input('id'));
   $path=public_path('uploads/'.$model->image);
   if(File::exists($path)){
         File::delete($path);
    }
    $model->delete();
    return response()->json([
       'status'=>200,  
       'message'=>'Data Deleted Successfully',
   ]);

}  




    
        
         
    
}
