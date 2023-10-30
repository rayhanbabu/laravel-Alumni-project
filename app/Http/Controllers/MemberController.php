<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Helpers\MaintainJWTToken;
use App\Helpers\ForgetJWTToken;
use Illuminate\Support\Facades\Hash;
use App\Models\App;
use App\Models\Invoice;
use Exception;

class MemberController extends Controller
{
    
 
    public function application_memebr(Request $request){

        $admin= Admin::where('admin_name',$request->username)->first();
          $validator=\Validator::make($request->all(),[       
             'name' => 'required',
             'category' =>'required',
             'degree_category' =>'required',
             'blood' =>'required',
             'country' =>'required',
             'city' => 'required',
             'occupation' => 'required',  
             'member_password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
             'phone' => 'required||min:8|unique:members,phone',
             'email' => 'required|unique:members,email',
             'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:400',
             'certificate_image' => 'required|mimes:jpeg,png,jpg,pdf|max:500',
            ],
            [
               'member_password.regex'=>'password minimum six characters including one uppercase letter, one lowercase letter and one number '
            ]
        );
          
    if($admin){
      if($validator->fails()){
         return response()->json([
             'status'=>700,
             'message'=>$validator->messages(),
          ]);
     }else{
        $count= Member::where('admin_name',$request->username)->count('id')+1;
        $member_card=10000+$count;
      
        $model= new Member;
        $model->category=$request->input('category');
        $model->serial=$count;
        $model->member_card=$member_card;
        $model->admin_name=$request->username;
        $model->name=$request->input('name');
        $model->member_password=$request->input('member_password');
        $model->gender=$request->input('gender');
        $model->country=$request->input('country');
        $model->city=$request->input('city');
        $model->occupation=$request->input('occupation');
        $model->organization=$request->input('organization');
        $model->designation=$request->input('designation');
        $model->passing_year=$request->input('passing_year');
        $model->blood=$request->input('blood');
        $model->blood_status='show';
        $model->phone=$request->input('phone');
        $model->phone_status='show';
        $model->email=$request->input('email');
        $model->emailmd5=md5($request->input('email'));
        $model->email_status='show';
        $model->email_verify=0;
        $model->member_verify=0;
        $model->status=1;
       
      
         if($request->hasfile('profile_image')){
           $file=$_FILES['profile_image']['tmp_name'];
           $hw=getimagesize($file);
           $w=$hw[0];
           $h=$hw[1];	 
              if($w<310 && $h<310){
               $image= $request->file('profile_image'); 
               $file_name = 'profile'.rand() . '.' . $image->getClientOriginalExtension();
               $image->move(public_path('uploads/admin'), $file_name);
               $model->profile_image=$file_name;
            }else{
              return response()->json([
                  'status'=>600,  
                  'message'=>'Profile Image size must be 300*300px ',
               ]);
              }
           }

            if($request->hasfile('certificate_image')){
                 $image1= $request->file('certificate_image');
                 $file_name1 = 'certicicate'.rand() . '.' . $image1->getClientOriginalExtension();
                 $image1->move(public_path('uploads/admin'), $file_name1);
                 $model->certificate_image=$file_name1;
              }
         $model->save();

         $email=$request->input('email');
         $rand=rand(11111,99999);
         $subject='Verify your Email ';  
         $title='Dear,  '.$request->input('name');
         $body='Please Click URL and verify your email to complete your account setup.';
         $link=$admin->other_link.'email_verify/'.md5($request->input('email'));
         $body1='Alternatively, paste the following URL into your browser:';
         $name='DUCAA , developed by ancovabd.com';  
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
               'status'=>200,  
               'message'=>'Application Successfull. Please Verify your E-mail',
           ]);

         }
  
         }else{
             return response()->json([
                'status'=>600,  
                'message'=>'Something Rong Or Undefind Username',
             ]);
         }
  
      }



      public function email_verify(Request $request,$emailmd5){
        $data=Member::where('emailmd5',$emailmd5)->first();
       if($data){
        $status=1;
        if($data->email_verify==1){
              return response()->json([
                 'status'=>400,  
                 'message'=>'E-mail already verified',
               ]);
           }else{
               DB::update(
                "update members set email_verify ='$status' where emailmd5 ='$emailmd5'"
               );
               return response()->json([
                'status'=>200,  
                'message'=>'E-mail verify Successfull',
              ]);
          }
        }else{
              return response()->json([
                'status'=>600,  
                'message'=>"Invalid Email",
              ]);
            }
     }  
     
     
     public function forget_password(request $request){

     

   
            $email=$request->email;
            $rand=rand(11111,99999);
            $email_exist=Member::where('email',$email)->count('email');
           if($email_exist>=1){
               DB::update(
                  "update members set forget_code ='$rand' where email = '$email'"
                );
               
                    $subject='Password Recovery Code';  
                    $title='Dear ';
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
 
                    $TOKEN_FORGET=ForgetJWTToken::CreateToken($email);
    
                 return response()->json([
                     'status'=>200,
                      'TOKEN_FORGET'=>$TOKEN_FORGET,
                      'message'=> 'Recovery code send your E-mail',
                  ]); 
            }else{
                return response()->json([
                    'status'=>600,
                     'message'=> 'Invalid  Email ',
               ]); 
            }   

         }


         public function forget_code(request $request){

           $email=$request->header('email');
           $code=$request->forget_code;
           $email_exist=Member::where('email',$email)->count('email');
          if($email_exist>=1 OR $code>11){
             $code_exist=Member::where('email',$email)->where('forget_code',$code)->count('email');
            
              if($code_exist>=1){
                  DB::update("update members set  forget_code ='nullvalue' where email = '$email'");
                  return response()->json([
                       'status'=>200,
                        'message'=> 'Code Match',
                   ]); 

               }else{
              return response()->json([
                 'status'=>400,
                 'message'=> 'Invalid Recovery Code',
            ]); 
             }
            
          }else{
              return response()->json([
                  'status'=>600,
                   'message'=> 'Recovery code not empty ',
             ]); 
          }  
        
       }


       public function confirm_password(request $request){
        $email=$request->header('email');
        $validator=\Validator::make($request->all(),[    
          'new_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
          'confirm_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ],
        [
          'new_password.regex'=>'password minimum six characters including one uppercase 
                   letter, one lowercase letter and one number ',
           'confirm_password.regex'=>'password minimum six characters including one uppercase letter, one 
                            lowercase letter and one number '          
       ]);

        if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
       }else{
        $rend=rand();
        $new_password=$request->new_password;
        $confirm_password=$request->confirm_password;
        if($new_password==$confirm_password){ 
        $code_exist=Member::where('email',$email)->where('forget_code','nullvalue')->count('email');
        if($code_exist>=1){
            DB::update("update members set member_password ='$new_password', forget_code ='$rend' where email = '$email'");
              return response()->json([
                 'status'=>200,
                 'message'=> 'Password Change Successfull',
              ]); 
         }else{
             return response()->json([
                 'status'=>600,
                 'message'=> 'Invalid Verification code',
              ]); 
          }  
        }else{
            return response()->json([
                'status'=>300,
                'message'=> 'New Passsword & Confirm Passsword is not match',
            ]); 
         }  

       } 
    }


    public function member_login(Request $request){

        $validator=\Validator::make($request->all(),[    
            'email'=>'required',
            'member_password'=>'required',
          ],
           [
            'member_password.required'=>'Password is required',
          ]);

          if($validator->fails()){
               return response()->json([
                 'status'=>700,
                 'message'=>$validator->messages(),
              ]);
         }else{
          $status=1;
          $member=Member::where('email',$request->email)->first();
          if($member){
                   if($member->member_password==$request->member_password){
                      if($member->status==$status){
                        if($member->email_verify==$status){
                        $token=MaintainJWTToken::CreateToken($member->email,$member->id,$member->admin_name);
                        //Cookie::queue('token_login',$token,60*24);
                        //->cookie('TOKEN_LOGIN',$token,60*24*30)
                    return response()->json([
                        'status'=>200,
                        'message'=> 'success login',
                        'TOKEN_LOGIN'=>$token,
                      ]);  
                      
                    }else{
                      return response()->json([
                         'status'=>900,
                         'message'=> 'Invalid Email',
                      ]); 
                   }   
                           
                       }else{
                          return response()->json([
                             'status'=>800,
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
                  'message'=> 'Invalid Email',
              ]); 
           }
      }

          //Email($maintain->email,"Maintain Otp code","One Time OTP Code",$otp,"Dining Name");    
    }

    

    public function member_profile(Request $request){

        $member_id=$request->header('member_id');
        $member=Member::where('id',$member_id)->first();
        return response()->json([
            'status'=>200,
            'data'=>$member,
        ]); 
    }


    public function member_update(Request $request){

      $member_id=$request->header('member_id');

      $validator=\Validator::make($request->all(),[       
        'name' => 'required',
        'degree_category' =>'required',
        'blood' =>'required',
        'country' =>'required',
        'city' => 'required',
        'occupation' => 'required',
        'phone' => 'required|min:11|unique:members,phone,'.$member_id,
        'email' => 'required|unique:members,email,'.$member_id,
        'profile_image' => 'image|mimes:jpeg,png,jpg|max:412000',
       ],
   );

   if($validator->fails()){
      return response()->json([
           'status'=>700,
           'message'=>$validator->messages(),
       ]);
   }else{
     
      $model=Member::find($member_id);

        $model->name=$request->input('name'); 
        $model->gender=$request->input('gender');
        $model->country=$request->input('country');
        $model->city=$request->input('city');
        $model->occupation=$request->input('occupation');
        $model->phone=$request->input('phone');
        $model->email=$request->input('email');
        $model->blood=$request->input('blood');

        $model->organization=$request->input('organization');
        $model->designation=$request->input('designation');
        $model->web_link=$request->input('web_link');
        $model->affiliation=$request->input('affiliation');
        $model->training=$request->input('training');
        $model->expertise=$request->input('expertise');
        
      
       
       if($request->hasfile('profile_image')){
         $file=$_FILES['profile_image']['tmp_name'];
         $hw=getimagesize($file);
         $w=$hw[0];
         $h=$hw[1];	 
            if($w<310 && $h<310){
              $filePath = public_path('uploads/admin') . '/' . $model->profile_image;
              if (file_exists($filePath)) {
                   unlink($filePath);
                }
             $image= $request->file('profile_image'); 
             $file_name = 'profile'.rand() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('uploads/admin'), $file_name);
             $model->profile_image=$file_name;
          }else{
            return response()->json([
                 'status'=>600,  
                 'message'=>'Profile Image size must be 300*300px ',
             ]);
            }
         }

       $model->save();

        return response()->json([
            'status'=>200,
            'message'=>'Profile Update',
        ]); 

      }


  }


    public function member_logout(){
      //->cookie('TOKEN_LOGIN','',-1)
            return response()->json([
                'status'=>200,
                'message'=> 'Member Logout',
            ]); 
      }


      public function password_update(request $request){
          $validator=\Validator::make($request->all(),[    
            'old_password'  => 'required',
            'new_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
          ],
          [
            'new_password.regex'=>'password minimum six characters including one uppercase letter, one lowercase letter and one number '
         ]);

          if($validator->fails()){
               return response()->json([
                 'status'=>700,
                 'message'=>$validator->messages(),
              ]);

         }else{
          $member_id=$request->header('member_id');
          $oldpassword=$request->input('old_password');
          $npass=$request->input('new_password');
          $cpass=$request->input('confirm_password');
    
          $data= Member::where('member_password',$oldpassword)->where('id',$member_id)->count('id');
          if($data>=1){
              if($npass==$cpass){
               $student= Member::find($member_id);
              //$student->password=Hash::make($npass);
               $student->member_password=$npass;
               $student->update();
               return response()->json([
                'status'=>200,
                'message'=> 'Passsword change  successfully',
            ]); 
               }else{
                return response()->json([
                    'status'=>600,
                    'message'=> 'New Passsword & Confirm Passsword is not match',
                ]); 
               }  
          }else{
          
           return response()->json([
            'status'=>400,
            'message'=> 'Invalid Old Password',
        ]); 
          } 
          
        }
     }


      public function category_show(request $request,$username){
          $data=APP::where('admin_name',$username)->where('status',1)->orderBy('id', 'desc')->get();
          return response()->json([
            'status'=>200,
            'data'=>$data,
        ]); 

      }


      public function invoice_create(request $request,$username){

        $member_id=$request->header('member_id');
         $validator=\Validator::make($request->all(),[    
          'category_id'  => 'required',
        ]
       );
       
        if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);

       }else{
         $admin= Admin::where('admin_name',$username)->select('id','name','nameen','address','email',
        'mobile','admin_name','header_size','resheader_size','getway_fee')->first();
          $category=App::where('admin_name',$username)->where('status',1)->where('id',$request->category_id)->first();
          if($category){

            $verify= Member::where('member_verify',1)->where('id',$member_id)->count('id');
            $total_amount=$category->amount+($category->amount*$admin->getway_fee)/100;

            if($verify>=1){
            $model= new Invoice;
            $model->admin_name=$username;
            $model->member_id=$member_id;
            $model->category_id=$request->category_id;
            $model->amount=$category->amount;
            $model->getway_fee=$admin->getway_fee;
            $model->total_amount=$total_amount;
            $model->save();

            return response()->json([
               'status'=>200,
               'message'=>"Invoice Create Successfull",
           ]); 

          }else{
            return response()->json([
              'status'=>400,
              'message'=>"Memebr Verify Pending . Please Contact Authority",
          ]); 
          }

          }else{
            return response()->json([
              'status'=>300,
              'message'=>"Payment category Invalid",
          ]); 
          }
        
       }

      }

      public function invoice_view(request $request,$username){
           $member_id=$request->header('member_id');
           $data=Invoice::where('member_id',$member_id)
           ->leftjoin('apps','apps.id','=','invoices.category_id')->get();

           return response()->json([
            'status'=>200,
            'data'=>$data,
        ]); 
      }
  
    


}
