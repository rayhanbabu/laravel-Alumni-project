@extends('admin/dashboardheader')
@section('page_title','Language Change Home Page')
@section('lang_select','active')
@section('content')

                <h4 class="mt-4">Language Change</h4>
                     <ol class="breadcrumb mb-4">
                          <li class="breadcrumb-item active">Click Banga English</li>
                     </ol>
                    
                     <ul>
                         @foreach($test as $row)
                             <li> {!!$row->lang!!}</li>
                             <li> {!!$row->text!!}</li>
                             <li> {!!$row->name!!}</li>
                             <li> {!!$row->desig!!}</li>
                             <hr>
                          @endforeach
                         
                     </ul>


@endsection