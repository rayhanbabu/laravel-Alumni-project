<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Collection;

use DB;
use Cookie;
use Session;
use DOMDocument;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
   
      public function index(Request $request ,$category){
         return view('admin.notice',['category'=>$category]);
      }

    public function fetch(Request $request,$category){
          $admin_name = $request->header('admin_name'); 
          $admin = Admin::where('admin_name', $admin_name)->first();
          $data=DB::table('notices')->where('admin_name',$admin->admin_name)->where('category',$category)->orderBy('id','desc')->paginate(10);
          return view('admin.notice_data',compact('data'));
     }

    function fetch_data(Request $request,$category)
      {
        $admin_name = $request->header('admin_name'); 
        if($request->ajax())
          {
           $sort_by = $request->get('sortby');
           $sort_type = $request->get('sorttype'); 
              $search = $request->get('search');
              $search = str_replace(" ", "%", $search);
            $data=DB::table('notices')->where('admin_name',$admin_name)
                ->where('category',$category)
               ->where(function($query) use ($search) {
               $query->orwhere('serial', 'like', '%'.$search.'%');
               $query->orWhere('title', 'like', '%'.$search.'%');
               $query->orWhere('text', 'like', '%'.$search.'%');
               $query->orWhere('category', 'like', '%'.$search.'%');
               $query->orWhere('date', 'like', '%'.$search.'%');
              })->orderBy($sort_by, $sort_type)->paginate(10);

          return view('admin.notice_data', compact('data'))->render();
        }
     }


    public function notice_create ($category){
        return view('admin.notice_create',['category' => $category]);
      }


    public function store(Request $request) {
      
         $validated = $request->validate([
             'date'=>'required',
             'text'=>'required',
             'image' =>'mimes:jpeg,png,jpg,pdf|max:500',
             'title'=>'required',
          ]);
         $admin_name = $request->header('admin_name'); 

         $model= new Notice;
         $model->serial=$request->input('serial');
         $model->date=$request->input('date');
         $model->category=$request->input('category');
         $model->admin_name=$admin_name;
         $model->title=$request->input('title');
         $model->text=$request->input('text');

        if($request->hasfile('image')){
            $image= $request->file('image');
            $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin'), $file_name);
            $model->image=$file_name;
         }
        $model->save();
        return redirect()->back()->with('success','Data Added Successfuly');
       
     }


     public function view($category,$id){
         $data = Notice::find($id);
         return view('admin.notice_view',['data'=>$data,'category'=>$category]);
      }


     public function edit($category, $id){
         $data = Notice::find($id);
         return view('admin.notice_edit',['data'=>$data,'category'=>$category]);
     }

     public function update(Request $request, $id) {
        $validated = $request->validate([
            'date'=>'required',
            'text'=>'required',
            'image' =>'image|mimes:jpeg,png,jpg|max:500',
            'title'=>'required',
        ]);

        $model = Notice::find($id);
        $model->serial=1;
        $model->date=$request->input('date');
        $model->title=$request->input('title');
        $model->text=$request->input('text');

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


    public function destroy($id){
        $post = Notice::find($id);  
        $path=public_path('uploads/admin/').$post->image;
         if(File::exists($path)){
            File::delete($path);
          }
         $post->delete();
         return redirect()->back()->with('success','Data Deleted Successfuly');
      }

  }
