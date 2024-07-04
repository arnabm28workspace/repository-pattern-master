@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1>{{$username}}</h1>
                @if ($userdetails->is_block == false)
                    <span class="badge badge-success badge-top">Active</span>
                @else
                    <span class="badge badge-danger badge-top">Block</span>
                @endif
                <div class="form-group">
                    <a class="btn btn-secondary" href="{{ URL::previous() }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
    @include('admin.partials.flash')
        <div class="user">
            <div class="col-md-12 nopadding">
                <div class="tile p-0">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item nav-item-top"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#ads" data-toggle="tab">Posted Advertisement(s)</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#payments" data-toggle="tab">Payment(s)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-md-body">
        <div class="alert alert-success" id="success-msg" style="display: none;">
            <span id="success-text"></span>
        </div>
        <div class="alert alert-danger" id="error-msg" style="display: none;">
            <span id="error-text"></span>
        </div>
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="profile">
                    @include('admin.users.includes.profile')
                </div>
                <div class="tab-pane fade" id="ads">
                    @include('admin.users.includes.ads')
                </div>
                <div class="tab-pane fade" id="payments">
                    @include('admin.users.includes.payment')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
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