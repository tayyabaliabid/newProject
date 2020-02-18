@extends('admin.layouts.master')
@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Numbers</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Numbers</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Search</a>
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
                    <h4 class="sub-title">Search</h4>
                    <form action="{{route('admin.number.search')}}" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12" for="country">Country</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <select class="form-control m-input" id="country" name="country">
                                    <option value="US" {{ (old('country') == 'US' ? "selected":"") }}>
                                        United States
                                    </option>
                                </select>
                                @if ($errors->has('country') )
                                <div class="alert alert-danger mb-2" role="alert">
                                    <strong>Error!</strong> {{ $errors->first("country") }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12" for="areaCode">Area Code</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input" id="areaCode" name="areaCode" value="{{ old('areaCode') }}" autocomplete="off" placeholder="Search number by its area code">

                                @if ($errors->has('areaCode') )
                                <div class="alert alert-danger mb-2" role="alert">
                                    <strong>Error!</strong> {{ $errors->first("areaCode") }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <style>
                            .checkbox {
                                width: 15px;
                                height: 15px;
                                margin: 5px;
                                margin-top: 10px;
                                border: 0px;
                                outline: 0px;
                                display: inline-block;
                            }

                            #caps label {
                                margin-top: -10px;
                            }

                            #type label {
                                margin-top: -10px;
                            }
                        </style>
                        <input name="voice" type="hidden" value="true">
                        <input name="sms" type="hidden" value="false">
                        <input name="mms" type="hidden" value="false">
                        <input name="type" type="hidden" value="local">
                        <!-- <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12" for="call">Capabilities</label>
                                <div class="col-lg-4 col-md-9 col-sm-12" id="caps">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input name="voice" type="hidden" value="true">
                                            <input name="sms" type="hidden" value="false">
                                            <input name="mms" type="hidden" value="false">
                                            <input class="checkbox" name="voice" type="checkbox" id="voice" value="true" {{ old('voice')? 'checked':'' }} checked><label for="voice">Voice</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="checkbox" name="sms" type="checkbox" id="SMS" value="true" {{ old('sms')? 'checked':'' }}><label for="SMS">SMS</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="checkbox" name="mms" type="checkbox" id="MMS" value="true" {{ old('mms')? 'checked':'' }}><label for="MMS">MMS</label>
                                        </div>
                                    </div>
                                    @if( $errors->has('voice'))
                                    <span class="m-form__help text-danger">{{ $errors->first('voice') }}</span>
                                    @endif
                                    @if( $errors->has('sms'))
                                    <span class="m-form__help text-danger">{{ $errors->first('sms') }}</span>
                                    @endif
                                    @if( $errors->has('mms'))
                                    <span class="m-form__help text-danger">{{ $errors->first('mms') }}</span>
                                    @endif
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12" for="type">Type </label>
                                    <div class="col-lg-4 col-md-9 col-sm-12" id="type">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input class="checkbox" name="type" type="radio" id="local" value="local" checked="checked"><label for="local">Local</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="checkbox" name="type" type="radio" id="TollFree" value="tollFree"><label for="TollFree">TollFree</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                        <div class="form-group row">
                            <div class="col-lg-offset-4 col-lg-8">
                                <a href="{{ route('admin.users') }}" class="btn btn-inverse" type="button">Cancel</a>
                                <button class="btn btn-primary" type="submit">Search</button>
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