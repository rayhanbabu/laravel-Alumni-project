<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Collection;
use App\Models\Magazine;
use DB;
use Session;
use PDF;

class FinanceController extends Controller
{
   
    public function index($member) {
        return view('admin.finance',['member'=>$member]);
    }

   public function store(Request $request){

    if(Session::has('admin')){
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
   
    $validator=\Validator::make($request->all(),[
             
      'des' => 'required',
      'date' => 'required',
      'amount' => 'required',
      'cetagory' => 'required',
      
 ]);

   if($validator->fails()){
     return response()->json([
       'status'=>700,
       'validate_err'=>$validator->messages(),
   ]);
   }else{
     
    $data= Finance::where('admin_name',$admin->admin_name)->where('cetagory',$request->input('cetagory'))->count('id');
    if($data>=50){  
      return response()->json([
        'status'=>600,
        'errors'=> 'Row Insert Permision is '.$data. '. More Details Contact service Provider',
     ]);

    }else{
             $text= new Finance;
             $text->admin_name=$admin->admin_name;
             $text->name=$request->input('name');
             $text->cetagory=$request->input('cetagory');
             $text->des=$request->input('des');
              $text->phone=$request->input('phone');
             $text->email=$request->input('email');
             $text->amount=$request->input('amount');
             $text->date=$request->input('date');
             $text->save();

       return response()->json([
        'status'=>400,  
        'message'=>'Inserted Data',
      ]);
     }

    }
  }

   }




    
   public function fetchAll($member) {
    if(Session::has('admin')){
    $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
    $data = Finance::where('admin_name',$admin->admin_name)->where('cetagory',$member)->get();
    $output=' <h5 class="text-success"> Total Row : '.$data->count().' </h5>';	
    if ($data->count()> 0) {
       $output .= '<table class="table table-bordered table-sm text-start align-middle">
       <thead>
         <tr>
            <th>Date</th>
            <th>Name </th>
             <th>Phone/E-mail</th>
            <th>Payment Method</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Invoice</th>
            <th>Action</th>
            <th>Created_at</th>
            <th>Updated_at </th>
         </tr>
       </thead>
       <tbody>';
       foreach ($data as $row) {

      

           $output .= '<tr>
           <td>' . $row->date . '</td>
           <td>' . $row->name . '</td>
           <td>' . $row->phone . '</td>
           <td>' . $row->email . '</td>
           <td>' . $row->des . '</td>
           <td>' . $row->amount . '</td>
        
           <td>  <a href="/invoiceprint/' . $row->id . '" class="btn btn-success btn-sm mx-1 ">Invoice </a> </td>
           <td>
           <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

           <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
         </td>
         <td>' . $row->created_at. '</td>
         <td>' . $row->updated_at . '</td>
     </tr>';
     }
       $output .= '</tbody></table>';
       echo $output;
    } else {
       echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
    }
  }
}


public function edit(Request $request) {
  $id = $request->id;
  $data = Finance::find($id);
  return response()->json([
    'status'=>200,  
    'data'=>$data,
  ]);
}

public function update(Request $request){
           
      
  $text=Finance::find($request->input('edit_id'));
  if($text){
       $text->name=$request->input('name');
       $text->phone=$request->input('phone');
      $text->email=$request->input('email');
       $text->des=$request->input('des');
      $text->amount=$request->input('amount');
       $text->date=$request->input('date');
      $text->update();
         
      return response()->json([
          'status'=>400,
        'message'=>'Data Updated'
      ]);
  }else{
      return response()->json([
          'status'=>404,  
          'message'=>'Student not found',
        ]);
  }
}


public function delete(Request $request) {
  $text=Finance::find($request->input('id'));
  $text->delete();
  return response()->json([
     'status'=>200,  
     'message'=>'Deleted Data',
   ]);
}


public function financepdf(Request $request){
    $monthyear=$request->input('month');
    $cetagory=$request->input('cetagory');
    if(Session::has('admin')){

     $file='Finance_'.$cetagory.'.pdf';
     $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
     $data=DB::select( "select * FROM `finances`  WHERE 
         DATE_FORMAT(date,'%Y-%m')='$monthyear' AND admin_name='$admin->admin_name' AND cetagory='$cetagory' order by id ");


    $pdf = PDF::loadView('pdf.financepdf',[
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
       'data' => $data,
       'cetagory' => $cetagory,
   ]);

   return $pdf->stream('financepdf.pdf');
   //return $pdf->download('pdf-file.pdf');
  }
}


public function invoiceprint(Request $request ,$id){
  
  if(Session::has('admin')){

   $file='Finance_'.$id.'.pdf';
   $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->first();
   $data = Finance::where('admin_name',$admin->admin_name)->where('id',$id)->first();
   $logu = Magazine::where('category','Slide')->where('text4','Logu')->where('admin_name',$admin->admin_name)->first();

  $pdf = PDF::loadView('pdf.invoiceprint',[
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
     'data' => $data,
     'logu' => $logu,
     
 ]);

 return $pdf->stream($file);
 //return $pdf->download('pdf-file.pdf');
}
}






}
