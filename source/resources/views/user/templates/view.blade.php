@extends('user.layouts.master')
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
                    <li class="breadcrumb-item"><a href="#!">View</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Contacts</a>
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
                    <h4 class="sub-title">All Contacts</h4>

                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Number</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $contact)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ ++$counter}}</td>
                                    <td>{{ $contact->number }}</td> 
                                    <td> 
                                        <a href="{{ route('user.contact.destroy', $contact->id) }}" title="Delete Contact"><span class="feather icon-trash"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Number</th> 
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $contacts->links() }}
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