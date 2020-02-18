 @extends('admin.layouts.master')
 @section('content')
 <div class="page-header">
   <div class="row align-items-end">
     <div class="col-lg-8">
       <div class="page-header-title">
         <div class="d-inline">
           <h4>Users</h4> 
         </div>
       </div>
     </div>
     <div class="col-lg-4">
       <div class="page-header-breadcrumb">
         <ul class="breadcrumb-title">
           <li class="breadcrumb-item">
             <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
           </li>
           <li class="breadcrumb-item"><a href="#!">Users</a>
           </li>
           <li class="breadcrumb-item"><a href="#!">Create</a>
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
           <h4 class="sub-title">Create User</h4>

           <form class="form form-horizontal" action="{{ route('admin.user.store') }}" novalidate method="post" enctype="multipart/form-data">
             {{ csrf_field() }}

             <div class="form-group row">
               <label class="col-sm-2 col-form-label">Name * </label>
               <div class="col-sm-6">
                 <input class="form-control" name="name" placeholder="Enter Name" value="{{ old('name') }}" type="text" id="name">
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('name'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("name") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">E-MAIL *</label>
               <div class="col-sm-6">
                 <input class="form-control" name="email" placeholder="Enter Email" value="{{ old('email') }}" type="text" id="email">
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('email'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("email") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">PHONE * </label>
               <div class="col-sm-6">
                 <input class="form-control" name="phone" placeholder="Enter Phone" value="{{ old('phone') }}" type="text" id="phone">
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('phone'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("phone") }}
                 </div>
                 @endif
               </div>
             </div> 
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">PASSWORD * </label>
               <div class="col-sm-6">
                 <input class="form-control" name="password" placeholder="Enter Password" value="{{ old('password') }}" type="text" id="password">
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('password'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("password") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">STATUS * </label>
               <div class="col-sm-6">
                 <select id="status" name="status" class="form-control">
                   <option value="">Select</option>
                   <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Active</option>
                   <option {{ old('status') == '0' ? 'selected' : '' }} value="0">In-Active</option>
                 </select>

                 {{--Error Alert --}}
                 @if ($errors->has('status') )
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("status") }}
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