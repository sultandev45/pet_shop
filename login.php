  <!-- Home -->
  <div class="home">
      <div class="form_container">
          <i class="uil uil-times form_close"></i>
          <!-- Login From -->
          <div class="form login_form">
              <form action="#" id="login-form">
                  <h2>Login</h2>
<?php echo md5("Mubasher1122")?>
                  <div class="input_box">
                      <input name="email" type="email" placeholder="Enter your email" required />
                      <i class="uil uil-envelope-alt email"></i>
                  </div>
                  <div class="input_box">
                      <input name="password" type="password" placeholder="Enter your password" required />
                      <i class="uil uil-lock password"></i>
                      <i class="uil uil-eye-slash pw_hide"></i>
                  </div>

                  <div class="option_field">
                      <span class="checkbox">
                          <input type="checkbox" id="check" />
                          <label for="check">Remember me</label>
                      </span>
                      <a id="forgot" href="#" class="forgot_pw">Forgot password?</a>
                  </div>

                  <button class="button">Login Now</button>

                  <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
              </form>
          </div>
          <!-- reset pass -->
          <style>
              .popup-container {
                  display: none;
                  position: fixed;
                  width: 300px;
                  height: 200px;
                  top: 50%;
                  left: 50%;
                  transform: translate(-50%, -50%);
                  background-color: #fff;
                  padding: 20px;
                  border: 1px solid #ccc;
                  border-radius: 5px;
                  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                  z-index: 9999;
              }
          </style>
          <div class="popup-container" id="popupContainer">
              <i class="uil uil-times form_close" id="closeIcon"></i>
              <h2>Reset Password</h2>
              <form id="resetForm">
                  <div class="input_box">
                      <input name="email" type="email" placeholder="Enter your email" required />
                      <i class="uil uil-envelope-alt email"></i>
                  </div>
                  <button class="button" type="submit">Submit</button>
              </form>
          </div>








          <!-- Signup From -->
          <div class="form signup_form">
              <form action="" id="registration">
                  <h2>Signup</h2>
                  <div class="input_box">
                      <input type="text" name="fullname" placeholder="Enter your full name" required />
                      <i class="uil uil-user person-icon"></i>
                  </div>
                  <div class="input_box">
                      <input type="email" name="email" placeholder="Enter your email" required />
                      <i class="uil uil-envelope-alt email"></i>
                  </div>

                  <div class="input_box">
                      <input type="password" name="password" placeholder="Create password" required />
                      <i class="uil uil-lock password"></i>
                      <i class="uil uil-eye-slash pw_hide"></i>
                  </div>
                  <div class="input_box">
                      <input type="password" name="confirm_password" placeholder="Confirm password" required />
                      <i class="uil uil-lock password"></i>
                      <i class="uil uil-eye-slash pw_hide"></i>
                  </div>

                  <button class="button">Signup Now</button>

                  <div class="login_signup">Already have an account? <a href="#" id="login">Login</a></div>
              </form>
          </div>
      </div>
  </div>
  <script>
      $(function() {
          // Function to clear form inputs
          function clearFormInputs(formId) {
              $('#' + formId).find('input').val('');
          }
          $('#resetForm').submit(function(e) {
              e.preventDefault();

              const email = $('#email').val();

              $.ajax({
                  url: "http://localhost/furever-homes/classes/Master.php?f=reset_link",
                  method: "POST",
                  data: $(this).serialize(),
                  dataType: "json",
                  error: function(xhr, status, error) {
                      console.error(error);
                      alert_toast("An error occurred", 'error');
                  },
                  success: function(resp) {
                      if (typeof resp === 'object' && resp.status === 'success') {
                          alert_toast("Please check your gmail for reset link", 'success');
                          setTimeout(function() {
                            window.location.href = "https://mail.google.com/";
                          }, 2000);
                          
                          $('#resetForm')[0].reset();
                      } else if (resp.status === 'incorrect') {
                          var _err_el = $('<div>');
                          _err_el.addClass("alert alert-danger err-msg").text("User Gmail doesnot exist.");
                          $('#resetForm').prepend(_err_el);
                      } else {
                          alert_toast("An error occurred", 'error');
                      }
                  }
              });
          });
          // Login Form Submission
          $('#login-form').submit(function(e) {
              e.preventDefault();

              if ($('.err-msg').length > 0)
                  $('.err-msg').remove();
              $.ajax({
                  url: "http://localhost/furever-homes/classes/Login.php?f=login_user",
                  method: "POST",
                  data: $(this).serialize(),
                  dataType: "json",
                  error: err => {
                      console.log(err);
                      alert_toast("An error occurred", 'error');
                  },
                  success: function(resp) {
                      if (typeof resp == 'object' && resp.status == 'success') {
                          alert_toast("Login Successfully", 'success');
                          setTimeout(function() {
                              location.reload();
                          }, 2000);
                          // Clear form inputs after successful login
                          clearFormInputs('login-form');
                      } else if (resp.status == 'incorrect') {
                          var _err_el = $('<div>')
                          _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                          $('#login-form').prepend(_err_el);
                      } else {
                          alert_toast("An error occurred", 'error');
                      }
                  }
              });
          });

          // Registration Form Submission
          $('[name="password"], [name="confirm_password"],[name="email"]').focus(function() {
              $('.err-msg').remove();
          });
          $('#registration').submit(function(e) {
              e.preventDefault();

              if ($('.err-msg').length > 0)
                  $('.err-msg').remove();
              // Check if password and confirm password fields match
              var password = $('#registration [name="password"]').val();

              var confirmPassword = $('[name="confirm_password"]').val();

              if (password != confirmPassword) {
                  alert("Pass= " + password + " does not match " + "confirm = " + confirmPassword);
                  var _err_el = $('<div class="p-2">')
                  _err_el.addClass("alert alert-danger err-msg").text("Password and Confirm Password do not match.")
                  $('[name="confirm_password"]').after(_err_el);
                  return;
              }
              $.ajax({
                  url: "http://localhost/furever-homes/classes/Master.php?f=register",
                  method: "POST",
                  data: $(this).serialize(),
                  dataType: "json",
                  error: function(xhr, status, error) {
                      console.error("An error occurred:", xhr.responseText);
                      alert_toast("An error occurred: " + xhr.responseText, 'error');
                  },
                  success: function(resp) {
                      if (resp.status === 'success') {
                          alert_toast("Account successfully registered", 'success');
                          setTimeout(function() {
                              location.reload();
                          }, 2000);
                          clearFormInputs('registration'); // Clear form inputs after successful registration
                      } else if (resp.status === 'failed' && resp.msg) {
                          var errorMessage = $('<div class="p-2 alert alert-danger err-msg">').text(resp.msg);
                          $('#registration [name="email"]').after(errorMessage);
                      } else {
                          console.error("Unexpected response:", resp);
                          alert_toast("An unexpected error occurred", 'error');
                      }
                  }
              });

          });
      });
  </script>