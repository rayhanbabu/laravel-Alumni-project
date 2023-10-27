<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use App\Models\Member;
use Hash;
use Exception;


class AdminController extends Controller
{
    function loginview(){
        return view('admin.login');
    }

    public function login(Request $request){
          $request->validate([
              'admin_name'=>'required',
              'admin_password'=>'required',
          ]);
       $status=1;
       $admin=DB::table('admins')->where('admin_name','=',$request->admin_name)->first();
       if($admin){
        if($request->admin_password==$admin->admin_password){
        if($admin->email_verify==$status){
            if($admin->status==$status){
                 $request->session()->put('admin',$admin);
                 return redirect('/admin/dashboard');
             }else{
                 return back()->with('fail','Waiting for account verification');
             }
             }else{
                return back()->with('fail','Invalid E-mail.Send URL your mail. Please Click and Verify E-mail');
             } 
        }else{
            return back()->with('fail','Incorrect Password');
        }
     }else{
        return back()->with('fail','Incorrect Username');
     }

}

    function dashboard(){
        if(Session::has('admin')){
            $admin=Session::get('admin');
        }
        return view('admin.dashboard',['admin'=>$admin]); 
    }


    public function logout(){
        if(Session::has('admin')){
            Session::pull('admin');
            return redirect('admin/login');
        }
     }

     
    function password(){
        if(Session::has('admin')){
            $admin=Session::get('admin');
       }
       return view('admin.password',['admin'=>$admin]); 
        //return 'rayhan';
    }

    function passwordedit(Request $request)
    {

        $request->validate([
            'email'=>'required',
            'n_pass'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'c_pass'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ],[
            'n_pass.regex'=>'password minimum six characters including one uppercase 
            letter, one lowercase letter and one number ',
           'c_pass.regex'=>'password minimum six characters including one uppercase letter, one 
                     lowercase letter and one number '     
        ]);

        $email=$request->input('email');
        $n_pass=$request->input('n_pass');
        $c_pass=$request->input('c_pass');
        if(Session::has('admin')){
            $admin=Session::get('admin');
         }
         if($email==$admin->email){
            if($n_pass==$c_pass){

             $password= Admin::find($admin->id);
             //$password->password=Hash::make($npass);
              $password->admin_password=$n_pass;
              $password->update();
              return redirect('/admin/password')->with('success','Passsword change  successfully');
            }else{
            return back()->with('fail','New Password and Confirm Password does not match');
         }
        }else{
         return back()->with('fail','Invalid E-mail');
         }
         
    }


    public function forget(){
        return view('admin.forget');
       }


       public function forgetemail(request $request){
   
        $email=$request->input('email');
        $rand=rand(11111,99999);
        $email_exist=Admin::where('email',$email)->count('email');
       if($email_exist>=1){
           DB::update(
              "update admins set forget_code ='$rand' where email = '$email'"
            );


            $subject='Admin E-mail Recovary Code';  
            $title='Hi ';
            $body='Your one time recovery code';
            $link='';
            $name='amaderthikana.com ';  
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
    $code_exist=Admin::where('email',$email_id)->where('forget_code',$forget_code)->count('email');
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
          "update admins set admin_password ='$password' where email = '$email_id_pass'"
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



public function member($category){
      try {
      $status1=0;
      $status=1;
      if(Session::has('admin')){
        $admin=Session::get('admin');
    }
      $verify=DB::table('members')->where('category',$category)->where('admin_name',$admin->admin_name)->where('member_verify',$status)->count('id');
      $not_verify=DB::table('members')->where('category',$category)->where('admin_name',$admin->admin_name)->where('member_verify',$status1)->count('id');
      $email_verify=DB::table('members')->where('category',$category)->where('admin_name',$admin->admin_name)->where('member_verify',$status1)->count('id');
      return view('admin.member',['category'=>$category, 'verify'=>$verify, 'not_verify'=>$not_verify, 'email_verify'=>$email_verify]);

     }catch (Exception $e) { return  'something Error';}
  }


  public function member_fetch($category){
  
      if(Session::has('admin')){
             $admin=Session::get('admin');
         }
       $data=Member::where('admin_name',$admin->admin_name)->Where('category',$category)->orderBy('member_verify','asc')->paginate(10);
        return view('admin.member_data',compact('data'));
  }





  public function memberstatus($operator,$status,$id){
    
      if($operator=='email'){
             if($status=='deactive'){
                  $type=0;
             }else{
                 $type=1;
             }
            DB::update("update members set email_verify ='$type' where id = '$id'");  
           return back()->with('success','Email Verify update Successfull');      
  
      }else if($operator=='status'){  
           if($status=='deactive'){
                  $type=0;
             }else{
                  $type=1;
             }
          DB::update( "update members set status ='$type' where id = '$id'" );  
           return back()->with('success','Status update Successfull');        
        }
        else if($operator=='verify'){
             if($status=='deactive'){
                  $type=0;
             }else{
                  $type=1;
              }
           DB::update( "update members set member_verify ='$type' where id = '$id'" );  
             return back()->with('success','Status update Successfull');     
              
          }else{ return back()->with('fail','Something Rong');}
  
  
        //}catch (Exception $e) { return  'something is Rong'; }
      }


      function member_fetch_data(Request $request)
      {
      
        if(Session::has('admin')){
            $admin=Session::get('admin');
        }

       if($request->ajax())
         {
        $sort_by = $request->get('sortby');
        $sort_type = $request->get('sorttype'); 
              $search = $request->get('search');
              $search = str_replace(" ", "%", $search);
              $data=Member::Where('admin_name',$admin->admin_name)->Where('category',$request->category)->where(function($query) use ($search) {
                 $query->where('phone', 'like', '%'.$search.'%')
                  ->orWhere('member_card', 'like', '%'.$search.'%')
                  ->orWhere('name', 'like', '%'.$search.'%')
                  ->orWhere('email', 'like', '%'.$search.'%');
              })->orderBy($sort_by, $sort_type)
                      ->paginate(10);
                       return view('admin.member_data', compact('data'))->render();        
             }
        }


        public function member_view($id){ 
            $value=Member::find($id);
           if($value){
               return response()->json([
                     'status'=>200,  
                     'value'=>$value,
                 ]);
             }else{
                 return response()->json([
                      'status'=>404,  
                      'message'=>'Member not found',
                  ]);
              }
          }
     


        public function member_delete(Request $request, $id) {
            $member=Member::find($id);
            $path=public_path('uploads/admin/').$member->profile_image;
                if(File::exists($path)){
                   File::delete($path);
                }

                $path=public_path('uploads/admin/').$member->certificate_image;
                if(File::exists($path)){
                   File::delete($path);
                }     
            $member->delete();
            return back()->with('success','Data Delete Successfull');     
          }



          public function member_update(Request $request ){
            $validator=\Validator::make($request->all(),[    
                    'phone'=>'required|unique:members,phone,'.$request->input('edit_id'),
                    'email'=>'required|unique:members,email,'.$request->input('edit_id'),
                    'serial'=>'required'
             ],
             [
                     'phone.required'=>'Phone number is required',
                     'email.required'=>'Email is required',
                     'dureg.required'=>'Registration is required',
                     'dureg.unique'=>'Registration number already exist',
             ]);
             
          if($validator->fails()){
                 return response()->json([
                    'status'=>400,
                    'validate_err'=>$validator->messages(),
                 ]);
          }else{
              $model=Member::find($request->input('edit_id'));
              if($model){
                  $model->phone=$request->input('phone');
                  $model->email=$request->input('email');
                  $model->serial=$request->input('serial');
                  $model->category=$request->input('category');  
                  $model->blood=$request->input('blood'); 
                  $model->designation=$request->input('designation'); 
                  $model->email_status=$request->input('email_status');
                  $model->phone_status=$request->input('phone_status');
                  $model->blood_status=$request->input('blood_status');
                  $model->update();   
                  return response()->json([
                     'status'=>200,
                     'message'=>' Updated Successfull'
                 ]);
               }else{
                  return response()->json([
                     'status'=>404,  
                     'message'=>'Student not found',
                  ]);
              }
             }
          }
  











}
