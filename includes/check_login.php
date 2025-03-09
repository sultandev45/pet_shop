<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['userdata']['user_id']) ) {
    echo json_encode(array('logged_in' => true));
} else {
    echo json_encode(array('logged_in' => false));
}
?>
