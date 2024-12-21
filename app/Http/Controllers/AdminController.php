<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;
use App\Exports\UserExport;
use App\Exports\NonMemberExport;
use App\Models\Member;
use App\Helpers\AlumniJWTToken;
use Hash;
use PDF;
use Exception;
use App\Models\App;
use App\Models\Donormember;
use App\Models\Donorwithdraw;
use App\Models\Invoice;
use App\Models\Nonmember;
use App\Models\Withdraw;
use Illuminate\Support\Str;


class AdminController extends Controller
{
  public function login(Request $request)
    {
        try {
            return view('admin.login');
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }

    public function login_insert(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'phone' => 'required',
                'password' => 'required',
            ],
            [
                'phone.required' => 'Phone is required',
                'password.required' => 'Password is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {

            $username = Admin::where('mobile', $request->phone)->first();
            $status = 1;
            if ($username) {
                if ($username->admin_password == $request->password) {
                    if ($username->status == $status) {
                         $rand = rand(11111, 99999);
                         DB::update("update admins set login_code ='$rand' where mobile ='$username->mobile'");
                        if($username->admin_login_email==1){
                          SendEmail($username->email, "Admin Otp code", "One Time OTP Code", $rand, "ANCOVA");
                         }
                         return response()->json([
                             'status' => 200,
                             'phone' => $username->mobile,
                             'email' => $username->email,
                         ]);
                    } else {
                        return response()->json([
                            'status' => 600,
                            'message' => 'Acount Inactive',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid Phone Number or Password',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => 'Invalid Phone Number or Password',
                ]);
            }
        }
    }


    public function login_verify(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'otp' => 'required|numeric',
            ],
            [
                'otp.required' => 'OTP is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $username = Admin::where('mobile', $request->verify_phone)->where('email', $request->verify_email)
                ->where('login_code', $request->otp)->first();
            if ($username) {
                DB::update("update admins set login_code ='null' where mobile = '$username->mobile'");
                $alumni_token = AlumniJWTToken::CreateToken($username->id, $username->nameen, $username->email, $username->mobile, $username->admin_name);
                Cookie::queue('alumni_token', $alumni_token, 60 * 96); //96 hour
                $alumni_info = [
                     "name" => $username->nameen,"email" => $username->email,
                     "phone" => $username->mobile,"admin_name" => $username->admin_name
                ];
                $alumni_info_array = serialize($alumni_info);
                Cookie::queue('alumni_info', $alumni_info_array, 60 * 96);
                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => "Invalid OTP",
                ]);
            }
        }
    }


    public function logout()
    {
        Cookie::queue('alumni_token', '', -1);
        Cookie::queue('alumni_info', '', -1);
        return redirect('admin/login');
    }


  function dashboard(Request $request) {
       $admin_name=$request->header('admin_name');
       $admin_id=$request->header('id');
       $data = Admin::find($admin_id);
       $member = Invoice::where('payment_type','Online')->where('payment_status',1)->where('admin_name', $admin_name)->sum('amount');
       $nonmember = Nonmember::where('payment_type','Online')->where('payment_status',1)->where('admin_name', $admin_name)->sum('amount');
       $total_payment=$member+$nonmember;
       $all_category= APP::where('admin_name',$admin_name)->where('status',1)->orderBy('id','desc')->get();
       $event_category = App::where('admin_name', $admin_name)->where('admin_category','Event')->where('status', 1)->get();
       $batch_category = App::where('admin_name', $admin_name)->where('admin_category','Batch')->where('status', 1)->get();
       $profession_category = App::where('admin_name', $admin_name)->where('admin_category','Profession')->get();
       $withdraw = Withdraw::where('withdraw_status',1)->where('admin_name', $admin_name)->sum('withdraw_amount');
      
   
      return view('admin.dashboard', ['admin' => $data, 'all_category'=>$all_category ,'event_category' => $event_category,
         'total_payment' => $total_payment,'withdraw' =>$withdraw ,'batch_category' => $batch_category,'profession_category' => $profession_category]);
  }


  


  function password(Request $request)
   {
     $id = $request->header('id');
     $admin=Admin::find($id);
     return view('admin.password', ['admin' => $admin]);
   }

  function passwordedit(Request $request)
  {

    $request->validate([
      'email' => 'required',
      'n_pass'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
      'c_pass'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
    ], [
      'n_pass.regex' => 'password minimum six characters including one uppercase 
            letter, one lowercase letter and one number ',
      'c_pass.regex' => 'password minimum six characters including one uppercase letter, one 
                     lowercase letter and one number '
    ]);

    $id = $request->header('id');
    $email = $request->header('email');

    $email = $request->input('email');
    $n_pass = $request->input('n_pass');
    $c_pass = $request->input('c_pass');
   
    $admin=Admin::find($id);
    if ($email == $admin->email) {
      if ($n_pass == $c_pass) {

        $password = Admin::find($admin->id);
        //$password->password=Hash::make($npass);
        $password->admin_password = $n_pass;
        $password->update();
        return redirect('/admin/password')->with('success', 'Passsword change  successfully');
      } else {
        return back()->with('fail', 'New Password and Confirm Password does not match');
      }
    } else {
      return back()->with('fail', 'Invalid E-mail');
    }
  }


  public function forget()
  {
    return view('admin.forget');
  }


  public function forgetemail(request $request)
  {

    $email = $request->input('email');
    $rand = rand(11111, 99999);
    $email_exist = Admin::where('email', $email)->count('email');
    if ($email_exist >= 1) {
      DB::update(
        "update admins set forget_code ='$rand' where email = '$email'"
      );


      $subject = 'Admin E-mail Recovary Code';
      $title = 'Hi ';
      $body = 'Your one time recovery code';
      $link = '';
      $name = 'amaderthikana.com ';
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
        'status' => 500,
        'errors' => 'Email exist',
      ]);
    } else {
      return response()->json([
        'status' => 600,
        'errors' => 'Invalid  Email ',
      ]);
    }
  }



  public function forgetcode(request $request)
  {

    $email_id = $request->input('email_id');
    $forget_code = $request->input('forget_code');
    $code_exist = Admin::where('email', $email_id)->where('forget_code', $forget_code)->count('email');
    if ($code_exist >= 1) {
      return response()->json([
        'status' => 500,
        'errors' => 'valid code',
      ]);
    } else {
      return response()->json([
        'status' => 600,
        'errors' => 'Invalid  Code',
      ]);
    }
  }


  public function confirmpass(request $request)
  {

    $email_id_pass = $request->input('email_id_pass');
    $npass = $request->input('npass');
    $cpass = $request->input('cpass');
    //$password=Hash::make($npass);
    $password = $npass;

    if ($npass == $cpass) {
      DB::update(
        "update admins set admin_password ='$password' where email = '$email_id_pass'"
      );
      return response()->json([
        'status' => 500,
        'errors' => 'valid code',
      ]);
    } else {
      return response()->json([
        'status' => 600,
        'errors' => 'New password & Confirm password Does not match',
      ]);
    }
  }


  public function member(Request $request, $category_id){
      $status1 = 0;
      $status = 1;
      $admin_name = $request->header('admin_name'); 
      $category = DB::table('apps')->where('admin_name',$admin_name)->where('admin_category','Member')
        ->where('id', $category_id)->first();

       $verify = DB::table('members')->where('category_id', $category_id)->where('admin_name', $admin_name)->where('member_verify', $status)->count('id');
       $not_verify = DB::table('members')->where('category_id', $category_id)->where('admin_name', $admin_name)->where('member_verify', $status1)->count('id');
       $email_verify = DB::table('members')->where('category_id', $category_id)->where('admin_name', $admin_name)->where('email_verify', $status1)->count('id');


  if ($request->ajax()) {
       $data = Member::leftjoin('committeeunits','committeeunits.id','=','members.committeeunit_id')
         ->leftjoin('universities','universities.id','=','members.university_id')
         ->where('members.admin_name',$admin_name)->where('members.category_id',$category_id)
         ->select('committeeunits.unit_name','universities.university_name','members.*')->latest()->get();
        return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('image', function($row){
              $imageUrl = URL::to('uploads/admin/'.$row->profile_image); // Assuming 'profile_image' is the field name in the database
              return '<a href="' . $imageUrl . '" > Profile </a>';
            })

            ->addColumn('image2', function($row){
              $imageUrl = URL::to('uploads/admin/'.$row->certificate_image); // Assuming 'profile_image' is the field name in the database
              return '<a href="' . $imageUrl . '" > Profile </a>';
            })

          ->addColumn('email_verify', function ($row) {
            if ($row->email_verify == 1) {
                return '<a href="' . url('admin/member/email/deactive/' . $row->id) . '" 
                           onclick="return confirm(\'Are you sure you want to Change this status?\')" 
                           class="btn btn-success btn-sm">
                           Verified
                        </a>';
            } else {
                return '<a href="' . url('admin/member/email/active/' . $row->id) . '" 
                           onclick="return confirm(\'Are you sure you want to Move this status?\')" 
                           class="btn btn-danger btn-sm">
                           Pending Verification
                        </a>';
            }
         })


         ->addColumn('member_verify', function ($row) {
          if ($row->member_verify == 1) {
              return '<a href="' . url('admin/member/verify/deactive/' . $row->id) . '" 
                         onclick="return confirm(\'Are you sure you want to verify this profile?\')" 
                         class="btn btn-success btn-sm">
                         Verified
                      </a>';
           } else {
              return '<a href="' . url('admin/member/verify/active/' . $row->id) . '" 
                         onclick="return confirm(\'Are you sure you want to verify this profile?\')" 
                         class="btn btn-danger btn-sm">
                         Pending Verification
                      </a>';
             }
           })

           ->addColumn('status', function ($row) {
             if ($row->status == 1) {
                  return '<a href="' . url('admin/member/status/deactive/' . $row->id) . '" 
                           onclick="return confirm(\'Are you sure you want to Change this status?\')" 
                           class="btn btn-success btn-sm">
                           Active
                        </a>';
              } else {
                  return '<a href="' . url('admin/member/status/active/' . $row->id) . '" 
                           onclick="return confirm(\'Are you sure you want to Change this status?\')" 
                           class="btn btn-danger btn-sm">
                           Inactive
                        </a>';
              }
           })

           ->addColumn('view', function($row){
             $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="view_all btn btn-primary btn-sm">View</a>';
              return $btn;
          })
         ->addColumn('edit', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
            return $btn;
         })
         ->addColumn('delete', function($row){
             $btn = '<a href="/admin/member_delete/' . $row->id . '" 
                    onclick="return confirm(\'Are you sure you want to delete this item?\')" 
                    class="btn btn-danger btn-sm">
                     Delete
                </a>';
             return $btn;
         })
      ->rawColumns(['image','image2','status','edit','delete','view','email_verify','member_verify'])
      ->make(true);
   }

   return view('admin.member', ['category' => $category, 'category_id' => $category_id, 'verify' => $verify, 'not_verify' => $not_verify, 'email_verify' => $email_verify]);
  }


  


  public function memberstatus($operator, $status, $id)
  {

    if ($operator == 'email') {
      if ($status == 'deactive') {
        $type = 0;
      } else {
        $type = 1;
      }
      DB::update("update members set email_verify ='$type' where id = '$id'");
      return back()->with('success', 'Email Verify update Successfull');
    } else if ($operator == 'status') {
      if ($status == 'deactive') {
        $type = 0;
      } else {
        $type = 1;
      }
      DB::update("update members set status ='$type' where id = '$id'");
      return back()->with('success', 'Status update Successfull');
    } else if ($operator == 'verify') {
      if ($status == 'deactive') {
        $type = 0;
      } else {
        $type = 1;
      }
      DB::update("update members set member_verify ='$type' where id = '$id'");
      return back()->with('success', 'Status update Successfull');
    } else {
      return back()->with('fail', 'Something Rong');
    }


    //}catch (Exception $e) { return  'something is Rong'; }
  }


 

  public function member_view($id)
  {
    $value = Member::find($id);
    if ($value) {
      return response()->json([
        'status' => 200,
        'value' => $value,
      ]);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'Member not found',
      ]);
    }
  }



  public function member_delete(Request $request, $id)
  {
    $member = Member::find($id);
    $path = public_path('uploads/admin/') . $member->profile_image;
    if (File::exists($path)) {
      File::delete($path);
    }

    $path = public_path('uploads/admin/') . $member->certificate_image;
    if (File::exists($path)) {
      File::delete($path);
    }
    $member->delete();
    return back()->with('success', 'Data Delete Successfull');
  }

  public function member_update(Request $request)
  {

    $admin_name = $request->header('admin_name'); 

    $validator = \Validator::make(
      $request->all(),
      [
        'phone' => 'required|unique:members,phone,' . $request->input('edit_id'),
        'email' => 'required|unique:members,email,' . $request->input('edit_id'),
        'member_card' => 'required|unique:members,member_card,' . $request->input('edit_id') . 'NULL,id,admin_name,' . $admin_name,
        'serial' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:400',
      ],
      [
        'phone.required' => 'Phone number is required',
        'email.required' => 'Email is required',
        'dureg.required' => 'Registration is required',
        'dureg.unique' => 'Registration number already exist',
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'validate_err' => $validator->messages(),
      ]);
    } else {
      $model = Member::find($request->input('edit_id'));
      if ($model) {
        $model->phone = $request->input('phone');
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->serial = $request->input('serial');
        $model->category_id = $request->input('category_id');
        $model->blood = $request->input('blood');
        $model->member_card = $request->input('member_card');
        $model->designation = $request->input('designation');
        $model->email_status = $request->input('email_status');
        $model->phone_status = $request->input('phone_status');
        $model->blood_status = $request->input('blood_status');
        $model->organization = $request->input('organization');
        $model->village = $request->input('village');

        $model->batch_id = $request->input('batch_id');
        $model->profession_id = $request->input('profession_id');
        $model->committeeunit_id = $request->input('committeeunit_id');
        $model->university_id = $request->input('university_id');

        if ($request->hasfile('image')) {
          $imgfile = 'profile-';
          $size = $request->file('image')->getsize();
          $file = $_FILES['image']['tmp_name'];
          $hw = getimagesize($file);
          $w = $hw[0];
          $h = $hw[1];
          // if ($w < 310 && $h < 310) {
          $path = public_path('uploads/admin') . '/' . $model->profile_image;
          if (File::exists($path)) {
            File::delete($path);
          }
          $image = $request->file('image');
          $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
          $image->move(public_path('uploads/admin'), $new_name);
          $model->profile_image = $new_name;
          // } else {
          //    return response()->json([
          //        'status' =>300,
          //        'message' =>'Image size must be 300*300px',
          //    ]);
          //  }
        }

        $model->update();
        return response()->json([
          'status' => 200,
          'message' => ' Updated Successfull'
        ]);
      } else {
        return response()->json([
          'status' => 404,
          'message' => 'Student not found',
        ]);
      }
    }
  }



  public function member_add(Request $request)
  {

    $admin_name = $request->header('admin_name'); 
    $validator = \Validator::make(
      $request->all(),
      [
        'phone' => 'required|unique:members,phone',
        'email' => 'required|unique:members,email',
        'member_card' => 'required|unique:members,member_card,NULL,id,admin_name,' . $admin_name,
        'name' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:400',
      ],
      [
        'phone.required' => 'Phone number is required',
        'email.required' => 'Email is required',
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'validate_err' => $validator->messages(),
      ]);
    } else {
        $model = new Member;
        $model->phone = $request->input('phone');
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->admin_name = $admin_name;
        $model->member_password ='Pass246#';
        $model->serial = 0;
        $model->category_id = $request->input('category_id');
        $model->member_card = $request->input('member_card');
        $model->batch_id = $request->input('batch_id');
        $model->session_id = $request->input('session_id');
        $model->save();
        return response()->json([
          'status' => 200,
          'message' => ' Updated Successfull'
        ]);
    }

  }

  public function paymentview(Request $request)
  {
     $admin_name = $request->header('admin_name'); 
     $data = APP::where('admin_name',$admin_name)->where('status', 1)->orderBy('id', 'desc')->get();
     $member = Member::where('admin_name',$admin_name)->where('member_verify', 1)->get();
     return view('admin.paymentview', ['category' => $data, 'member' => $member]);
  }

  public function fetch(Request $request)
  {
      $admin_name = $request->header('admin_name'); 
      $admin = Admin::where('admin_name', $admin_name)->first();
    
      $data = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
        ->leftjoin('apps', 'apps.id', '=', 'invoices.category_id')
        ->where('invoices.admin_name', $admin->admin_name)
        ->select(
          'members.member_card',
          'members.name',
          'members.phone',
          'members.id as uid',
          'apps.category',
          'invoices.*'
        )->orderBy('invoices.id', 'desc')->paginate(10);
      return view('admin.paymentview_data', compact('data'));
    }


  function fetch_data(Request $request)
  {
    if ($request->ajax()) {
      $admin_name = $request->header('admin_name'); 
      $admin = Admin::where('admin_name', $admin_name)->first();
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype');
      $search = $request->get('search');
      $search = str_replace(" ", "%", $search);
      $data = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
        ->leftjoin('apps', 'apps.id', '=', 'invoices.category_id')
        ->where('invoices.admin_name', $admin->admin_name)
        ->where(function ($query) use ($search) {
          $query->orwhere('invoices.id', 'like', '%' . $search . '%');
          $query->orwhere('members.member_card', 'like', '%' . $search . '%');
          $query->orwhere('members.name', 'like', '%' . $search . '%');
          $query->orwhere('members.phone', 'like', '%' . $search . '%');
          $query->orwhere('members.id', 'like', '%' . $search . '%');
          $query->orwhere('apps.category', 'like', '%' . $search . '%');
        })
        ->select('members.member_card', 'members.name', 'members.phone', 'members.id as uid', 'apps.category', 'invoices.*')
        ->orderBy($sort_by, $sort_type)->paginate(10);
      return view('admin.paymentview_data', compact('data'))->render();
    }
  }





  public function payment_status(Request $request)
  {
    $id = $request->id;
    $payment_method = $request->payment_method;
    $invoice = Invoice::where('id', $id)->first();

    if ($invoice->payment_type == "Online") {
      return response()->json([
        'status' => 300,
        'message' => "Online Payment Exist.Can Not Change Payment Status",
      ]);
    } else {
      if ($invoice->payment_status == 0) {
        $status = 1;
        $payment_time = date('Y-m-d H:i:s');
        $payment_type = 'Offline';
      } else {
        $status = 0;
        $payment_time = date('2010-10-10 10:10:10');
        $payment_type = 'Offline';
      }
      $payment_date = date('Y-m-d');
      $payment_day = date('d');
      $payment_month = date('n');
      $payment_year = date('Y');

      $model = Invoice::find($id);
      $model->payment_status = $status;
      $model->payment_type = $payment_type;
      $model->payment_time = $payment_time;
      $model->payment_method = $payment_method;
      $model->payment_date = $payment_date;
      $model->payment_year = $payment_year;
      $model->payment_month = $payment_month;
      $model->payment_day = $payment_day;
      $model->update();

      return response()->json([
        'status' => 200,
        'message' => "Payment Status Update Successfull",
      ]);
    }
  }


  public function payment_delete(Request $request)
  {
    $admin_name = $request->header('admin_name'); 
    $id = $request->id;
    $email = $request->email;
    $invoice = Invoice::where('id', $id)->first();
    $admin = Admin::where('admin_name', $admin_name)->first();
    if ($email == $admin->email) {
      if ($invoice->payment_status == 0) {
        $model = Invoice::find($id);
        $model->delete();
        return response()->json([
          'status' => 200,
          'message' => "Invoice delete Successfull",
        ]);
      } else {
        return response()->json([
          'status' => 300,
          'message' => "Please Unpaid Payment Status",
        ]);
      }
    } else {
      return response()->json([
        'status' => 400,
        'message' => "Invalid Admin Email",
      ]);
    }
  }



  public function payment_category(Request $request)
  {

    $month = date('n', strtotime($_POST['month']));
    $year = date('Y', strtotime($_POST['month']));
    $monthyear = $request->input('month');
    $category = $request->input('category');

    $admin_name = $request->header('admin_name'); 

    $admin = Admin::where('admin_name', $admin_name)->first();
    $category_name = App::where('id', $category)->first();

    if ($_POST['month']) {
       $invoice = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
         ->where('invoices.admin_name', $admin->admin_name)->where('invoices.category_id', $category)
         ->where('invoices.payment_month', $month)->where('invoices.payment_year', $year)->where('invoices.payment_status', 1)
         ->select('members.member_card', 'members.name', 'invoices.*')->orderBy('member_card', 'asc')->get();
      } else {
        $invoice = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->where('invoices.admin_name', $admin->admin_name)->where('invoices.category_id', $category)->where('invoices.payment_status', 1)
         ->select('members.member_card', 'members.name', 'invoices.*')->orderBy('member_card', 'asc')->get();
      }

    $file = 'Invoice-' . $monthyear . '.pdf';
    $pdf = PDF::loadView('pdf.payment_category', [
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

    return $pdf->stream($file . '.pdf');
  }


  public function dataview(Request $request)
  {
    $admin_name = $request->header('admin_name'); 
    $admin = Admin::where('admin_name', $admin_name)->get();
    return view('admin.dataview', ['admin' => $admin]);
  }

  public function dataedit(Request $request)
  {

    $admin = Admin::find($request->input('id'));

    $admin->token1 = $request->input('token1');
    $admin->token2 = $request->input('token2');
    $admin->token3 = $request->input('token3');
    $admin->token4 = $request->input('token4');
    $admin->token5 = $request->input('token5');
    $admin->token6 = $request->input('token6');

    $admin->program_title = $request->input('program_title');
    $admin->program_desc = $request->input('program_desc');
    $admin->program_status = $request->input('program_status');

    $admin->counter1 = $request->input('counter1');
    $admin->counter_name1 = $request->input('counter_name1');
    $admin->counter2 = $request->input('counter2');
    $admin->counter_name2 = $request->input('counter_name2');
    $admin->counter3 = $request->input('counter3');
    $admin->counter_name3 = $request->input('counter_name3');
    $admin->counter4 = $request->input('counter4');
    $admin->counter_name4 = $request->input('counter_name4');

    $admin->update();
    return redirect()->back()->with('success', 'Token Setup Update Successfuly');
  }


  public function member_export(Request $request)
  {
    $admin_name = $request->header('admin_name'); 
    $category_id = $request->input('category_id');
    return (new UserExport($admin_name, $category_id))->download('Member_list.csv');
  }


  public function non_member_export(Request $request)
  {
     $admin_name = $request->header('admin_name'); 
     $category_id = $request->input('category_id');
     $payment_status = $request->input('payment_status');
     return (new NonMemberExport($admin_name,$category_id,$payment_status))->download($admin_name.$category_id.'-'.$payment_status.'-Non_Member_list.csv');
  }







  public function admin_invoice_create(request $request)
  {
    $member_id = $request->input('member_id');
    $admin_name = $request->header('admin_name'); 
    $admin = Admin::where('admin_name', $admin_name)->first();
    $username = $admin->admin_name;
    $validator = \Validator::make(
      $request->all(),
      [
        'category_id'  => 'required',
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 700,
        'message' => $validator->messages(),
      ]);
    } else {
      $admin = Admin::where('admin_name', $username)->select(
        'id',
        'name',
        'nameen',
        'address',
        'email',
        'mobile',
        'admin_name',
        'header_size',
        'resheader_size',
        'getway_fee',
        'other_link'
      )->first();
      $category = App::where('admin_name', $username)->where('status', 1)->where('id', $request->category_id)->first();
      if ($category) {
        $verify = Member::where('member_verify', 1)->where('id', $member_id)->count('id');

        $exist_category = Invoice::where('member_id', $member_id)->where('category_id', $request->category_id)->count('id');
        if ($exist_category >= 1) {
          return response()->json([
            'status' => 400,
            'message' => "Booking category Already Added",
          ]);
        } else {
          $total_amount = $category->amount + ($category->amount * $admin->getway_fee) / 100;
          if ($verify >= 1) {
            $model = new Invoice;
            $model->admin_name = $username;
            $model->tran_id = Str::random(8);
            $model->member_id = $member_id;
            $model->category_id = $request->category_id;
            $model->amount = $category->amount;
            $model->payment_status = 0;
            $model->getway_fee = $admin->getway_fee;
            $model->total_amount = $total_amount;
            $model->web_link = $admin->other_link;
            $model->save();

            return response()->json([
              'status' => 200,
              'message' => "Invoice Create Successfull",
            ]);
          } else {
            return response()->json([
              'status' => 400,
              'message' => "Memebr Verify Pending . Please Contact Authority",
            ]);
          }
        }
      } else {
        return response()->json([
          'status' => 400,
          'message' => "Payment category Invalid",
        ]);
      }
    }
  }



  public function payment_report(Request $request)
  {
     // $month = date('n', strtotime($_POST['month']));
     // $year = date('Y', strtotime($_POST['month']));
     $date1 = $request->input('date1');
     $date2 = $request->input('date2');
     $payment_type = $request->input('payment_type');
     $admin_name = $request->header('admin_name'); 

       
     $admin = Admin::where('admin_name', $admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
      'header_size','resheader_size','getway_fee','other_link')->first();
  
  
     $invoice = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
         ->leftjoin('apps', 'apps.id', '=', 'invoices.category_id')
        ->where('invoices.admin_name', $admin->admin_name)->whereBetween('payment_date', [$date1, $date2])->where('invoices.payment_status', 1)
        ->where('payment_type',$payment_type)
        ->select('members.member_card','members.name','members.phone','apps.category','invoices.*')->orderBy('payment_date', 'asc')->get();
    
        $non_invoice = Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')
       ->where('nonmembers.admin_name', $admin->admin_name)->whereBetween('payment_date', [$date1, $date2])->where('nonmembers.payment_status', 1)
       ->where('payment_type',$payment_type)
       ->select('apps.category','nonmembers.*')->orderBy('nonmembers.id', 'asc')->get();
     
       return view('print.payment_report',['invoice' => $invoice,
         'date1' => $date1,
         'date2' => $date2,
         'payment_type' => $payment_type,
         'admin' => $admin,
         'non_invoice' => $non_invoice,]);

       // return $invoice;
      // die();
    // $file = 'Payment-' . $date1.'-'.$date2 . '.pdf';
    // $pdf = PDF::loadView('pdf.payment_report', [
    //   'title' => 'PDF Title',
    //   'author' => 'PDF Author',
    //   'margin_left' => 20,
    //   'margin_right' => 20,
    //   'margin_top' => 60,
    //   'margin_bottom' => 20,
    //   'margin_header' => 15,
    //   'margin_footer' => 10,
    //   'showImageErrors' => true,
    //   'invoice' => $invoice,
    //   'date1' => $date1,
    //   'date2' => $date2,
    //   'payment_type' => $payment_type,
    //   'admin' => $admin,
    //   'non_invoice' => $non_invoice,
    // ]);
    // return $pdf->stream($file . '.pdf');


  }



  public function payment_report_date(Request $request)
  {
       $date= $request->input('date');
       $payment_type = $request->input('payment_type');
       $admin_name = $request->header('admin_name'); 

       $admin = Admin::where('admin_name',$admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
        'header_size','resheader_size','getway_fee','other_link')->first();
  
        $invoice = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->leftjoin('apps', 'apps.id', '=', 'invoices.category_id')
          ->where('invoices.admin_name', $admin->admin_name)->where('payment_date',$date)->where('invoices.payment_status', 1)
          ->where('payment_type',$payment_type)
          ->select('members.member_card','members.name','members.phone','apps.category','invoices.*')->orderBy('payment_date', 'asc')->get();
    
        $non_invoice = Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')
        ->where('nonmembers.admin_name', $admin->admin_name)->where('payment_date',$date)->where('nonmembers.payment_status', 1)
        ->where('payment_type',$payment_type)
        ->select('apps.category','nonmembers.*')->orderBy('nonmembers.id', 'asc')->get();

        return view('print.payment_report_date',[
         'invoice' => $invoice,
         'date' => $date,
         'payment_type' => $payment_type,
         'admin' => $admin,
         'non_invoice' => $non_invoice]);
  }


  
  public function payment_category_report(Request $request)
  {
   
     $category= $request->input('category');
     $payment_type = $request->input('payment_type');
     $admin_name = $request->header('admin_name'); 

       $admin = Admin::where('admin_name', $admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
       'header_size','resheader_size','getway_fee','other_link')->first();
        $category_name = App::where('id', $category)->first();
  
     $invoice=Invoice::leftjoin('members','members.id', '=', 'invoices.member_id')
        ->leftjoin('apps', 'apps.id','=','invoices.category_id')
        ->where('invoices.admin_name', $admin->admin_name)->where('invoices.category_id',$category)->where('invoices.payment_status', 1)
        ->where('payment_type',$payment_type)
        ->select('members.member_card','members.name','members.phone','apps.category','invoices.*')->orderBy('payment_date', 'asc')->get();
    
        $non_invoice = Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')
        ->where('nonmembers.admin_name', $admin->admin_name)->where('nonmembers.category_id',$category)->where('nonmembers.payment_status', 1)
        ->where('payment_type',$payment_type)
        ->select('apps.category','nonmembers.*')->orderBy('nonmembers.id', 'asc')->get();
       
        return view('print.payment_category_report',[
          'invoice' => $invoice,
          'payment_type' => $payment_type,
          'category_name'=>$category_name,
          'admin' => $admin,
          'non_invoice' => $non_invoice,]);
     
  }


  public function event_report(Request $request)
  {
     $admin_name = $request->header('admin_name'); 
     $admin = Admin::where('admin_name',$admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
      'header_size','resheader_size','getway_fee','other_link')->first();
  
      $event_category = App::where('admin_name', $admin->admin_name)->where('admin_category','Event')->where('status', 1)->get();


      $event_member=Invoice::leftjoin('apps', 'apps.id', '=', 'invoices.category_id')
      ->leftjoin('members', 'members.id', '=', 'invoices.member_id')
       ->where('invoices.admin_name',$admin->admin_name)->where('apps.admin_category','Event')->where('apps.status', 1)
       ->where('payment_status',1)->select('apps.category', 'invoices.*','members.name'
      ,'members.phone','members.member_card','members.serial')->orderBy('members.serial','asc')->get();
     
      $event_non_member=Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')
       ->where('nonmembers.admin_name',$admin->admin_name)->where('apps.admin_category','Event')->where('apps.status', 1)
       ->where('payment_status',1)->select('apps.category', 'nonmembers.*')->orderBy('nonmembers.id','asc')->get();
     
        return view('print.event_report',[
        'event_member' => $event_member,
        'event_non_member' => $event_non_member,
        'admin' => $admin,]);
  }



   public function auto_invoice(Request $request)
    {
       $admin_name = $request->header('admin_name'); 
       $admin = Admin::where('admin_name',$admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
       'header_size','resheader_size','getway_fee','other_link')->first();

       $invoice=Nonmember::leftjoin('apps','apps.id','=','nonmembers.category_id')
         ->leftjoin('admins','admins.admin_name','=','nonmembers.admin_name')
         ->where('nonmembers.admin_name',$admin->admin_name)->where('nonmembers.id',5)
         ->where('nonmembers.payment_status',1)->where('payment_type','Online')->select(
        'admins.nameen' ,'admins.address','admins.mobile','admins.email as admin_email'
        ,'apps.category','nonmembers.*')->orderBy('payment_date', 'asc')->first();

        $data['title']=$invoice->nameen;
        $data['file']=$invoice->nameen;
        $data['address']=$invoice->address;
        $data['admin_mobile']=$invoice->mobile;
        $data['admin_email']=$invoice->admin_email;

        $data['email']=$invoice->email;
        $data['phone']=$invoice->phone;
        $data['name']=$invoice->name;
        $data['tran_id']=$invoice->tran_id;
        $data['category']=$invoice->category;
        $data['payment_method']=$invoice->payment_method;
        $data['payment_time']=$invoice->payment_time;
        $data['total_amount']=$invoice->total_amount;

          $pdf=PDF::loadView('pdf.auto_invoice',$data);
               Mail::send('pdf.auto_invoice',$data,function($message) use ($data,$pdf){
               $message->to($data['email'])
                 ->subject($data['title'])
                 ->attachData($pdf->output(),$data['file'].".pdf");       
               });
          }

        public function member_info(Request $request)
        {
             $admin_name = $request->header('admin_name');  
             $admin = Admin::where('admin_name',$admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
               'header_size','resheader_size','getway_fee','other_link')->first();
        
          
            $batch_id=$request->input('batch_id');
            $profession_id=$request->input('profession_id');

            $batch_category = App::where('admin_name',$admin_name)->where('admin_category','Batch')->where('id',$batch_id)->first();
            $profession_category = App::where('admin_name',$admin_name)->where('admin_category','Profession')->where('id',$profession_id)->first();
           
            if(!empty($batch_id) && !empty($profession_id)){
                    $data = Member::where('admin_name',$admin_name)
                   ->where('batch_id',$batch_id)->where('profession_id',$profession_id)->orderBy('member_card','asc')->orderBy('serial','asc')->get();
                    return view('print.member_info',[ 'data' => $data,'admin' => $admin ,'batch_category'=>$batch_category
                   ,'profession_category'=>$profession_category]);
              }else if(empty($profession_id)){
                    $data = Member::where('admin_name',$admin_name)
                    ->where('batch_id',$batch_id)->orderBy('member_card','asc')->orderBy('serial','asc')->get();
                    return view('print.member_info',[ 'data' => $data,'admin' => $admin,'batch_category'=>$batch_category
                    ,'profession_category'=>$profession_category]);
              }else if(empty($batch_id)){
                    $data = Member::where('admin_name',$admin_name)
                    ->where('profession_id',$profession_id)->orderBy('member_card','asc')->orderBy('serial','asc')->get();
                    return view('print.member_info',['data' => $data,'admin' => $admin,'batch_category'=>$batch_category
                     ,'profession_category'=>$profession_category]);
                  }else{
              return "Please Select Batch/Session or Prefession";
            }
              
        }

        public function group_report(Request $request)
        {

          $admin_name = $request->header('admin_name');  
          $category=$request->input('category');

          $admin = Admin::where('admin_name',$admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
          'header_size','resheader_size','getway_fee','other_link')->first();
           
          $data = Member::where('admin_name',$admin_name)->select($category,DB::raw('count(id) as id'))
          ->groupBy($category)->orderBy($category,'asc')->get();

         return view('print.group_report',['data' => $data,'admin' => $admin,'category'=>$category]);
      
        }

      
  function donor_dashboard(Request $request) {
      $admin_name=$request->header('admin_name');
      $admin_id=$request->header('id');
      $data = Admin::find($admin_id);
      $donormember = Donormember::where('payment_type','Online')->where('payment_status',1)->where('admin_name', $admin_name)->sum('amount');
      $donorwithdraw = Donorwithdraw::where('withdraw_status',1)->where('admin_name', $admin_name)->sum('withdraw_amount');
   
      return view('admin.donor_dashboard', ['admin' => $data ,'donormember'=>$donormember 
        ,'donorwithdraw'=>$donorwithdraw]);
    }



    public function donor_payment_report(Request $request)
    {
      // $month = date('n', strtotime($_POST['month']));
      // $year = date('Y', strtotime($_POST['month']));
      $date1 = $request->input('date1');
      $date2 = $request->input('date2');
      $payment_type = $request->input('payment_type');
      $admin_name = $request->header('admin_name'); 

       $admin = Admin::where('admin_name', $admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
        'header_size','resheader_size','getway_fee','other_link')->first();
  
        $donor_invoice = Donormember::where('admin_name', $admin->admin_name)
        ->whereBetween('payment_date', [$date1, $date2])->where('payment_status', 1)
        ->where('payment_type',$payment_type)
        ->select('donormembers.*')->orderBy('id','asc')->get();
     
       return view('print.donor_payment_report',[
           'date1' => $date1,
           'date2' => $date2,
           'payment_type' => $payment_type,
           'admin' => $admin,
           'donor_invoice' => $donor_invoice]);
      }

   }
