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
               <h4 class="sub-title">Create Template</h4>
               <form class="form form-horizontal" action="{{ route('user.template.store') }}" novalidate method="post" enctype="multipart/form-data">
                 {{ csrf_field() }}
                 <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Name *</label>
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
                   <label class="col-sm-2 col-form-label">Body *</label>
                   <div class="col-sm-6">
                     <textarea name="body" class="form-control" rows="3" style="resize:none;" placeholder="Enter Body">{{ old('body') }}</textarea>
                     <div class="help-block"></div>
                     {{--Error Alert --}}
                     @if ($errors->has('file'))
                     <div class="alert alert-danger mb-2" role="alert">
                       <strong>Error!</strong> {{ $errors->first("file") }}
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
 <script>
   $(document).ready(function() {
     var type = $('#type').val();
     if (type == 'existing') {
       $('#create_new').slideUp();
       $('#existing').slideDown();
     } else {
       $('#existing').slideUp();
       $('#create_new').slideDown();
     }
   });

   function checkType() {
     var type = $('#type').val();
     if (type == 'existing') {
       $('#create_new').slideUp();
       $('#existing').slideDown();
     } else {
       $('#existing').slideUp();
       $('#create_new').slideDown();
     }
   }
 </script>
 @endsection