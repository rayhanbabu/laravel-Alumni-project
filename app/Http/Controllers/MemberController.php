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
use Illuminate\Support\Facades\Hash;
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
             'gender' =>'required',
             'country' =>'required',
             'city' => 'required',
             'occupation' => 'required',
             'member_password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
             'phone' => 'required||min:11|unique:members,phone',
             'email' => 'required|unique:members,email',
             'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:412000',
             'certificate_image' => 'required|mimes:jpeg,png,jpg,pdf|max:812000',
            ],
            [
               'member_password.regex'=>' '
            ]
        );
          
    if($admin){
      if($validator->fails()){
         return response()->json([
             'status'=>700,
             'errors'=>$validator->messages(),
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
       
      
         if($request->hasfile('profile_image')){
           $file=$_FILES['profile_image']['tmp_name'];
           $hw=getimagesize($file);
           $w=$hw[0];
           $h=$hw[1];	 
              if($w<310 && $h<310){
               $image= $request->file('profile_image'); 
               $file_name = 'profile'.rand() . '.' . $image->getClientOriginalExtension();
               $image->move('uploads/admin', $file_name);
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
                 $image1->move('uploads/admin', $file_name1);
                 $model->certificate_image=$file_name1;
              }
         $model->save();

         $email=$request->input('email');
         $rand=rand(11111,99999);
         $subject='verify your Email ';  
         $title='Dear,  '.$request->input('name');
         $body='Please Click URL and verify your email to complete your account setup.';
         $link=URL::to('email_verify/'.md5($request->input('email')));
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



      public function email_verify($emailmd5){
        $data=Member::where('emailmd5',$emailmd5)->first();
       if($data){
        if($data->email_verify==1){
              return response()->json([
                 'status'=>400,  
                 'message'=>'E-mail already verified',
               ]);
           }else{
               DB::update(
                "update members set email_verify ='1' where emailmd5 = '$emailmd5'"
               );
               return response()->json([
                'status'=>200,  
                'message'=>'E-mail verify Successfull',
              ]);
          }
        }else{
              return response()->json([
                'status'=>600,  
                'message'=>'Invalid Email',
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
    
    
                 return response()->json([
                     'status'=>200,
                      'message'=> 'Recovery code send your E-mail',
                  ]); 
            }else{
                return response()->json([
                    'status'=>600,
                     'massage'=> 'Invalid  Email ',
               ]); 
            }   


         }


         public function forget_code(request $request){
          $email=$request->email;
          $code=$request->forget_code;
          $email_exist=Member::where('email',$email)->count('email');
         if($email_exist>=1 OR $code>11){
            $code_exist=Member::where('email',$email)->where('forget_code',$code)->count('email');
             if($code_exist>=1){
                 return response()->json([
                     'status'=>200,
                      'message'=> 'Code Match',
                 ]); 

             }else{
              return response()->json([
                 'status'=>500,
                 'message'=> 'Invalid Recovery Code',
            ]); 
             }
            
          }else{
              return response()->json([
                  'status'=>600,
                   'massage'=> 'Invalid  Email Or Code ',
             ]); 
          }   


       }

       public function confirm_password(request $request){

        $validator=\Validator::make($request->all(),[       
              'new_password' => 'required',
         ]);

         if($validator->fails()){
          return response()->json([
            'status'=>700,
            'validate_err'=>$validator->messages(),
          ]);
        }else{
  
        $email=$request->email;
        $code=$request->forget_code;
        $new_password=$request->new_password;
        $code_exist=Member::where('email',$email)->where('forget_code',$code)->count('email');

         if($code_exist>=1){
           DB::update(
              "update members set member_password ='$new_password', forget_code ='45ftret56' where email = '$email'"
            );

             return response()->json([
                'status'=>500,
                'errors'=> 'Password Change Successfull',
             ]); 
    
        }else{
            return response()->json([
               'status'=>600,
               'errors'=> 'Invalid Access',
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
                 'status'=>400,
                 'validate_err'=>$validator->messages(),
              ]);
         }else{
          $status=1;
          $member=Member::where('email',$request->email)->first();
          if($member){
                   if($member->member_password==$request->member_password){
                      if($member->member_verify==$status){
                        $token=MaintainJWTToken::CreateToken($member->email,$member->id,$member->admin_name);
                        //Cookie::queue('token_login',$token,60*24);
                    return response()->json([
                        'status'=>200,
                        'message'=> 'success login',
                        'TOKEN_LOGIN'=>$token,
                      ])->cookie('TOKEN_LOGIN',$token,60*24*30);   
                           
                       }else{
                          return response()->json([
                             'status'=>700,
                             'errors'=> 'Acount Inactive',
                          ]); 
                       }    
                   }else{
                     return response()->json([
                        'status'=>600,
                        'errors'=> 'Invalid Password',
                     ]); 
                   }
          }else{
             return response()->json([
                  'status'=>500,
                  'errors'=> 'Invalid Email',
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


    public function member_logout(){
         
            return response()->json([
                'status'=>500,
                'errors'=> 'Member Logout',
            ])->cookie('TOKEN_LOGIN','',-1); 
      }


      public function password_update(request $request){

      

          $validator=\Validator::make($request->all(),[    
            'old_password'  => 'required',
            'new_password'  => 'required',
            'confirm_password'  => 'required',
          ],
           [
            'old_password.required'=>'Old Password is required',
          ]);

          if($validator->fails()){
               return response()->json([
                 'status'=>400,
                 'validate_err'=>$validator->messages(),
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
                    'status'=>500,
                    'message'=> 'New Passsword & Confirm Passsword is not match',
                ]); 
               }  
          }else{
          
           return response()->json([
            'status'=>500,
            'message'=> 'Invalid Old Password',
        ]); 
          } 
          
        }
     }
  
    


}
