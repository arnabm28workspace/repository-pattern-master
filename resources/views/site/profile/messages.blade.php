@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="page_intro">
</section>
<section class="container admin-panel mt-4 xs-top-spc">
	<div class="admin-panel__bar mt-4">
			<h4 class="text-white">My Account</h4>
	</div>
	<div class="admin-panel__body">
		@include('site.partials.flash')
		<div class="row">
			@include('site.partials.sidebar')
			<div class="col-md-12 col-xl-9 admin-panel__content">
	            <table class="table table-hover custom-data-table-style table-striped responsive nowrap" id="sampleTable_msg">
	                <thead>
	                <tr>
	                    <th>Posted By</th>
	                    <th>Message</th>
	                    <th>Messaged On</th>
	                    <th>View</th>
	                </tr>
	                </thead>
	                <tbody>
	                    @foreach($messages as $key => $message)
	                        <tr class="{{(!$message->is_read)?'unread_highlight':''}}" id="highlight{{$message->id}}">
	                            <td>{{ $message->email }}</td>
	                            <td>
	                                <?php
	                                    $msg_length = strlen($message->message);
	                                    $msg_string = "";
	                                    if($msg_length>38)
	                                    {
	                                        $msg_string=substr($message->message, 0,38)."...";
	                                    }else{
	                                        $msg_string=$message->message;
	                                    }
	                                    $subject_length = strlen($message->subject);
	                                    $subject_string = "";
	                                    if($subject_length>15)
	                                    {
	                                        $subject_string=substr($message->subject, 0,15)."...";
	                                    }else{
	                                        $subject_string=$message->subject;
	                                    }
	                                ?>
	                                <strong>{{ $subject_string }}</strong><br />{{ $msg_string }}</td>
	                            <td>{{ Carbon\Carbon::parse($message->created_at)->format('m-d-Y h:i a') }}</td>
	                            <td>
	                                <a href="javascript:void(0)" data-divid="messageDetails{{$message->id}}" data-msg_id="{{$message->id}}" class="btn btn-sm btn-primary edit-btn msgdiv"><i class="fa fa-eye"></i></a>
	                            </td>

	                        </tr>
	                        
	                    @endforeach
	                </tbody>
	            </table>
			      @foreach($messages as $key => $message)
			       <div class="container messages-details-view" id="messageDetails{{$message->id}}" style="display:none">
			        <div class="row" role="document">
			          <div class="container">
			            <div class="col-12 my-5">
			              <div class="row">
                              <div class="col-8 pl-0">
                                  <h3 class="" id="exampleModalLabel">
                                  {{ empty($message->subject)? null:$message->subject }}
                                  </h3>
                              </div>
                              <div class="col-4 text-right">
                                  <a href="javascript:void(0)" class="close_div back-msg" data-close_div="messageDetails{{$message->id}}">
                                    <i class="fas fa-chevron-left"></i>Back
                                  </a>
                              </div>
			              </div>
			              
			              <div class="row">

			                  <div class="row">
                                <div class="col-12">
                                    <div class="sender-details mt-3 mb-4">
                                        <strong>From:</strong> <a href="mailto:{{ empty($message->email)? null:$message->email }}">{{ empty($message->email)? null:$message->email }}</a> <i class="spacer">&nbsp;</i><strong>Phone:</strong> <a href="tel:{{ empty($message->phone)? null:$message->phone }}">{{ empty($message->phone)? null:$message->phone }}</a>
                                    </div>
                                    <div class="sender-msg pb-4 pr-4">
                                        {{ empty($message->message)? null:$message->message }}
                                    </div>
                                    <div class="posted-date mt-2 mt-md-3">
                                        <strong>Posted On :</strong>
                                         {{ Carbon\Carbon::parse($message->created_at)->format('m-d-Y h:i a') }}
                                    </div>
			                    </div>
			                 </div>
			              </div>
			              <div class="row">
			              	<!-- <a href="javascript:void(0)" class="showreplyform" data-replyform_id="{{$message->id}}" id="replylink{{$message->id}}"><i class="fas fa-reply"></i>Reply</a> -->
			              	<form id="replyForm{{$message->id}}" action="{{route('replyadmessage')}}" method="post"  style="display:none">
			              		@csrf
			              		<input type="hidden" name="id" value="{{$message->id}}">
			              		<textarea name="reply_message"></textarea>
			              		<input type="submit" name="submit" value="Reply">
			              		<a href="javascript:void(0)" class="close_replyform back-msg" data-closereplyform_div="replyForm{{$message->id}}" data-showreplylink_id="replylink{{$message->id}}">
			              	  <i class="fas fa-window-close"></i>Close
			              	</a>
			              	</form>
			              </div>
			            </div>
			          </div>
			        </div>
			      </div>
			      @endforeach      
			</div>
		</div>
	</div>
</section>
<!--test-->

@endsection

@push('scripts')
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript">
    	$('#sampleTable_msg').DataTable({
    		"ordering": false,
            "responsive": true,
			"columnDefs": [
				{ "responsivePriority": 1, "targets": 0 },
				{ "responsivePriority": 10000, "targets": 1 },
				{ "responsivePriority": 10001, "targets": 2 },
				{ "responsivePriority": 2, "targets": -1 }
			]
    	});
    	$('#sampleTable_msg').on( 'click', '.msgdiv', function () {
    	 		
    	 		var div_name = $(this).data('divid');
    	 		var msg_id = $(this).data('msg_id');
    	 		var CSRF_TOKEN = "{{ csrf_token() }}";
    	 		console.log(div_name);
                $.ajax({
                      type:'POST',
                      dataType:'JSON',
                      url:"{{route('user.profile.updateMessageStatus')}}",
                      data:{ _token: CSRF_TOKEN, msg_id:msg_id},
                      success:function(response)
                      {
                        console.log(response);
                        $("#count_unread_messages").text(response);
                        $("#highlight"+msg_id).removeClass("unread_highlight");
                      },
                      error: function(response)
                      {
                          // console.log(response);
                      }
                    });

	 			$('#sampleTable_msg_wrapper').hide();
                $("#"+div_name).show();
    	     	
    	    } );
    	$(document).on('click','.close_div',function(){
    		var close_div_name = $(this).data('close_div');
 			$('#sampleTable_msg_wrapper').show();
            $("#"+close_div_name).hide();
    	});
	   	$(document).on('click','.showreplyform',function(){
	   		var show_reply_form_id = $(this).data('replyform_id');
				$('#replyForm'+show_reply_form_id).show();
	           $("#replylink"+show_reply_form_id).hide();
	   	});
   	   	$(document).on('click','.close_replyform',function(){
   	   		var close_reply_form_id = $(this).data('closereplyform_div');
   	   		var show_replylink_id = $(this).data('showreplylink_id');
   				$('#'+close_reply_form_id).hide();
   	           $("#"+show_replylink_id).show();
   	   	});
	</script>
@endpush
