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
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
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
                                <th> Name</th>
                                <th> Email</th>
                                <th class="text-center"> Phone</th>
                                <th class="align-center"> Status</th>
                                <th class="align-center" style="width:60px; min-width:30px;" class=""> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_details as $key=>$user_detail)
                                <tr>
                                    <td>{{ $user_detail->name }}</td>
                                    <td>{{ $user_detail->email }}
                                        <br />
                                        @if (!empty($user_detail->email_verified_at))
                                            <span class="badge badge-verified emailV-tag">Verified</span>
                                        @else
                                            <span class="badge badge-notverified emailV-tag">Not verified</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ (empty($user_detail->profile->phone_number))? "N/A":($user_detail->profile->phone_number) }}</td>
                                    <td class="text-center">
                                    <div class="toggle-button-cover margin-auto">
                                        <div class="button-cover">
                                            <div class="button-togglr b2" id="button-10">
                                            <input id="toggle-block" type="checkbox" class="checkbox" data-user_id="{{ $user_detail->id }}" {{ $user_detail->is_block == 1 ? 'checked' : '' }}>
                                            <div class="knobs">
                                                <span>Active</span>
                                            </div>
                                            <div class="layer"></div>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="align-center">
                                        <a href="{{ route('admin.users.detail', $user_detail->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});
    </script>
    <script type="text/javascript">

        $('#sampleTable').on('change','input[id="toggle-block"]',function() {
          var user_id = $(this).data('user_id');
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var check_block_status = 0;
          if($(this).is(":checked")){
              check_block_status = 1;
          }else{
            check_block_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.users.post')}}",
                data:{ _token: CSRF_TOKEN, user_id:user_id, is_block:check_block_status},
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