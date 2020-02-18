 @extends('admin.layouts.master')
 @section('content')
 <div class="page-header">
     <div class="row align-items-end">
         <div class="col-lg-8">
             <div class="page-header-title">
                 <div class="d-inline">
                     <h4>Settings</h4>
                 </div>
             </div>
         </div>
         <div class="col-lg-4">
             <div class="page-header-breadcrumb">
                 <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                         <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#!">Settings</a>
                     </li>
                     <li class="breadcrumb-item"><a href="#!">Edit</a>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
 </div>
 <div class="page-body">

     @include('layouts.flash_messages')
     <div class="row">
         <div class="col-sm-12">
             <!-- Basic Form Inputs card start -->
             <div class="card">
                 <div class="card-block">
                     <h4 class="sub-title">Edit Settings</h4> 
                     <form class="form form-horizontal" action="{{ route('admin.settings.update') }}" novalidate method="post" enctype="multipart/form-data">
                         {{ csrf_field() }}

                         <div class="form-group row">
                             <label class="col-sm-2 col-form-label">Account SID * </label>
                             <div class="col-sm-6">
                                 <input class="form-control" name="sid" placeholder="Enter Account SID" value="{{ old('sid', $setting->sid) }}" type="text" id="sid">
                                 <div class="help-block"></div>
                                 {{--Error Alert --}}
                                 @if ($errors->has('sid'))
                                 <div class="alert alert-danger mb-2" role="alert">
                                     <strong>Error!</strong> {{ $errors->first("sid") }}
                                 </div>
                                 @endif
                             </div>
                         </div>
                         <div class="form-group row">
                             <label class="col-sm-2 col-form-label">Auth Token *</label>
                             <div class="col-sm-6">
                                 <input class="form-control" name="token" placeholder="Enter Auth Token" value="{{ old('token', $setting->token) }}" type="password" id="token">
                                 <div class="help-block"></div>
                                 {{--Error Alert --}}
                                 @if ($errors->has('token'))
                                 <div class="alert alert-danger mb-2" role="alert">
                                     <strong>Error!</strong> {{ $errors->first("token") }}
                                 </div>
                                 @endif
                             </div>
                         </div> 
                         <br>
                         <div class="form-group">
                             <div class="col-lg-offset-4 col-lg-8">
                                 <a href="{{ route('admin.users') }}" class="btn btn-inverse" type="button">Cancel</a>
                                 <button class="btn btn-primary" type="submit">Sumbit</button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>

         </div>

     </div>
 </div>
 @endsection

 @section('js-script')

 @endsection