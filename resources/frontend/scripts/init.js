$( document ).ready(function() {
    $('.vip-carousel').owlCarousel({
        loop: true,
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
        nav: false,
        autoplay:true,
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
    });
  
    // Form validation Sign Up
  
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
            agree: "Please accept our Terms and Conditions",
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
  
  
  
  
  