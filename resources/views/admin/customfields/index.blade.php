@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.customfield.create') }}" class="btn btn-primary pull-right">Add Custom Fields</a>
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
                                <th> Type </th>
                                <th> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customfields as $customfield)
                                    <tr>
                                        <td class="text-center">{{ $customfield->id }}</td>
                                        <td class="text-center">{{ $customfield->name }}</td>
                                        <td class="text-center">{{ $customfield->type }}</td>
                                        <td class="text-center">
                                            @if ($customfield->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.customfield.edit', $customfield->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.customfield.delete', $customfield->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                @if ($customfield->type != 'text' && $customfield->type != 'textarea')
                                                    <a href="{{ route('admin.customfield.options', $customfield->id) }}" class="btn btn-sm btn-info"><i class="fa fa-cog"></i>Options</a>
                                                @endif
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