$( document ).ready(function() {
  /* $('.vip-carousel').owlCarousel({
      loop: false,
      margin: 10,
      dots: false,
      nav: false, 
      autoplay:false,
      //autoplayTimeout:2000,
      responsive: {
          0: {
              items: 1
          },
          768: {
              items: 2
          },
          992: {
              items: 4
          },
          1440: {
              items: 4
          }
      }
  });
  $('.home-carousel').owlCarousel({
      loop: true,
      margin: 10,
      dots: false,
      nav: true,
      autoplay:false,
      autoplayTimeout:5000,
      responsive: {
          0: {
              items: 1
          },
          768: {
              items: 2
          },
          992: {
              items: 4
          },
          1440: {
              items: 4
          }
      }
  }); */

  //Form validation Sign Up

  $( "#signupForm" ).validate( {
      rules: {
          password: {
              required: true,
              minlength: 5
          },
          email: {
              required: true,
              email: true
          },
          agree: "required",
          agree1: "required"
      },
      messages: {
          email: "Please enter a valid email address",
          agree: "Please agree our Terms and Conditions",
          agree1: "Please accept our Privacy Policy"
      },
      agree: "required",
      errorElement: "em",
      errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
              error.insertAfter( element.parent( "label" ) );
          } else {
              error.insertAfter( element );
          }
      },
      highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
      }
  } );

   // Form validation Login Up

   $( "#loginForm" ).validate( {
      rules: {
          password: {
              required: true,
              minlength: 5
          },
          email: {
              required: true,
              email: true
          },
          agree: "required"
      },
      messages: {
          email: "Please enter a valid email address",
          agree: "Please accept our policy"
      },
      agree1: "required",
      errorElement: "em",
      errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
              error.insertAfter( element.parent( "label" ) );
          } else {
              error.insertAfter( element );
          }
      },
      highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
      }
  } );

  // $("#myAwesomeDropzone").dropzone({  
  //     dictDefaultMessage: "Put your custom message here",
  //     //url: 'login.php'
  // });

  $('.js-open-message-form').on('click', function(e){
      e.preventDefault();
      $('.js-contact-me').hide();
      $('.js-message-me').show();
  });

  $('.js-close-form').on('click', function(e){
      e.preventDefault();
      $('.js-message-me').hide();
      $('.js-contact-me').show();
  });

  $('.js-open-report-form').bind('click',function(e){
      e.preventDefault();
      $('.js-contact-me').css({"display":"none"});
      $('.js-report-me').css({"display":"block"});
  })

  $('.js-close-form1').bind('click',function(e){
      e.preventDefault();
      $('.js-contact-me').css({"display":"block"});
      $('.js-report-me').css({"display":"none"});
  })

  $("#sendMessage").bind('click',function(){
      var validate=true;
      
      if($("#email").val()=='')
      {
          $('.email-error').css({"display":"block"})
          validate=false;
      }
      
      if($("#phone").val()=='')
      {
          $('.phone-error').css({"display":"block"})
          validate=false;
      }

      if($("#subject").val()=='')
      {
          $('.subject-error').css({"display":"block"})
          validate=false;
      }

      if($("#message").val()=='')
      {
          $('.message-error').css({"display":"block"})
          validate=false;
      }

      return validate;

  });

  $("#reportPost").bind('click',function(){
      var validate1=true;
      
      if($("#reason").val()=='')
      {
          $('.reason-error').css({"display":"block"})
          validate1=false;
      }
      
      return validate1;

  });

  $("#postAd").bind('click',function(){
            var validate=true;
            
            if($("#title").val()=='')
            {
                $('.title-error').css({"display":"block"})
                validate=false;
            }
            
            if($("#desc").val()=='')
            {
                $('.desc-error').css({"display":"block"})
                validate=false;
            }

            if($("#category_id").val()=='')
            {
                $('.category-error').css({"display":"block"})
                validate=false;
            }

            if($("#city").val()=='')
            {
                $('.city-error').css({"display":"block"})
                validate=false;
            }

            if($("#country_id").val()=='')
            {
                $('.country-error').css({"display":"block"})
                validate=false;
            }

            if($("#type").val()=='')
            {
                $('.type-error').css({"display":"block"})
                validate=false;
            }

            if($("#phone").val()=='')
            {
                $('.phone-error').css({"display":"block"})
                validate=false;
            }

            if($("#email").val()=='')
            {
                $('.email-error').css({"display":"block"})
                validate=false;
            }

            if($("#website").val()=='')
            {
                $('.website-error').css({"display":"block"})
                validate=false;
            }

            if($(".doc").last().val()=='')
            {
                $('.img-error').css({"display":"block"})
                validate=false;
            }

            return validate;
            //return false;

        });

        $('#country_id').on("change",function(){
            var citiesArr = [];
            var citiesStr = $(this).find('option:selected').attr("cities");
            citiesArr = citiesStr.split(",");
            var optHtml = '';
            for(var i=0;i<citiesArr.length;i++){
                optHtml += '<option value="'+citiesArr[i]+'">'+citiesArr[i]+'</option>';
            }

            $('#city').html(optHtml);
            //console.log(citiesArr);
        });
});

$('.js-show-login').on('click', function(e)  {
  e.preventDefault();
  $(this).addClass('d-none');
  $('.js-login-form').show();
  $('.js-register-form').hide();
  $('.js-show-register').addClass('d-block');
});

$('.js-show-register').on('click', function(e) {
  e.preventDefault();
  $(this).removeClass('d-block');
  $('.js-register-form').show();
  $('.js-login-form').hide();
  $('.js-show-login').removeClass('d-none');
}); 


// Dropzone.options.myAwesomeDropzone = {
//     maxFiles : 1,
//     acceptedFiles: ".jpeg,.jpg,.png,.gif",
//     autoProcessQueue: false,
//     addRemoveLinks: true,
//     dictDefaultMessage: "Put your custom message here"
// }; 




