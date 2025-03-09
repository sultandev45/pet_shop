

<footer class="footer-section mt-4">
    <div class="container">

        <div class="footer-content pt-5 pb-5">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget d-md-flex d-lg-block    align-items-center justify-content-between">
                        <div class="footer-logo">
                            <a href="index.php"><img src="<?php echo validate_image($_settings->info('website-logo')) ?>" class="img-fluid" alt="logo"></a>
                        </div>

                        <div class="footer-social-icon mb-4">
                            <span>Follow us</span>
                            <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                            <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                            <a href="#"><i class="fab  fa-brands fa-instagram" style="color:white; background-color:#cd486b;"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Useful Links</h3>
                        </div>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="./?p=about">About us</a></li>
                            <li><a href="./?p=contact-us">Contact us</a></li>
                            <li><a href="./?p=blog">Latest Blogs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Subscribe</h3>
                        </div>
                        <div class="footer-text mb-25">
                            <p>Don’t miss to subscribe to our new feeds, kindly fill the form below.</p>
                        </div>
                        <div class="subscribe-form">
                            <form action="#" id="subscribe-form">
                                <input type="email" id="email-input" name='email' placeholder="Email Address" required>
                                <button><i class="fab fa-telegram-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                    <div class="copyright-text">
                        <p>Copyright &copy; <?php echo date(' Y'); ?>, All Right Reserved <a href="index.php"> Furever-homes</a></p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                    <div class="footer-menu">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="privacy-policy.php">Privacy</a></li>
                            <li><a href="./p=contact-us">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Back to Top -->
<a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>
<script>
    function isValidEmail(email) {
        // Regular expression for validating email addresses
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    $(document).ready(function() {
        $('#subscribe-form').submit(function(e) {
            e.preventDefault();
            var email = $('#email-input').val();
            // Check if email is valid
            if (!isValidEmail(email)) {
                // Display SweetAlert error message for invalid email format
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter a valid email address.'
                });
                return; // Stop further processing
            }

            // AJAX request
            $.ajax({
                type: 'POST',
                url: _base_url_ + "classes/Master.php?f=subscribe_email",
                data: {
                    email: email
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank you!',
                            text: 'You have successfully subscribed.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.msg
                        });
                    }
                    $('#email-input').val('');
                },
                error: function(xhr, status, error) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Temporary Error',
                        text: 'An error occurred. Please try again later.'
                    });
                }
            });
        });
    });
</script>

<script src="http://localhost/furever-homes/js/jqueryeasing.js"></script>
<script src="http://localhost/furever-homes/js/main.js"></script>
<script src="http://localhost/furever-homes/js/popper.min.js"></script>
<script src="http://localhost/furever-homes/js/bootstrap.min.js"></script>
<script src="http://localhost/furever-homes/js/contact-us-ajax.js"></script>
</body>

</html>
<!-- MDB -->