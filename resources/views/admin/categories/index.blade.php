@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary pull-right admin-add-new"><i class="fa fa-fw fa-lg fa-plus"></i>Add New</a>
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
                                <th> Description </th>
                                <th class="text-center"> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories_info as $category)
                                    <tr>
                                        <td>{{ $category['name'] }}</td>
                                        <td>
                                            @php 
                                                $desc = strip_tags($category['info']['description']);
                                                $length = strlen($desc);
                                                if($length>50)
                                                {
                                                    $desc = substr($desc,0,50)."...";
                                                }else{
                                                    $desc = substr($desc,0,50);
                                                }
                                            @endphp
                                            {!! $desc !!}
                                        </td>
                                        <td class="text-center">
                                            <div class="toggle-button-cover margin-auto">
                                                <div class="button-cover">
                                                    <div class="button-togglr b2" id="button-11">
                                                        <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-category_id="{{ $category['info']['id'] }}" {{ $category['info']['status'] == true ? 'checked' : '' }}>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.categories.edit', $category['info']['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                                <a href="#" data-id="{{$category['info']['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
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
    <script type="text/javascript">
    $('#sampleTable').on("click",'.sa-remove',function(){
        var categoryId = $(this).data('id');
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
            window.location.href = "categories/"+categoryId+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('#sampleTable').on('change','input[id="toggle-block"]',function() {
            var category_id = $(this).data('category_id');
            console.log("id="+category_id);
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
                url:"{{route('admin.categories.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, category_id:category_id, check_status:check_status},
                success:function(response)
                {
                  // $('#success-text').text(response.message);
                  // $('#success-msg').show();
                  // $('#success-msg').fadeOut(2000);
                  swal("Success!", response.message, "success");
                },
                error: function(response)
                {
                    // console.log(response);
                    // $('#error-text').text("Error! Please try again later");
                    // $('#error-msg').show();
                    // $('#error-msg').fadeOut(2000);
                    swal("Error!", response.message, "error");
                }
              });
        });
    </script>
@endpush