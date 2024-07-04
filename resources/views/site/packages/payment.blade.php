<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bot-0">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close payment" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<script src='https://js.stripe.com/v2/' type='text/javascript'></script>
      	<form style="margin-bottom:20px;" accept-charset="UTF-8" action="{{route('paypost')}}" class="require-validation"
      	    data-cc-on-file="false"
      	    data-stripe-publishable-key="{{App\Models\Setting::get('stripe_key')}}"
      	    id="payment-form" method="post">
      	    {{ csrf_field() }}
      	    <div class='row form-row'>
      	        <div class='col-xs-12 col-md-12 form-group required'>
      	            <label class='control-label'>Name on Card</label> <input
      	                class='form-control card-name' name='name' size='4' type='text'>
      	        </div>
      	    </div>
      	    <div class='form-row'>
      	        <div class='col-xs-12 col-md-12 form-group card1 required'>
      	            <label class='control-label'>Card Number</label> <input
      	                autocomplete='off' class='form-control card-number' size='20'
      	                type='text'>
      	        </div>
      	    </div>
      	    <div class='form-row'>
      	        <div class='col-xs-4 form-group cvc required'>
      	            <label class='control-label'>CVC</label> <input autocomplete='off'
      	                class='form-control card-cvc' placeholder='ex. 311' size='4'
      	                type='text'>
      	        </div>
      	        <div class='col-xs-4 form-group expiration required'>
      	            <label class='control-label'>Expiration</label> <input
      	                class='form-control card-expiry-month' placeholder='MM' size='2'
      	                type='text'>
      	        </div>
      	        <div class='col-xs-4 form-group expiration required'>
      	            <label class='control-label'>&nbsp; </label> <input
      	                class='form-control card-expiry-year' placeholder='YYYY' size='4'
      	                type='text'>
      	        </div>
      	    </div>
      	    <!-- <div class='form-row'>
      	        <div class='col-md-12'>
      	            <div class='total btn btn-block'>
                      <input type="hidden" id="pay_amount" name="pay_amount">
                      <input type="hidden" id="package_id" name="package_id">
                      <input type="hidden" id="package_name" name="package_name">
                      <input type="hidden" id="package_duration" name="package_duration">
                      <input type="hidden" id="add_on_id" name="add_on_id">
                      <input type="hidden" id="add_on_duration" name="add_on_duration">
                      <input type="hidden" id="package_amount" name="package_amount">
                      <input type="hidden" id="add_on_amount" name="add_on_amount">
                      <input type="hidden" id="ad_id" name="ad_id">
                      <input type="hidden" id="ad_arr" name="ad_arr">
      	                Total: <span id="show_amount"></span>
      	            </div>
      	        </div>
      	    </div> -->
            <input type="hidden" id="pay_amount" name="pay_amount">
            <input type="hidden" id="package_id" name="package_id">
            <input type="hidden" id="package_name" name="package_name">
            <input type="hidden" id="package_duration" name="package_duration">
            <input type="hidden" id="add_on_id" name="add_on_id">
            <input type="hidden" id="add_on_duration" name="add_on_duration">
            <input type="hidden" id="package_amount" name="package_amount">
            <input type="hidden" id="add_on_amount" name="add_on_amount">
            <input type="hidden" id="ad_id" name="ad_id">
            <input type="hidden" id="ad_arr" name="ad_arr">
      	    <div class='form-row'>
      	        <div class='col-md-12 form-group'>
      	            <button class='btn submit-button btn-block no-mx-wid submit-button'
      	                type='submit' style="margin-top: 10px;">Pay <span id="show_amount"></span> »</button>
      	        </div>
      	    </div>
      	</form>
      	
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src='https://js.stripe.com/v2/' type='text/javascript'></script>
<script type="text/javascript" src="{{ asset('frontend/js/payment.js') }}"></script>
