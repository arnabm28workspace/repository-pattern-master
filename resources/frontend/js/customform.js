if($('#ad_id').length != 0 )
{
	var ad_id = $('#ad_id').val();
}else{
	var ad_id = 0;
}
var field = '';
function createField(response)
{
  	$('#category_field').empty();
	if (response.length > 0) {
		var field_values = response;
		var checkbox_type = "checkbox_group";
		var selectbox_type = "selectbox_group";
		var radiobutton_type = "radio_group";
		var ratefield_type = "rate_field_group";
		var textbox_type = "text";
		var textarea_type = "textarea";
		var categoryHTML = '';
		var i, max_order=0;
		for (var key in field_values) {
			if(field_values[key].order>max_order)
				max_order = field_values[key].order;
		}
		
		for(i=1; i<=max_order; i++)
		{
		for (var key in field_values) {
			if(field_values[key].order == i)
			{
				if(field_values[key].type == checkbox_type)
				{
					var required_value = (field_values[key].required)? "required":"";
					categoryHTML = '';
					categoryHTML+='<div class="w-100"></div>';
					categoryHTML+='<div class="col-12 col-lg-12 checkbox-container mb-0 mb-md-5">';
					categoryHTML+='<label class="py-0 py-md-3 bold-text">'+field_values[key].label+'</label>';
					categoryHTML+='<div class="row" '+required_value+'>';

					function slugify(string) {
					return string
						.toString()
						.trim()
						.toLowerCase()
						.replace(/\s+/g, "-")
						.replace(/[^\w\-]+/g, "")
						.replace(/\-\-+/g, "-")
						.replace(/^-+/, "")
						.replace(/-+$/, "");
					}
					var field_name = slugify(field_values[key].label);
					for (var checkbox_value_key in field_values[key].values)
					{
						var checkbox_values = field_values[key].values[checkbox_value_key];
						var checkbox_checked_value = (ad_id>0)?"":((checkbox_values.check==1)?"checked":"");
						categoryHTML+='<div class="col-6 col-md-4">';
						categoryHTML+='<label class="check-container pr-5">'+checkbox_values.label;
						
						categoryHTML+='<input type="checkbox" value="'+checkbox_values.value+'" name="'+field_name+'[]'+'" class="'+field_name+'" '+checkbox_checked_value+'>';
						
						categoryHTML+='<span class="checkmark"></span>';
						categoryHTML+='</label>';
						categoryHTML+='</div>';
					}
					categoryHTML+='</div>';
					categoryHTML+='</div>';

					var chkArr = [];
					if(ad_id > 0)
					{
						$.ajax({
						type:'POST',
						dataType:'JSON',
						url:fetchValueUrl,
						data:{ _token: CSRF_TOKEN, ad_id:ad_id,key:field_name},
						success:function(response)
						{
							//$('.'+response[0].key).val(response[0].value).attr("selected","selected");
							var str = response[0].value;
							var chkArr = str.split(",");
							
							for(var i=0;i<chkArr.length;i++){
								console.log(i+">>"+chkArr[i]);
								var str = chkArr[i].trim();
								// $('.'+field_name).val(chkArr[i]).attr("checked");
								$('input[name="'+response[0].key+'[]'+'"][value="'+str+'"]').attr('checked','checked');
								// $('input[type="checkbox"][value='+chkArr[i]+']').prop('checked',true);
							}
						}
						});	
					}
					
					$("#category_field").append(categoryHTML);
				}
				else if(field_values[key].type == selectbox_type)
				{
					function slugify(string) {
					return string
						.toString()
						.trim()
						.toLowerCase()
						.replace(/\s+/g, "-")
						.replace(/[^\w\-]+/g, "")
						.replace(/\-\-+/g, "-")
						.replace(/^-+/, "")
						.replace(/-+$/, "");
					}
					var field_name = slugify(field_values[key].label);
					var required_value = (field_values[key].required)? "required":"";
					categoryHTML = '';
					categoryHTML+='<div class="w-100"></div>';
					categoryHTML+='<div class="col-12 col-lg-4 mb-0 mb-md-5">';
					categoryHTML+='<label class="bold-text">'+field_values[key].label+'</label>';
					categoryHTML+='<select name="'+field_name+'" class="'+field_name+'" '+required_value+'>';
					for (var selectbox_value_key in field_values[key].values)
					{
						var selectbox_values = field_values[key].values[selectbox_value_key];
						var selectbox_checked_value = (ad_id>0)?"":((selectbox_values.check==1)?"selected":"");
						categoryHTML+='<option value="'+selectbox_values.label+'" '+selectbox_checked_value+'>';
						categoryHTML+= selectbox_values.label+'</option>'
					}
					categoryHTML+='</select>';
					categoryHTML+='</div>';

					if(ad_id > 0)
					{
						$.ajax({
						type:'POST',
						dataType:'JSON',
						url:fetchValueUrl,
						data:{ _token: CSRF_TOKEN, ad_id:ad_id,key:field_name},
						success:function(response)
						{
							$('.'+response[0].key).val(response[0].value).attr("selected","selected");
						}
						});
					}
					
					$("#category_field").append(categoryHTML);
				}
				else if(field_values[key].type == radiobutton_type)
				{
					var required_value = (field_values[key].required)? "required":"";
					categoryHTML = '';
					categoryHTML+='<div class="w-100"></div>';
					categoryHTML+='<div class="col-12 col-md-12 py-2 mb-5">';
					categoryHTML+='<label class="bold-text">'+field_values[key].label+'</label>';
					function slugify(string) {
					return string
						.toString()
						.trim()
						.toLowerCase()
						.replace(/\s+/g, "-")
						.replace(/[^\w\-]+/g, "")
						.replace(/\-\-+/g, "-")
						.replace(/^-+/, "")
						.replace(/-+$/, "");
					}
					var field_name = slugify(field_values[key].label);
					for (var radiobutton_value_key in field_values[key].values)
					{
						categoryHTML+='<div class="row w-100 radio-btn mb-2">';
						var radiobutton_values = field_values[key].values[radiobutton_value_key];
						var radiobutton_checked_value = (ad_id>0)?"":((radiobutton_values.check==1)?"checked":"");
						categoryHTML+='<div class="col-1 pr-0"><input type="radio" value="'+radiobutton_values.value+'" name="'+field_name+'" class="'+field_name+'" '+radiobutton_checked_value+'></div><div class="col-9 pl-md-0"><label>'+radiobutton_values.label+'</label></div>';
						categoryHTML+='</div>';
					}
					
					categoryHTML+='</div>';

					if(ad_id > 0)
					{
						$.ajax({
						type:'POST',
						dataType:'JSON',
						url:fetchValueUrl,
						data:{ _token: CSRF_TOKEN, ad_id:ad_id,key:field_name},
						success:function(response)
						{
							console.log(response);
							$('input[name='+response[0].key+'][value="' + response[0].value + '"]').prop('checked', true);
						}
						});
					}
					
					$("#category_field").append(categoryHTML);
				}
				else if(field_values[key].type == ratefield_type)
				{
				var required_value = (field_values[key].required)? "required":"";
				categoryHTML = '';
				categoryHTML+='<div class="w-100"></div>';
				categoryHTML+='<div class="col-12 mb-0 mb-md-5">';
				categoryHTML+='<label class="bold-text pt-3 mb-0 pt-md-0">'+field_values[key].label+'</label>';
				categoryHTML+='<div class="rates">';
				categoryHTML+='<div class="row"><div class="col-4"></div><div class="col-4">Incall</div><div class="col-4">Outcall</div></div>';
				var pos = 0;
				for (var ratefield_value_key in field_values[key].values)
				{
					var ratefield_values = field_values[key].values[ratefield_value_key];
					categoryHTML+='<div class="row">';
					categoryHTML+='<div class="col-4"><label for="">'+ratefield_values.label+'</label></div><div class="col-4"><input type="text" name="incall[]" class="incall'+pos+'"></div><div class="col-4"><input type="text" name="outcall[]" class="outcall'+pos+'"> <input type="hidden" name="time[]" value="'+ratefield_values.label+'"></div>';
					categoryHTML+='</div>';
					pos++;
				}
				categoryHTML+='</div>';
				categoryHTML+='</div>';
				if(ad_id > 0)
				{
					$.ajax({
						type:'POST',
						dataType:'JSON',
						url:fetchRateUrl,
						data:{ _token: CSRF_TOKEN, ad_id:ad_id},
						success:function(response)
						{
							//console.log(JSON.parse(response[0].value));
							var incallArr = JSON.parse(response[0].value)[0].val;
							var outcallArr = JSON.parse(response[0].value)[1].val;

							for(var x=0;x<incallArr.length;x++){
								console.log(x+">>"+incallArr[x])
								$('.incall'+x).val(incallArr[x]);
							}

							for(var y=0;y<outcallArr.length;y++){
								$('.outcall'+y).val(outcallArr[y]);
							}
							console.log(incallArr);
						},
						error: function(response)
						{
							console.log("rateerror>>"+response);
						}
						});
				}
				
				$("#category_field").append(categoryHTML); 
				}
				else if(field_values[key].type == textarea_type)
				{
					function slugify(string) {
					return string
						.toString()
						.trim()
						.toLowerCase()
						.replace(/\s+/g, "-")
						.replace(/[^\w\-]+/g, "")
						.replace(/\-\-+/g, "-")
						.replace(/^-+/, "")
						.replace(/-+$/, "");
					}
					var field_name = slugify(field_values[key].label);
					var required_value = (field_values[key].required)? "required":"";
					categoryHTML = '';
					categoryHTML+='<div class="w-100"></div>';
					categoryHTML+='<div class="col-12 col-lg-12 mb-0 mb-md-5 form-field">';
					categoryHTML+='<label class="bold-text pt-3 pt-md-0">'+field_values[key].label+'</label>';
					categoryHTML+='<textarea name="'+field_name+'" class="'+field_name+'" '+required_value+'/>';
					categoryHTML+='</div>';

					if(ad_id > 0)
					{
						$.ajax({
						type:'POST',
						dataType:'JSON',
						url:fetchValueUrl,
						data:{ _token: CSRF_TOKEN, ad_id:ad_id,key:field_name},
						success:function(response)
						{
							$('.'+response[0].key).val(response[0].value);
						}
						});
					}
					
					$("#category_field").append(categoryHTML);
				}
				else if(field_values[key].type == textbox_type)
				{
					function slugify(string) {
					return string
						.toString()
						.trim()
						.toLowerCase()
						.replace(/\s+/g, "-")
						.replace(/[^\w\-]+/g, "")
						.replace(/\-\-+/g, "-")
						.replace(/^-+/, "")
						.replace(/-+$/, "");
					}
					var field_name = slugify(field_values[key].label);
					var required_value = (field_values[key].required)? "required":"";
					categoryHTML = '';
					categoryHTML+='<div class="w-100"></div>';
					categoryHTML+='<div class="col-12 col-lg-4 form-field mb-0 mb-md-5">';
					categoryHTML+='<label class="bold-text">'+field_values[key].label+'</label>';
					categoryHTML+='<input type="text" name="'+field_name+'" class="'+field_name+'" '+required_value+'>';
					categoryHTML+='</div>';
					if(ad_id > 0)
					{
						$.ajax({
						type:'POST',
						dataType:'JSON',
						url:fetchValueUrl,
						data:{ _token: CSRF_TOKEN, ad_id:ad_id,key:field_name},
						success:function(response)
						{
							$('.'+response[0].key).val(response[0].value);
						}
						});
					}
					
					$("#category_field").append(categoryHTML);
				} 

			}
			// console.log(field_values[key]);
		}  
		}
  	}
}