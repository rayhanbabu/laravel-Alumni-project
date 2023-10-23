@extends('admin/dashboardheader')
@section('page_title','Admin Dashboard')
@section('admin_select','active')
@section('content')

                         <h4 class="mt-4 text-center"> {{Session::get('admin')->nameen}}</h4>
                         <h4 class="mt-2 text-center"> {{Session::get('admin')->name}}</h4>
                         <h5 class="mt-2 text-center"> {{Session::get('admin')->address}}</h5>
                          <p class="mt-2 text-center"> UserName :  {{Session::get('admin')->admin_name}}</p>
                          <p class="mt-2 text-center"> Version Type :  {{Session::get('admin')->version_type}}</p>
                        
                       

@endsection