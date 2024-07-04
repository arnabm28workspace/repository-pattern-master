@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
            <a href="{{ route('admin.customform.create') }}" class="btn btn-primary pull-right admin-add-new"><i class="fa fa-fw fa-lg fa-plus"></i>Add New</a>
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
                                <th>Name</th>
                                <th> Category </th>
                                <th class="text-center"> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $form)
                                <?php 
                                    $field_values = unserialize($form->field_values);
                                    $form_name = $form->name;
                                    $form_id = $form->id;
                                    //$length = sizeof($field_values);
                                ?>
                                <tr>
                                    <td>{{ $form->name }}</td>
                                    <td>{{ !empty($form->category->name)?($form->category->name):"N/A" }}</td>
                                    <td class="text-center">
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-form_id="{{ $form->id }}" {{ $form->status == true ? 'checked' : '' }}>
                                                    <div class="knobs"><span>Inactive</span></div>
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.customform.edit', $form->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                            <a data-toggle="modal" class="btn btn-sm btn-primary edit-btn " data-target="#myModal{{$form->id}}"><i class="fa fa-eye"></i></a>
                                            <a href="#" data-id="{{ $form->id }}" class="sa-remove btn btn-sm btn-danger edit-btn del-btn"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.categoryforms.preview',compact('field_values','form_id','form_name'))
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
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
    $('#sampleTable').on("click",'.sa-remove',function(){
        var formId=$(this).data('id');
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
            window.location.href = "customform/"+formId+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('#sampleTable').on('change','input[id="toggle-block"]',function() {
            var form_id = $(this).data('form_id');
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
                url:"{{route('admin.customform.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, form_id:form_id, check_status:check_status},
                success:function(response)
                {
                  
                    swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            }, function() {
                                window.location = "customform/";
                            });
                },
                error: function(response)
                {
                    
                    swal("Error!", response.message, "error");
                }
              });
        });
    </script>
@endpush