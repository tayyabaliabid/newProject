@extends('admin.layouts.master')
@section('css-script')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/data-table/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

@endsection
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
                    <li class="breadcrumb-item"><a href="#!">Result</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            @include('layouts.flash_messages')
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">Result</h4>

                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap"> 
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Friendly Name</th>
                                        <th>Number</th>
                                        <!-- <th>SMS Enabled</th>
                                        <th>Voice Enabled</th>
                                        <th>MMS Enabled</th> -->
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0; @endphp
                                    @foreach($numbers as $number)
                                    <tr> 
                                        <td>{{ ++$counter }}</td>
                                        <td>{{$number->friendlyName}}</td>
                                        <td>{{$number->phoneNumber}}</td>
                                       
                                        <!-- 
                                            <td>
                                                @if( $number->capabilities['SMS'] == 1 )
                                                <i class="fa fa-check"></i>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if( $number->capabilities['voice'] == 1 )
                                                <i class="fa fa-check"></i>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if( $number->capabilities['MMS'] == 1 )
                                                <i class="fa fa-check"></i>
                                                @else
                                                -
                                                @endif
                                            </td> 
                                        -->

                                        <td>
                                            <form action="{{route( 'admin.number.store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="name" value="{{$number->friendlyName}}" />
                                                <button type="submit" name="number" value="{{ $number->phoneNumber }}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">Purchase</button>
                                            </form>
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Friendly Name</th>
                                        <th>Nmber</th>
                                        <!-- <th>SMS Enabled</th>
                                        <th>Voice Enabled</th>
                                        <th>MMS Enabled</th> -->
                                        <th>Action</th>
                                    </tr>
                                </tfoot> 
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-script') 

<script type="text/javascript" src="{{ asset('bower_components/modernizr/js/css-scrollbars.js') }}"></script>

<!-- data-table js -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script>
    $('#simpletable').DataTable({
        responsive: true,
        ordering: true,
        paging: false,
        info: false,
        searching: false
    });
</script>
@endsection
 