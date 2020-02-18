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
                    <li class="breadcrumb-item"><a href="#!">Manage</a>
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
                    <h4 class="sub-title">All Numbers</h4>

                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <th>Sr #</th>
                                <th>Phone Number</th>
                                <th>Friendly Name</th> 
                                <th>Created At</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php($counter=0)
                                @foreach($numbers as $number)
                                <tr>
                                    <td>{{ ++$counter }}</td>
                                    <td>{{$number->number}}</td>
                                    <td>{{$number->name}}</td> 
                                    <td>{{$number->created_at}}</td>
                                    <td nowrap="">
                                        <span class="dropdown">
                                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                <i class="la la-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item" onclick="return VerifyDelete({{ $number->id }});"><i class="la la-edit"></i>
                                                    Delete Number</a>
                                            </div>

                                        </span>
                                        <a href="{{ route('number.edit',$number->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <form id="delform{{$number->id}}" action="{{ route('number.destroy',$number->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Phone Number</th>
                                    <th>Friendly Name</th> 
                                    <th>Created At</th>
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
    
    function VerifyDelete(id) {
        if (confirm("Are You Sure You want to Delete")) {
            event.preventDefault();
            document.getElementById('delform' + id).submit();
        }
    }

    $('#simpletable').DataTable({
        responsive: true,
        ordering: true,
        paging: false,
        info: false,
        searching: false
    });
</script>
@endsection 