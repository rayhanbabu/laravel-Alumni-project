<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Maintain;
use App\Models\Admin;
use App\Models\Onlinepayment;
use DB;
use Hash;
use Session;
use PDF;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class MaintainController extends Controller
{
    function loginview(){
        return view('maintain.login');
    }



    public function login(Request $request){
        $request->validate([
            'maintain_name'=>'required',
            'maintain_password'=>'required',
       ]);

       $maintain=DB::table('maintains')->where('maintain_name','=',$request->maintain_name)->first();
       if($maintain){
        if($request->maintain_password==$maintain->maintain_password){
            $request->session()->put('maintain',$maintain);
            return redirect('/maintain/dashboard');
        }else{
            return back()->with('fail','Incorrect Password');
        }
     }else{
        return back()->with('fail','Incorrect Username');
     }

    }

    function dashboard(){
        if(Session::has('maintain')){
            $maintain=Session::get('maintain');
        }
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

            $maintain=Maintain::first();

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
    $admin->admin_name=$request->input('admin_name');
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
    
        
         
    
}
