 @extends('user.layouts.master')
 @section('content')
 <div class="page-header">
   <div class="row align-items-end">
     <div class="col-lg-8">
       <div class="page-header-title">
         <div class="d-inline">
           <h4>SMS</h4>
         </div>
       </div>
     </div>
     <div class="col-lg-4">
       <div class="page-header-breadcrumb">
         <ul class="breadcrumb-title">
           <li class="breadcrumb-item">
             <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
           </li>
           <li class="breadcrumb-item"><a href="#!">SMS</a>
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
           <h4 class="sub-title">Create SMS</h4>
           <form class="form form-horizontal" action="{{ route('user.message.store') }}" novalidate method="post" enctype="multipart/form-data">
             {{ csrf_field() }}
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">From *</label>
               <div class="col-sm-6">
                 <select class="form-control" name="from" value="{{ old('from') }}" id="from">
                   <option value="">-- Select --</option>
                   @foreach($contacts as $contact) 
                      <option {{ old('from') == $contact ? 'selected' : '' }} value="new">{{ $contact }}</option> 
                   @endforeach
                 </select>
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('from'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("from") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">To *</label>
               <div class="col-sm-6">
                 <select class="form-control" name="to" value="{{ old('to') }}" id="to"> 
                   <option value="">-- Select --</option>
                   @foreach($contacts as $contact) 
                      <option {{ old('to') == $contact ? 'selected' : '' }} value="new">{{ $contact }}</option> 
                   @endforeach
                 </select>
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('to'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("to") }}
                 </div>
                 @endif
               </div>
             </div>
             <div class="form-group row">
               <label class="col-sm-2 col-form-label">Type *</label>
               <div class="col-sm-6">
                 <select class="form-control" name="type" value="{{ old('type') }}" id="type" onchange="checkType()">
                   <option {{ old('type') == 'new' ? 'selected' : '' }} value="new">Create New</option>
                   <option {{ old('type') == 'template' ? 'selected' : '' }} value="template">Pick a Template</option>
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
             <div class="form-group row" id="body_div">
               <label class="col-sm-2 col-form-label">Body *</label>
               <div class="col-sm-6">
                 <textarea class="form-control" name="body" id="body" rows="3" style="resize:none;" placeholder="Enter your message"></textarea>
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('body'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("body") }}
                 </div>
                 @endif
               </div>
             </div> 
             <div class="form-group row" id="template_div">
               <label class="col-sm-2 col-form-label">Template *</label>
               <div class="col-sm-6">
                 <select class="form-control" name="template" id="template">
                   <option value="">-- Select Template --</option>
                   @foreach($templates as $template)
                   <option {{ old('template') == $template->id ? 'selected' : ''}} value="{{ $template->id }}">{{ $template->name }}</option>
                   @endforeach
                 </select>
                 <div class="help-block"></div>
                 {{--Error Alert --}}
                 @if ($errors->has('template'))
                 <div class="alert alert-danger mb-2" role="alert">
                   <strong>Error!</strong> {{ $errors->first("template") }}
                 </div>
                 @endif
               </div>
             </div> 
             <br>
             <div class="form-group">
               <div class="col-lg-offset-4 col-lg-8">
                 <a href="{{ route('user.messages') }}" class="btn btn-inverse" type="button">Cancel</a>
                 <button class="btn btn-primary" type="submit">Send</button>
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
     if (type == 'template') {
       $('#body_div').slideUp();
       $('#template_div').slideDown();
     } else {
       $('#template_div').slideUp();
       $('#body_div').slideDown();
     }
   });
   function checkType() {
     var type = $('#type').val();
     if (type == 'template') {
       $('#body_div').slideUp();
       $('#template_div').slideDown();
     } else {
       $('#template_div').slideUp();
       $('#body_div').slideDown();
     }
   } 
 </script>
 @endsection