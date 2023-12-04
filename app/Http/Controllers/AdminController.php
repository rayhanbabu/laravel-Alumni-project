<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use App\Exports\UserExport;
use App\Models\Member;
use Hash;
use PDF;
use Exception;
use App\Models\App;
use App\Models\Invoice;


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
            $data= Admin::find($admin->id);
        }
        return view('admin.dashboard',['admin'=>$data]); 
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



public function member($category_id){
      try {
      $status1=0;
      $status=1;
      if(Session::has('admin')){
        $admin=Session::get('admin');
        $category=DB::table('apps')->where('admin_name',$admin->admin_name)->where('admin_category','Member')
        ->where('id',$category_id)->first();
       if($category){
          $verify=DB::table('members')->where('category_id',$category_id)->where('admin_name',$admin->admin_name)->where('member_verify',$status)->count('id');
          $not_verify=DB::table('members')->where('category_id',$category_id)->where('admin_name',$admin->admin_name)->where('member_verify',$status1)->count('id');
          $email_verify=DB::table('members')->where('category_id',$category_id)->where('admin_name',$admin->admin_name)->where('member_verify',$status1)->count('id');
           return view('admin.member',['category'=>$category,'category_id'=>$category_id, 'verify'=>$verify, 'not_verify'=>$not_verify, 'email_verify'=>$email_verify]);
        }else{
          return "Something Error occurred";
       }
      }
     }catch (Exception $e) { return  'something Error';}
  }


  public function member_fetch($category_id){
     try {
      if(Session::has('admin')){
             $admin=Session::get('admin');
         }
       $data=Member::leftjoin('apps','apps.id','=','members.category_id')
       ->where('members.admin_name',$admin->admin_name)->Where('members.category_id',$category_id)
       ->select('apps.category','members.*')->orderBy('member_verify','asc')->paginate(10);
        return view('admin.member_data',compact('data'));
      }catch (Exception $e) { return  'something Error';}
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
              $data=Member::leftjoin('apps','apps.id','=','members.category_id')
              ->where('members.admin_name',$admin->admin_name)->Where('members.category_id',$request->category_id)
              ->where(function($query) use ($search) {
                 $query->where('members.phone', 'like', '%'.$search.'%')
                  ->orWhere('member_card', 'like', '%'.$search.'%')
                  ->orWhere('name', 'like', '%'.$search.'%')
                  ->orWhere('email', 'like', '%'.$search.'%');
              })->select('apps.category','members.*')->orderBy('member_verify','asc')->orderBy($sort_by, $sort_type)
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

            if(Session::has('admin')){
              $admin=Session::get('admin');
           }

            $validator=\Validator::make($request->all(),[    
                    'phone'=>'required|unique:members,phone,'.$request->input('edit_id'),
                    'email'=>'required|unique:members,email,'.$request->input('edit_id'),
                    'member_card'=>'required|unique:members,member_card,'.$request->input('edit_id'),
                    'member_card' => 'required|unique:members,member_card,'.$request->input('edit_id') . 'NULL,id,admin_name,' . $admin->admin_name,
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
                  $model->category_id=$request->input('category_id');  
                  $model->blood=$request->input('blood'); 
                  $model->member_card=$request->input('member_card'); 
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



          public function paymentview(){
            $data=APP::where('admin_name',Session::get('admin')->admin_name)->where('status',1)->orderBy('id', 'desc')->get();
             return view('admin.paymentview',['category'=>$data]);
          }

          public function fetch(){
            if(Session::has('admin')){
              $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
              $data=Invoice::leftjoin('members','members.id','=','invoices.member_id')
               ->leftjoin('apps','apps.id','=','invoices.category_id')
               ->where('invoices.admin_name',$admin->admin_name)
               ->select('members.member_card','members.name'
               ,'apps.category','invoices.*')->orderBy('invoices.id', 'desc')->paginate(10);
               return view('admin.paymentview_data',compact('data'));
            }
           }


           function fetch_data(Request $request)
           {
              if($request->ajax())
                {
                   $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
                   $sort_by = $request->get('sortby');
                   $sort_type = $request->get('sorttype');
                   $search = $request->get('search');
                   $search = str_replace(" ", "%", $search);
                   $data=Invoice::leftjoin('members','members.id','=','invoices.member_id')
                   ->leftjoin('apps','apps.id','=','invoices.category_id')
                   ->where('invoices.admin_name',$admin->admin_name)
                           ->where(function($query) use ($search) {
                             $query->orwhere('invoices.id', 'like', '%' . $search . '%');
                             $query->orwhere('members.member_card', 'like', '%' . $search . '%');
                             $query->orwhere('members.name', 'like', '%' . $search . '%');
                             $query->orwhere('apps.category', 'like', '%' . $search . '%');
                            })
                     ->select('members.member_card','members.name','apps.category','invoices.*')
                            ->orderBy($sort_by, $sort_type)->paginate(10);
                 return view('admin.paymentview_data', compact('data'))->render();
               }
             }





           public function payment_status(Request $request ){
                 $id=$request->id;
                 $invoice=Invoice::where('id',$id)->first();

                 if($invoice->payment_type=="Online"){
                    return response()->json([
                        'status'=>300,  
                        'message'=>"Online Payment Exist.Can Not Change Payment Status",
                      ]);

                 }else{
                 if($invoice->payment_status==0){
                     $status=1;
                     $payment_time=date('Y-m-d H:i:s');
                     $payment_type='Offline';
                     $payment_method='admin';

                 }else{
                      $status=0;
                      $payment_time=date('2010-10-10 10:10:10');
                      $payment_type='Offline';
                      $payment_method='';
                 }
                 $payment_date= date('Y-m-d');
                 $payment_day= date('d');
                 $payment_month= date('n');
                 $payment_year= date('Y');

                 $model=Invoice::find($id);
                 $model->payment_status=$status; 
                 $model->payment_type=$payment_type; 
                 $model->payment_time=$payment_time;
                 $model->payment_method=$payment_method; 
                 $model->payment_date=$payment_date; 
                 $model->payment_year=$payment_year; 
                 $model->payment_month=$payment_month;  
                 $model->payment_day=$payment_day; 
                 $model->update();
            
                 return response()->json([
                    'status'=>200,  
                    'message'=>"Payment Status Update Successfull",
                  ]);
                }
           }


           public function payment_delete(Request $request ){
               $id=$request->id;
               $email=$request->email;
               $invoice=Invoice::where('id',$id)->first();
               $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
               if($email==$admin->email){
                   if($invoice->payment_status==0){
                         $model=Invoice::find($id);
                         $model->delete();
                         return response()->json([
                            'status'=>200,  
                            'message'=>"Invoice delete Successfull",
                          ]);                         
                   }else{
                    return response()->json([
                        'status'=>300,  
                        'message'=>"Please Unpaid Payment Status",
                     ]);
                   } 
                }else{
                  return response()->json([
                       'status'=>400,  
                       'message'=>"Invalid Admin Email",
                    ]);
                 }
           }



    public function payment_category(Request $request){
    
      $month=date('n',strtotime($_POST['month']));
      $year=date('Y',strtotime($_POST['month']));
      $monthyear=$request->input('month');
      $category=$request->input('category');

      $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
      $category_name= App::where('id',$category)->first();

      if($_POST['month']){
        $invoice=Invoice::leftjoin('members','members.id','=','invoices.member_id')
         ->where('invoices.admin_name',$admin->admin_name)->where('invoices.category_id',$category)
         ->where('invoices.payment_month',$month)->where('invoices.payment_year',$year)->where('invoices.payment_status',1)
         ->select('members.member_card','members.name','invoices.*')->orderBy('member_card','asc')->get();
      }else{
       $invoice=Invoice::leftjoin('members','members.id','=','invoices.member_id')
         ->where('invoices.admin_name',$admin->admin_name)->where('invoices.category_id',$category)->where('invoices.payment_status',1)
         ->select('members.member_card','members.name','invoices.*')->orderBy('member_card','asc')->get();
      }
   
      $file='Invoice-'.$monthyear.'.pdf';

      $pdf = PDF::loadView('pdf.payment_category',[
        'title' => 'PDF Title',
        'author' => 'PDF Author',
        'margin_left' => 20,
        'margin_right' => 20,
        'margin_top' => 60,
        'margin_bottom' => 20,
        'margin_header' => 15,
        'margin_footer' => 10,
        'showImageErrors' => true,
        'invoice' => $invoice,
        'category_name' => $category_name,
        'monthyear' => $monthyear,
        'admin' => $admin,
    ]);

       return $pdf->stream($file.'.pdf');
  }


  public function dataview(Request $request){
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->get();
    return view('admin.dataview',['admin'=>$admin]);

  }

  public function dataedit(Request $request){
          
    $admin= Admin::find($request->input('id'));
   
    $admin->token1=$request->input('token1');
    $admin->token2=$request->input('token2');
    $admin->token3=$request->input('token3');
    $admin->token4=$request->input('token4');
    $admin->token5=$request->input('token5');
    $admin->token6=$request->input('token6');
   
    $admin->update();
    return redirect()->back()->with('success','Token Setup Update Successfuly');

  }


  public function member_export(Request $request)
  { 
         $admin_name=Session::get('admin')->admin_name;
         $category_id=$request->input('category_id');
        return (new UserExport($admin_name,$category_id))->download('Member_list.csv');   
  }













}
