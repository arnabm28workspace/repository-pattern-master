@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-text"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Ad Title</th>
                                <th>Name</th>
                                <th class="align-center"> Amount </th>
                                <th> Paid On </th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                   <td>{{ $payment->ad->title }}</td>
                                    <td>{{ $payment->user->name }}</td>
                                    <td class="align-center"><span>£</span>{{ $payment->amount }}</td>
                                    <td>{{ Carbon\Carbon::parse($payment->paid_on)->format('m/d/Y h:i A') }}</td>
                                    <td class="align-center">
                                        <a href="javascript:void(0)"  data-toggle="modal" data-target="#paymentDetails{{$payment->id}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @foreach($payments as $key => $payment)
                    <div class="modal fade gallery_modal" id="paymentDetails{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">{{$payment->ad->title}}</h4>
                                    
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class="row">
                                    <p style="margin-left: 4%;">Ad Id : {{$payment->ad->unique_id}}</p>
                                    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                                        <tbody>
                                            <tr>
                                                <td>Package</td>
                                                <td>{{ empty($payment->package_name)? null:$payment->package_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Expire Date</td>
                                                <td>{{ empty($payment->package_expire_date)? null: Carbon\Carbon::parse($payment->package_expire_date)->format('m/d/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Add On</td>
                                                <td>{{ empty($payment->add_on_name)? null:$payment->add_on_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Add On Expire Date</td>
                                                <td>{{ empty($payment->add_on_expire_date)? null: Carbon\Carbon::parse($payment->add_on_expire_date)->format('m/d/Y') }}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});
    </script>
@endpush