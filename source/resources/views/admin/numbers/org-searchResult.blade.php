@extends('admin.layouts.master')
@section('title','Numbers')
@section('page_styles')

<link href="{{ asset('assets/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page_heading','Manage Numbers')

@section('page_content')

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Numbers</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Numbers</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Purchase Numbers</span>
                    </a>
                </li>
            </ul>
        </div>
        <div>

        </div>
    </div>
</div>

<!-- END: Subheader -->
<div class="m-content">
    @include('admin.layouts.flash_messages')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Purchase Numbers
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{ route('number.index') }}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-reply"></i>
                                <span>Return to Numbers</span>
                            </span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item"></li>

                </ul>
            </div>

        </div>
    <div class="m-portlet__body">

        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
            <thead>
                <tr>
                    <th>Friendly Name</th>
                    <th>Number</th>
                    <th>SMS Enabled</th>
                    <th>Voice Enabled</th>
                    <!-- <th>MMS Enabled</th> -->
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($numbers as $number)
                    <tr>
                        
                        <td>{{$number->FriendlyName}}</td>
                        <td>{{$number->PhoneNumber}}</td>
                        
                        <td>
                            @if( $number->SmsEnabled )
                                <i class="fa fa-check"></i>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if( $number->VoiceEnabled )
                                <i class="fa fa-check"></i>
                            @else
                                -
                            @endif
                        </td>
                        
                        <td>
                            <form action="{{route( 'number.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="name" value="{{$number->FriendlyName}}" />
                            <button type="submit"  name="number" value="{{ $number->PhoneNumber }}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">Purchase</button>
                            </form>
                        </td>                 

                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Friendly Name</th>
                    <th>Nmber</th>
                    <th>SMS Enabled</th>
                    <th>Voice Enabled</th> 
                    <th>Action</th> 
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- END EXAMPLE TABLE PORTLET-->
</div>
@endsection

@section('page_scripts')

<!--begin::Page Vendors -->
<script src="{{ asset('assets/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts -->
<script src="{{ asset('assets/assets/demo/default/custom/crud/datatables/advanced/row-callback.js') }}" type="text/javascript"></script>
<!--end::Page Scripts -->
@endsection