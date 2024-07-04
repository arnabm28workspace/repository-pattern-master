var type = "";
var packageId = "";
var packageName = '';
var packageImage = '';
var packageDesc = '';
var package_amount = 0;
var package_duration = '';
var add_on_id = '';
var add_on_amount = '0';
var add_on_duration = '';
var show_amount = 0;
var last_package_id = '';
var last_package_price = '0';
addOnArr = [];

$(document).ready(function(){
	type = $('#type').text();
	//alert(type);
 	last_package_id = $('#last_package_id').text();
	last_package_price = $('#last_package_price').text();
	ischecked= $(this).is(':checked');
	

	if(last_package_id!=''){
		var label = 'chk-lbl-'+last_package_id;
		$("label[for="+label+"]").html("<i>Selected package</i>");
		$("label[for="+label+"]").closest('.card').addClass('active-card');
		packageId = last_package_id;
	  	package_amount = $('#sel-pack-'+packageId).val();
		package_duration = $('#sel-pack-'+packageId).find('option:selected').attr("duration");
		packageImage = $('#chk-lbl-'+last_package_id).attr('pack-img');
  		packageDesc = $('#chk-lbl-'+last_package_id).attr('pack-desc');
	}
	
	setAllValues();

	$('.package-chk').on('change', function() {
		$(".package-chk").next("label").html("<i>Select this package</i>");
		$(".package-chk").closest('.card').removeClass('active-card');
		ischecked= $(this).is(':checked');
	    if(!ischecked){
	    	packageId = "";
			package_amount = 0;
			package_duration = 0;
			packageName = '';
			packageImage = '';
			packageDesc = '';
			setAllValues();
	    }else{
	    	$('.package-chk').not(this).prop('checked', false);  
			packageId = $(this).val();
			packageName = $(this).attr('pack-name');
			packageImage = $(this).attr('pack-img');
  			packageDesc = $(this).attr('pack-desc');
  			label = 'chk-lbl-'+packageId;
			$("label[for="+label+"]").html("<i>Selected package</i>");
			$(this).closest('.card').addClass('active-card');
			package_amount = $('#sel-pack-'+packageId).val();
			package_duration = $('#sel-pack-'+packageId).find('option:selected').attr("duration");
			setAllValues();
	    }
	});

	$('.sel-basic-pack').on('change', function(){
		var pack_id = $(this).find('option:selected').attr("package-id");
		if(pack_id==packageId){
			$('.price-span-'+pack_id).text('£'+$(this).val());
			package_amount = $(this).val();
			package_duration = $(this).find('option:selected').attr("duration");
			setAllValues(); 
		}else{
			$('.price-span-'+pack_id).text('£'+$(this).val());
		}
	})

	$('.add-on-chk').on('change', function() {
		ischecked= $(this).is(':checked');
		if(ischecked){
			$(this).next("label").html("<i>Selected</i>");
			$(this).closest('.card').addClass('active-card');
		} else {
			$(this).next("label").html("<i>Select</i>");
			$(this).closest('.card').removeClass('active-card');
		}
		addAdOn();
	});

	$('.sel-add-on-pack').on('change', function(){
		var addonid = $(this).find('option:selected').attr("add-on-id");
		$('.add-on-price-span-'+addonid).text('£'+$(this).val());
		addAdOn();
	})

	$('#payment_btn').on('click', function(){
		if(type=='renew'){
			if(parseInt(show_amount)>0){
				$("#upgradePaymentModal").modal('show');	
			}else{
				$("#payment_btn"). attr('disabled', true);
				//alert("You have to choose at least one basic package or add on to continue");
			}
		}else{
			if(last_package_id!='' && last_package_id==packageId){
				if(parseInt(package_amount)==parseInt(last_package_price)){
					alert("Please choose a different package to continue");
				}else{
					if(parseInt(show_amount)>0){
						$("#upgradePaymentModal").modal();	
					}else{
						alert("You have to choose at least one basic package or add on to continue");
					}
				}
			}else{
				if(parseInt(show_amount)>0){
					$("#upgradePaymentModal").modal('show');	
				}else{
					alert("You have to choose at least one basic package or add on to continue");
				}
			}
		}
		
		
		
	});
});

function addAdOn(){
	addOnArr = [];
	add_on_amount = 0;
	var $boxes = $('.add-on-chk:checked');

	$boxes.each(function(){
	    // Do stuff here with this
	    var add_on_id = $(this).val();
	    
	    addOnArr.push({"id":$('#add-on-pack-'+add_on_id).find('option:selected').attr("add-on-id"),
	    	"price":$('#add-on-pack-'+add_on_id).val(),
	    	"duration":$('#add-on-pack-'+add_on_id).find('option:selected').attr("add-on-duration"),
	    	"name":$(this).attr('add-on-name'),
	    	"image":$(this).attr('add-on-img'),
	    	"desc":$(this).attr('add-on-desc')});

	    add_on_amount+= (parseInt($('#add-on-pack-'+add_on_id).val()));
	    console.log("arr>"+JSON.stringify(addOnArr));
	});

	setAllValues();
}

function setAllValues(){
	$('.plan_amount').text(parseInt(package_amount)+parseInt(add_on_amount));
	$("#pay_amount").val(parseInt(package_amount)+parseInt(add_on_amount));
	$("#package_duration").val(package_duration);
	$("#package_id").val(packageId);
	$("#package_name").val(packageName);
	$("#add_on_id").val(add_on_id);
	$("#add_on_duration").val(add_on_duration);
	$("#package_amount").val(package_amount);
	$("#add_on_amount").val(add_on_amount);
	$("#pay_type").val(type);
	show_amount = parseInt(package_amount)+parseInt(add_on_amount);

	$("#show_amount").html("£"+show_amount);
	$('#ad_id').val($('#span_ad_id').text());
	$('#ad_arr').val(JSON.stringify(addOnArr));

	var packageHtml = '';
	if(packageId!=''){
		packageHtml+='<div class="col-sm-12 ckeckout">\
                <div class="row">\
                    <div class="col-3 pr-0">\
                        <img src="'+packageImage+'" class="rounded mx-auto d-block" alt="...">\
                    </div>\
                    <div class="col-6">\
                        <div class="package-name">'+packageName+'</div>\
                        <p>'+packageDesc+'</p>\
                        <div class="duration mt-2">Duration:<strong> '+package_duration+' Days</strong></div>\
                    </div>\
                    <div class="col-3">\
                        <div class="checkout-price text-right">£'+package_amount+'</div>\
                    </div>\
                </div>\
               </div>';
	}

	if(addOnArr.length>0){
		for(var i=0;i<addOnArr.length;i++){
			packageHtml+='<div class="col-sm-12 ckeckout">\
                <div class="row">\
                    <div class="col-3">\
                        <img src="'+addOnArr[i].image+'" class="rounded mx-auto d-block" alt="...">\
                    </div>\
                    <div class="col-6">\
                        <div class="package-name">'+addOnArr[i].name+'</div>\
                        <p>'+addOnArr[i].desc+'</p>\
                        <div class="duration mt-2">Duration:<strong> '+addOnArr[i].duration+' Days</strong></div>\
                    </div>\
                    <div class="col-3">\
                        <div class="checkout-price text-right">£'+addOnArr[i].price+'</div>\
                    </div>\
                </div>\
               </div>';
		}
	}

	$('#added-package-show').html(packageHtml);
	$('#sub-total').html("£"+show_amount);
	$('#grand-total').html("<strong>£"+show_amount+"</strong>");
}