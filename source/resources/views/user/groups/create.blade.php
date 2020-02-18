 @extends('user.layouts.master')
 @section('content')
 <div class="page-header">
   <div class="row align-items-end">
     <div class="col-lg-8">
       <div class="page-header-title">
         <div class="d-inline">
           <h4>Groups</h4>
         </div>
       </div>
     </div>
     <div class="col-lg-4">
       <div class="page-header-breadcrumb">
         <ul class="breadcrumb-title">
           <li class="breadcrumb-item">
             <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
           </li>
           <li class="breadcrumb-item"><a href="#!">Groups</a>
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
           <h4 class="sub-title">Create Group</h4>
           <form class="form form-horizontal" action="{{ route('user.group.store') }}" novalidate method="post" enctype="multipart/form-data">
             {{ csrf_field() }}
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">Type *</label>
               <div class="col-sm-6">
                 <select class="form-control" name="type" value="{{ old('type') }}" id="type" onchange="checkType()">
                   <option {{ old('type') == 'new' ? 'selected' : '' }} value="new">Create New</option>
                   <option {{ old('type') == 'existing' ? 'selected' : '' }} value="existing">Existing</option>
                 </select>
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('type'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("type") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row" id="existing" style="display:none">
               <label class="col-sm-2 col-form-label">Title *</label>
               <div class="col-sm-6">
                 <select class="form-control" name="existing_name" id="existing_name">
                   <option value="">--Select Group--</option>
                   @foreach($groups as $group)
                   <option {{ old('existing_name') == $group->id ? 'selected' : ''}} value="{{ $group->id }}">{{ $group->name }}</option>
                   @endforeach
                 </select>
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('existing_name'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("existing_name") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row" id="create_new">
               <label class="col-sm-2 col-form-label">Title new *</label>
               <div class="col-sm-6">
                 <input class="form-control" name="new_name" placeholder="Enter Title" value="{{ old('new_name') }}" type="text" id="new_name">
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('new_name'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("new_name") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">Upload File</label>
               <div class="col-sm-6">
                 <input type="file" name="file" class="form-control">
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
                 <a href="{{ route('user.groups') }}" class="btn btn-inverse" type="button">Cancel</a>
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
   $(document).ready(function(){
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