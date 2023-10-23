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
   
    public function index(){
        return view('admin.notice');
    }

    public function fetch(){
      if(Session::has('admin')){
      $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
      $data=DB::table('notices')->where('admin_name',$admin->admin_name)->orderBy('serial', 'asc')->paginate(10);
      return view('admin.notice_data',compact('data'));
      }
   }



    function fetch_data(Request $request)
    {
     if($request->ajax())
     {
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype'); 
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
      $data = DB::table('notices')
                    ->where('serial', 'like', '%'.$search.'%')
                    ->orWhere('title', 'like', '%'.$search.'%')
                    ->orWhere('text', 'like', '%'.$search.'%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(5);
      return view('admin.notice_data', compact('data'))->render();
     }
    }




    public function notice_create ()
    {
        return view('admin.notice_create');
    }


    public function store(Request $request) {

       $text = $request->text;
    

      if(Session::has('admin')){
        $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
      }


    Notice::create([
        'serial' => '1',
        'date' => $request->date,
        'category' => $request->category,
        'admin_name' => $admin->admin_name,
        'title' => $request->title,
        'text' => $text
    ]);

    return redirect('/admin/notice')->with('success','Data Added  successfully');
       
     }


     public function view($id)
     {
         $data = Notice::find($id);
         return view('admin.notice_view',['data'=>$data]);
     }


     public function edit($id)
     {
         $data = Notice::find($id);
         return view('admin.notice_edit',compact('data'));
     }

     public function update(Request $request, $id)
     {

       $notice = Notice::find($id);
       $text = $request->text;
      
       $notice->update([
        'date' => $request->date,
        'category' => $request->category,
        'title' => $request->title,
        'text' => $text
      ]);

      return redirect('/admin/notice')->with('success','Data Updated  successfully');

   }


   public function destroy($id)
   {
       $post = Notice::find($id);  
       
       $post->delete();
       return redirect('/admin/notice')->with('success','Data Deleted  successfully');

   }


      

}
