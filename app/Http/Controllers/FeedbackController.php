<?php

 namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\validator;
use App\Models\Member;
use Illuminate\Support\Facades\File;

class FeedbackController extends Controller
{
    
    public function issue_index(){
        return view('maintain.issue');
    }

    public function issue_index_admin(){
        return view('admin.issue');
    }

  public function issue_fetch(){

    if(Session::has('admin')){
        $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
    }
     $data=Feedback::leftjoin('members','members.id','=','feedback.member_id')
       ->where('feedback.admin_name',$admin->admin_name)
     ->select('members.member_card','members.name','members.phone','members.email','feedback.*')
     ->orderBy('id', 'desc')->paginate(15);
       return view('maintain.issue_data',compact('data'));
   
   }



function issue_fetch_data(Request $request)
 {
  if($request->ajax())
  {

    if(Session::has('admin')){
        $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
    }
    
   $sort_by = $request->get('sortby');
   $sort_type = $request->get('sorttype'); 
       $search = $request->get('search');
       $search = str_replace(" ", "%", $search);
   $data =Feedback::leftjoin('members','members.id','=','feedback.member_id')
    ->where('feedback.admin_name',$admin->admin_name)
    ->where(function($query) use ($search) {
     $query->orwhere('tran_id', 'like', '%'.$search.'%');
     $query->orWhere('name', 'like', '%'.$search.'%');
     $query->orWhere('email', 'like', '%'.$search.'%');
     $query->orWhere('feedback_status', 'like', '%'.$search.'%');
     $query->orWhere('phone', 'like', '%'.$search.'%');
    })
    ->select('members.member_card','members.name','members.phone','members.email','feedback.*')
    ->orderBy($sort_by, $sort_type)->paginate(15);

      return view('maintain.issue_data', compact('data'))->render();          
   }
}




public function issue_update(Request $request)
{

   $validated = $request->validate([
        'feedback'=>'required',
        'feedback_status'=>'required',
    ]);

   $model = Feedback::find($request->input('id'));
   $model->feedback=$request->input('feedback');
   $model->feedback_status=$request->input('feedback_status');
   $model->updated_by=admin_access()->maintain_name;
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


    
}
