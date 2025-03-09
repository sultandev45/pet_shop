<?php
include_once('./includes/header.php');
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        echo '<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Reset Your Password</h2>
                    <form id="resetPasswordForm"  >
                        <input type="hidden" name="token" value="'. $token .'">

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
';
    } else {
        echo '<div class="alert alert-danger" role="alert">
   Invalid or expired token. Please try again.
</div>
<a href="http://localhost/furever-homes/" class="btn btn-primary btn-block">Go to Home Page</a>';
    }
} else {
    header('Location:http://localhost/furever-homes/');
}

?>
<script>
    $(document).ready(function() {
        $('#resetPasswordForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            if ($('.err-msg').length > 0)
                $('.err-msg').remove();

            $.ajax({
                url: "http://localhost/furever-homes/classes/Master.php?f=password_reset", // Form action URL
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: function(xhr, status, error) {
                    console.error(error);
                    alert_toast("An error occurred", 'error');
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Password reset successfully", 'success'); // Display success toast
                        setTimeout(function() {
                            window.location.href = "http://localhost/furever-homes/"; // Reload the page
                        }, 2000);
                        clearFormInputs('resetPasswordForm'); // Clear form inputs
                    } else if (resp.status == 'failed') {
                        var _err_el = $('<div>')
                        _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('#resetPasswordForm').prepend(_err_el); // Display error message in the form
                    } else {
                        alert_toast("An iiii error occurred", 'error'); // Display error toast
                    }
                }
            });
        });
    });
</script>
<?php include_once('./includes/footer.php') ?>