@extends('admin.layouts.master')
@section('title','Edit Number URLS')
@section('page_styles')
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}"> -->
@endsection

@section('page_heading','Edit Number URLS')

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
                        <span class="m-nav__link-text">Edit Number URLS</span>
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
    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Edit Number URLS
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
<?php //print_r($user->email);exit?>
        <!--begin::Form-->
        <form action="{{route('number.update',$number->id)}}" method="post" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="sid" value="{{$number->sid}}" />
            <div class="m-portlet__body">

                
                <div class="form-group m-form__group row {{ $errors->has('number') ? ' has-danger' : '' }}">
                    <label class="col-form-label col-lg-3 col-sm-12" for="number">Number</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="text" class="form-control m-input" readonly id="number" readonly disabled name="number" value="{{$number->number}}">
                        @if( $errors->has('number'))
                        <span class="m-form__help text-danger">{{ $errors->first('number') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group m-form__group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label class="col-form-label col-lg-3 col-sm-12" for="name">Friendly Name</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="text" class="form-control m-input" id="name" name="name" value="{{$number->name}}">
                        @if( $errors->has('name'))
                        <span class="m-form__help text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group m-form__group row {{ $errors->has('url') ? ' has-danger' : '' }}">
                    <label class="col-form-label col-lg-3 col-sm-12" for="url">Voice URL</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="text" class="form-control m-input" id="url" name="url" value="{{$number->url}}" placeholder="Place Following Url here">
                        <span><strong>Application Voice Url</strong>: {{ route('call.inbound') }} </span>
                        @if( $errors->has('url'))
                        <span class="m-form__help text-danger">{{ $errors->first('url') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group m-form__group row {{ $errors->has('statusUrl') ? ' has-danger' : '' }}">
                    <label class="col-form-label col-lg-3 col-sm-12" for="statusUrl">Status CallBack URL</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="text" class="form-control m-input" id="statusUrl" name="statusUrl" value="{{$number->statusUrl}}" placeholder="Place Following Url here">
                        <span><strong>Application Status CallBack Url</strong>: {{ route('call.inbound.statusCallback') }} </span>
                        @if( $errors->has('statusUrl'))
                        <span class="m-form__help text-danger">{{ $errors->first('statusUrl') }}</span>
                        @endif
                    </div>
                </div>


            </div>
            {{--Update--}}
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{route('number.index')}}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->
</div>

@endsection


@section('page_scripts')
    <script src="{{ asset('assets/assets/demo/default/custom/crud/forms/validation/form-controls.js') }}" type="text/javascript"></script>
@endsection

