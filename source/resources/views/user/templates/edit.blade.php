 @extends('user.layouts.master')
 @section('content')
 <div class="page-header">
   <div class="row align-items-end">
     <div class="col-lg-8">
       <div class="page-header-title">
         <div class="d-inline">
           <h4>Templates</h4>
         </div>
       </div>
     </div>
     <div class="col-lg-4">
       <div class="page-header-breadcrumb">
         <ul class="breadcrumb-title">
           <li class="breadcrumb-item">
             <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
           </li>
           <li class="breadcrumb-item"><a href="#!">Templates</a>
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
           <h4 class="sub-title">Edit Template</h4>
           <form class="form form-horizontal" action="{{ route('user.template.update', $template->id) }}" novalidate method="post" enctype="multipart/form-data">
             {{ csrf_field() }}
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">Title * </label>
               <div class="col-sm-6">
                 <input class="form-control" name="name" placeholder="Enter Name" value="{{ old('name', $template->name) }}" type="text" id="name">
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
               <label class="col-sm-2 col-form-label">Body * </label>
               <div class="col-sm-6">
                 <input class="form-control" name="body" placeholder="Enter Body" value="{{ old('body', $template->body) }}" type="text" id="body">
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('body'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("body") }}
                 </div>
                 @endif
               </div>
             </div> 
             <br>
             <div class="form-group">
               <div class="col-lg-offset-4 col-lg-8">
                 <a href="{{ route('user.templates') }}" class="btn btn-inverse" type="button">Cancel</a>
                 <button class="btn btn-primary" type="submit">Save</button>
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