@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
            <a href="{{ route('admin.package.create') }}" class="btn btn-primary pull-right admin-add-new"><i class="fa fa-fw fa-lg fa-plus"></i>Add New</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Type </th>
                                <!-- <th> Currency </th> -->
                                <th class="text-center"> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $key=>$package)
                                <tr>
                                    <td>{{ $package->name }}</td>
                                    <td>
                                        @if($package->package_type == "add_on")
                                            {{"Add On"}}
                                        @else
                                            {{"Basic Package"}}
                                        @endif
                                    </td>
                                    <!-- <td> GBP </td> -->
                                    <td class="text-center">
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-packageid="{{ $package->id }}" {{ $package->status == 1 ? 'checked' : '' }}>
                                                    <div class="knobs"><span>Inactive</span></div>
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.package.edit', $package->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                            <?php 
                                            $delete_button_display = ($package->package_type == "basic_package")? "style= display:none":"";
                                            ?>
                                            <a href="#" data-id="{{$package->id}}" class="sa-remove btn btn-sm btn-danger edit-btn" {{$delete_button_display}} ><i class="fa fa-trash"></i></a>
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
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript">
        $('#sampleTable').on("click",'.sa-remove',function(){
            var packageId=$(this).data('id');
            swal({
              title: "Are you sure?",
              text: "Your will not be able to recover the record!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "packages/"+packageId+"/delete";
                } else {
                  swal("Cancelled", "Record is safe", "error");
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('#sampleTable').on('change','input[id="toggle-block"]',function() {
            var package_id = $(this).data('packageid');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;
            if($(this).is(":checked")){
                check_status = 1;
            }else{
                check_status = 0;
            }
            $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.package.updatestatus')}}",
                data:{ _token: CSRF_TOKEN, id:package_id, status:check_status},
                success:function(response)
                {
                  // $('#success-text').text(response.message);
                  // $('#success-msg').show();
                  // $('#success-msg').fadeOut(2000);
                  swal("Success!", response.message, "success");
                },
                error: function()
                {
                    // $('#error-text').text("Error! Please try again later");
                    // $('#error-msg').show();
                    // $('#error-msg').fadeOut(2000);
                    swal("Error!", response.message, "error");
                }
            });
        });
    </script>
@endpush