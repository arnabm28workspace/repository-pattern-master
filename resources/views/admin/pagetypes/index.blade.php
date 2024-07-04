@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <!-- <a href="{{-- route('admin.pagetypes.create') --}}" class="btn btn-primary pull-right">Add Page Type</a> -->
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th> Name </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagetypes as $key => $pagetype)
                                    <tr>
                                        <td>{{ ($key + 1) }}</td>
                                        <td>{{ $pagetype->name }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.pagetypes.edit', $pagetype->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.pagetypes.delete', $pagetype->id) }}" class="btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
@endpush