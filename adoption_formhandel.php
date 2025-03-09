<?php
session_start(); // Start the session

if(isset($_POST['submit_adoption'])) { // Check if the form is submitted
    
    $_SESSION['adoption_form_data'] = $_POST;

    // Store fixed values for fields in session data if available, otherwise, keep them from the form
    $_SESSION['adoption_form_data']['fullname'] = isset($_SESSION['userdata']['fullname']) ? htmlspecialchars($_SESSION['userdata']['fullname']) : $_POST['full_name'];
    $_SESSION['adoption_form_data']['email'] = isset($_SESSION['userdata']['email']) ? htmlspecialchars($_SESSION['userdata']['email']) : $_POST['email'];
    $_SESSION['adoption_form_data']['city'] = 'Multan';

    // Redirect user to place order page
    header("Location: ./?p=place_order");
    exit();
} else {
   
    header("Location:adoption-form.php");
    exit();
}

?>
