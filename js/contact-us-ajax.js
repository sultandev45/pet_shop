(function($) {
    "use strict";

    var contactForm = function() {
        if ($('#contactForm').length > 0) {
            $("#contactForm").validate({
                rules: {
                    name: "required",
                    subject: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    name: "Please enter your name",
                    subject: "Please enter your subject",
                    email: "Please enter a valid email address",
                    message: "Please enter a message"
                },
                /* submit via ajax */
                submitHandler: function(form) {
                    var $submit = $('.submitting'),
                        waitText = 'Submitting...';

                    $.ajax({
                        type: "POST",
                        url: "http://localhost/furever-homes/classes/sendEmail.php",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $submit.css('display', 'block').text(waitText);
                        },
                        success: function(msg) {
                            if (msg == 'OK') {
                                $('#form-message-warning').hide();
                                setTimeout(function() {
                                    $('#contactForm').fadeIn();
                                }, 1000);
                                setTimeout(function() {
                                    $('#form-message-success').fadeIn();
                                }, 1400);
                                setTimeout(function() {
                                    $('#form-message-success').fadeOut();
                                }, 8000);
                                setTimeout(function() {
                                    $submit.css('display', 'none').text(waitText);
                                }, 1400);
                                setTimeout(function() {
                                    $('#contactForm').each(function() {
                                        this.reset();
                                    });
                                }, 1400);

                                // SweetAlert success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Your mail has been sent.',
                                    confirmButtonText: 'OK',
                                    onClose: () => {
                                        window.location.href = 'http://localhost/furever-homes/?p=contact-us';
                                    }
                                });

                            } else {
                                $('#form-message-warning').html(msg);
                                $('#form-message-warning').fadeIn();
                                $submit.css('display', 'none');

                                // SweetAlert error message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: msg,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            $('#form-message-warning').html("Something went wrong. Please try again.");
                            $('#form-message-warning').fadeIn();
                            $submit.css('display', 'none');

                            // SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } // end submitHandler
            });
        }
    };
	$('#contactForm').on('submit', function(e) {
		e.preventDefault(); // Prevent default form submission
		
		contactForm();
	});
    
})(jQuery);
