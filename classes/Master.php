<?php

require_once('../config.php');



class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}

	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_category()
	{
		// File handling
		$file_name = ''; // Initialize empty file name
		$old_image_changed = false; // Flag to track if old image is changed
		if (!empty($_FILES['img']['name'])) { // Check if file is uploaded
			// File upload validation
			// ...
			// Move the uploaded file to the desired directory
			$new_name = time() . "-" . $_FILES['img']['name']; // Generate a unique file name

			// Create directory if it doesn't exist
			$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/furever-homes/uploads/category/'; // Define upload directory
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true); // Create directory recursively
			}

			if (move_uploaded_file($_FILES['img']['tmp_name'], $upload_dir . $new_name)) {
				$file_name = 'http://' . $_SERVER['HTTP_HOST'] . '/furever-homes/uploads/category/' . $new_name; // Set file path using base URL

				// Check if old image is changed
				if (!empty($_POST['old_image']) && $_POST['old_image'] !== $file_name) {
					$old_image_changed = true;
				}
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = 'Failed to move uploaded file.';
				return json_encode($resp); // Return error response
			}
		}

		// Get category details from POST
		$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
		$category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
		$category_status = isset($_POST['category_status']) ? $_POST['category_status'] : '';

		// Insert or update category in database
		if (empty($category_id)) {
			// Insert new category
			$sql = "INSERT INTO `tbl_categories` (`category_name`, `category_status`, `category_image`) 
					VALUES ('{$category_name}', '{$category_status}', '{$file_name}')";
		} else {
			// Update existing category
			if ($old_image_changed || !empty($file_name)) {
				// If old image changed or new image uploaded, update category with image
				$sql = "UPDATE `tbl_categories` 
						SET `category_name` = '{$category_name}', `category_status` = '{$category_status}', `category_image` = '{$file_name}' 
						WHERE `category_id` = '{$category_id}'";
			} else {
				// If old image not changed and no new image uploaded, update category without changing the image
				$sql = "UPDATE `tbl_categories` 
						SET `category_name` = '{$category_name}', `category_status` = '{$category_status}' 
						WHERE `category_id` = '{$category_id}'";
			}
		}

		// Execute SQL query
		if ($this->conn->query($sql)) {
			$resp['status'] = 'success';
			if (empty($category_id))
				$this->settings->set_flashdata('success', "New Category successfully saved.");
			else
				$this->settings->set_flashdata('success', "Category successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . " [{$sql}]";
		}

		return json_encode($resp); // Return JSON response
	}




	function delete_category()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tbl_categories` where category_id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Category successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_product()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('product_id', 'product_description', 'product_image'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['product_description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `product_description`='" . addslashes(htmlentities($product_description)) . "' ";
		}
		if (empty($product_id)) {
			$check = $this->conn->query("SELECT * FROM `tbl_products` where `product_name` = '{$product_name}' " . (!empty($product_id) ? " and product_id != {$product_id} " : "") . " ")->num_rows;
			if ($this->capture_err())
				return $this->capture_err();
			if ($check > 0) {
				$resp['status'] = 'failed';
				$resp['msg'] = "Product already exists.";
				return json_encode($resp);
				exit;
			}
		}
		if (empty($product_id)) {
			$sql = "INSERT INTO `tbl_products` set {$data} ";
			$save = $this->conn->query($sql);
			$product_id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `tbl_products` set {$data} where product_id = '{$product_id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			// Handle image upload and update image address in database
			if (isset($_FILES['product_image']) && !empty($_FILES['product_image']['tmp_name'])) {
				$upload_path = "uploads/product_" . $product_id;
				if (!is_dir(base_app . $upload_path))
					mkdir(base_app . $upload_path);

				// Move uploaded image to the upload directory
				$file_name = $_FILES['product_image']['name'];
				$file_tmp = $_FILES['product_image']['tmp_name'];
				$target_file = base_app . $upload_path . '/' . $file_name;
				if (move_uploaded_file($file_tmp, $target_file)) {
					// Image uploaded successfully, update image address in database
					$target_file = base_url . $upload_path . '/' . $file_name;
					$update_img_sql = "UPDATE `tbl_products` SET `product_image`='{$target_file}' WHERE product_id='{$product_id}'";
					$this->conn->query($update_img_sql);
				}
			}
			$resp['status'] = 'success';
			if (empty($product_id))
				$this->settings->set_flashdata('success', "New Product successfully saved.");
			else
				$this->settings->set_flashdata('success', "Product successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_product()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tbl_products` where product_id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Product successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function save_blog()
	{
		extract($_POST);
		$auther_id =   $_SESSION['userdata']['user_id'];
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('post_id', 'image'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . addslashes(htmlentities($v)) . "' ";
			}
		}

		if (empty($post_id)) {
			// Insert new blog post
			$sql = "INSERT INTO `tbl_posts` SET {$data} ,`author_id` = '{$auther_id}'";

			$save = $this->conn->query($sql);
			$post_id = $this->conn->insert_id;
		} else {
			// Update existing blog post
			$sql = "UPDATE `tbl_posts` SET {$data} WHERE post_id = '{$post_id}'";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			// Handle image upload
			// Handle image upload and update image address in database
			if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
				$upload_path = "uploads/post_" . $post_id;
				if (!is_dir(base_app . $upload_path))
					mkdir(base_app . $upload_path);

				// Move uploaded image to the upload directory
				$file_name = $_FILES['image']['name'];
				$file_tmp = $_FILES['image']['tmp_name'];
				$target_file = base_app . $upload_path . '/' . $file_name;
				if (move_uploaded_file($file_tmp, $target_file)) {
					// Image uploaded successfully, update image address in database
					$image_url = base_url . $upload_path . '/' . $file_name;
					$update_image_url_sql = "UPDATE `tbl_posts` SET `image` = '{$image_url}' WHERE post_id = '{$post_id}'";
					$this->conn->query($update_image_url_sql);
				}
			}

			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Blog post successfully saved.");
			else
				$this->settings->set_flashdata('success', "Blog post successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}

		return json_encode($resp);
	}

	function delete_blog()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tbl_posts` where post_id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Blog successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']);
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'confirm_password'),)) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `tbl_users` where `email` = '{$email}'  ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		} else {
			$sql = "INSERT INTO `tbl_users` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		}

		if ($save) {
			$resp['status'] = 'success';
			// Removed the echo statement here

			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			if (isset($_SESSION['userdata'])) {
				session_destroy();
			}
			$qry = $this->conn->query("SELECT * from tbl_users where user_id = ' $id'");
			foreach ($qry->fetch_array() as $k => $v) {
				$_SESSION['userdata'][$k] = $v;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function place_order()
	{
		extract($_POST);
		$client_id = $_SESSION['userdata']['user_id'];

		$data = " client_id = '{$client_id}' ";
		$data .= " ,payment_method = '{$payment_method}' ";
		$data .= " ,amount = '{$amount}' ";
		$data .= " ,paid = '{$paid}' ";
		$data .= " ,delivery_address = '{$delivery_address}' ";
		$order_sql = "INSERT INTO `orders` set $data";
		$save_order = $this->conn->query($order_sql);
		if ($this->capture_err())
			return $this->capture_err();
		if ($save_order) {
			$order_id = $this->conn->insert_id;
			$data = '';
			$quantity = 1;


			if (isset($_SESSION['adoption_form_data']['product_id'])) {
				$product_id = $_SESSION['adoption_form_data']['product_id'];
			} else {
				$product_id = 2;
			}
			// Assuming $client_id is defined elsewhere
			$product_query = $this->conn->query("SELECT p.product_name, p.product_price FROM `tbl_products` p WHERE p.product_id = '{$product_id}'");
			while ($row = $product_query->fetch_assoc()) :
				if (!empty($data)) $data .= ", ";
				$total = $row['product_price'];
				$data .= "('{$order_id}','{$product_id}','{$quantity}','{$row['product_price']}', $total)";
			endwhile;
			$list_sql = "INSERT INTO `order_list`  (order_id,product_id,quantity,price,total) VALUES {$data} ";
			$save_olist = $this->conn->query($list_sql);
			if ($this->capture_err())
				return $this->capture_err();
			if ($save_olist) {
				$data = " order_id = '{$order_id}'";
				$data .= " ,total_amount = '{$amount}'";
				$save_sales = $this->conn->query("INSERT INTO `sales` set $data");
				if ($this->capture_err())
					return $this->capture_err();
				$resp['status'] = 'success';
			}
			if ($save_sales &&  isset($_SESSION['adoption_form_data'])) {
				$adoption_data = $_SESSION['adoption_form_data'];
				$fullname = $adoption_data['full_name'];
				$email = $adoption_data['email'];
				$city = $adoption_data['city'];
				$other_pets = $adoption_data['inquiry'];
				$adoption_reason = $adoption_data['inquiry1'];
				$housing_type = $adoption_data['inquiry2'];
				$household_description = $adoption_data['inquiry3'];
				$financial_responsibility = $adoption_data['inquiry4'];
				$pet_experience = $adoption_data['inquiry5'];
				$home_visit_agreement = $adoption_data['inquiry6'];
				$update_agreement = $adoption_data['inquiry7'];
				$data = "UserID = '{$client_id}', 
         FullName = '{$fullname}', 
         Email = '{$email}', 
         City = '{$city}', 
         OtherPets = '{$other_pets}', 
         AdoptionReason = '{$adoption_reason}', 
         HousingType = '{$housing_type}', 
         HouseholdDescription = '{$household_description}', 
         FinancialResponsibility = '{$financial_responsibility}', 
         PetExperience = '{$pet_experience}', 
         HomeVisitAgreement = '{$home_visit_agreement}', 
         UpdateAgreement = '{$update_agreement}'";
				$save_adoptform = $this->conn->query("INSERT INTO `adoptionforms` set $data");
				if ($this->capture_err())
					return $this->capture_err();
				$resp['status'] = 'success';
			}
			if ($save_adoptform) {
				require_once 'mailConfig.php';
				unset($_SESSION['adoption_form_data']);
				$mail->setFrom('your@example.com', $fullname);
				$mail->addAddress($email);                            // Add a recipient

				//Content
				try{$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'Order Purchase Confirmation';
				$mail->Body    = '<!DOCTYPE html>
				<html lang="en">
				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Order Purchase Confirmation</title>
				</head>
				<body>
					<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
						<h2>Order Purchase Confirmation</h2>
						<p>Dear Pet Lover,</p>
						<p>Thank you for purchasing from our online pet shop!</p>
						<p>We will notify you once your application is accepted.</p>
						<p>If you have any questions or concerns, feel free to reach out to us.</p>
						<p>Best Regards,</p>
						<p>The Furever-home Team</p>
					</div>
				</body>
				</html>
				';

				$sendEmail = $mail->send();
				if (!$sendEmail) {
					$resp['msg'] = "Mailer Error: " . $mail->ErrorInfo;
				} else {
					$resp['msg'] = "Confirmation mail has been sent to your registered email address.";
				}}catch (Exception $e) {
					$resp['status'] = 'error';
					$resp['msg'] = $e->getMessage();
				}
			} else {
				$resp['status'] = 'failed';
				$resp['err_sql'] = $save_olist;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err_sql'] = $save_order;
		}
		return json_encode($resp);
	}
	function delete_order()
	{
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `orders` where id = '{$id}'");
		$delete2 = $this->conn->query("DELETE FROM `order_list` where order_id = '{$id}'");
		$delete3 = $this->conn->query("DELETE FROM `sales` where order_id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Order successfully deleted");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function update_order_status()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `status` = '$status' where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", " Order status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}function pay_order()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `paid` = '1' where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", " Order payment status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_account()
	{
		extract($_POST);
		$data = "";


		if (!empty($password)) {
			$_POST['password'] = md5($password);
			if (md5($cpassword) != $this->settings->userdata('password')) {
				$resp['status'] = 'failed';
				$resp['msg'] = "Current Password is Incorrect";
				return json_encode($resp);
				exit;
			}

		}
		$check = $this->conn->query("SELECT email FROM `tbl_users`  where `email`='{$email}' and `user_id` != '{$user_id}' ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		foreach ($_POST as $k => $v) {
			if ($k == 'cpassword' || ($k == 'password' && empty($v)))
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("UPDATE `tbl_users` SET $data where user_id = '{$user_id}' ");
		if ($save) {
			foreach ($_POST as $k => $v) {
				if ($k != 'cpassword')
					$this->settings->set_userdata($k, $v);
			}

			$this->settings->set_userdata('user_id', $this->conn->insert_id);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function subscribe_email()
	{
		extract($_POST);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Please enter a valid email address.";
			return json_encode($resp);
		}

		$check = $this->conn->query("SELECT * FROM tbl_subscriber WHERE subscriber='$email'")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "A user already subscribed with this email address.";
			return json_encode($resp);
		}

		$save = $this->conn->query("INSERT INTO tbl_subscriber (subscriber) VALUES ('$email')");

		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "Temporary error. Please try again later.";
		}

		// Return JSON response
		return json_encode($resp);
	}
	function Reset_link()
	{
		function generate_reset_token()
		{
			return bin2hex(random_bytes(16));
		}
		require_once 'mailConfig.php';

		$email = $_POST['email'];

		// Validate email format
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Please enter a valid email address.";
			return json_encode($resp);
		}

		// Check if the email exists in the user table
		$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows == 0) {
			$resp['status'] = 'incorrect';
			$resp['msg'] = "No user found with this email address.";
			return json_encode($resp);
		}
		$user = $result->fetch_assoc();

		$token = generate_reset_token();


		// Set the expiry time to 24 hours from the current time
		$expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

		// Insert the token and expiry into the database
		$query = "INSERT INTO password_resets (user_id, token, expiry) VALUES (?, ?, ?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("iss", $user['user_id'], $token, $expiry);
		if (!$stmt->execute()) {
			$resp['status'] = 'error';
		} else {

			$reset_link = 'http://localhost/furever-homes/reset_password.php?token=' . $token;

			try {

				//Recipients
				$mail->setFrom('your@example.com', 'Your Name');
				$mail->addAddress($email);                            // Add a recipient

				//Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'Password Reset Link';
				$mail->Body    = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #ffffff;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #333333;
                }
                p {
                    color: #666666;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 5px;
                }
                .button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Password Reset</h1>
                <p>Click the following link to reset your password:</p>
                <a href="' . $reset_link . '" class="button">Reset Password</a>
            </div>
        </body>
        </html>
    ';


				$mail->send();
				$resp['status'] = 'success';
				$resp['msg'] = "Reset link sent successfully.";
			} catch (Exception $e) {
				$resp['status'] = 'failed' . $e;
				$resp['msg'] = "Failed to send reset link. Error: {$mail->ErrorInfo}";
			}
		};
		$stmt->close();
		// Return JSON response
		return json_encode($resp);
	}
	function password_reset()
{
    // Assuming the form data is accessed directly
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Initialize the response array
    $response = array();

    try {
        // Check if new password and confirm password match
        if ($new_password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }

        // Fetch the user ID associated with the token using a JOIN operation
        $query = "SELECT u.user_id FROM tbl_users u 
                  INNER JOIN password_resets pr ON u.user_id = pr.user_id
                  WHERE pr.token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user ID is found for the token
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $user_id = $user['user_id'];

            // Hash the new password
            $hashed_password = md5($new_password);

            // Update the password in the tbl_users table
            $update_query = "UPDATE tbl_users SET password = ? WHERE user_id = ?";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            if ($update_stmt->execute()) {
				// Remove the record from the password_resets table since it has been used
                $delete_query = "DELETE FROM password_resets WHERE user_id = ?";
                $delete_stmt = $this->conn->prepare($delete_query);
                $delete_stmt->bind_param("i", $user_id);
                $delete_stmt->execute();

                // Set the response message and status to success
                $response['status'] = 'success';
                // Optionally include additional data in the response
                // $response['user_id'] = $user_id;
            } else {
                throw new Exception('Failed to update password. Please try again later.');
            }
        } else {
            // No user found for the token
            throw new Exception('Invalid or expired token. Please try again.');
        }
    } catch (Exception $e) {
        // Handle exceptions
        $response['status'] = 'failed';
        $response['msg'] = $e->getMessage();
    }

    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Return JSON response
    echo json_encode($response);
}

}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'delete_product':
		echo $Master->delete_product();
		break;

	case 'save_blog':
		echo $Master->save_blog();
		break;
	case 'delete_blog':
		echo $Master->delete_blog();
		break;
	case 'register':
		echo $Master->register();
		break;

	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'place_order':
		echo $Master->place_order();
		break;
	case 'update_order_status':
		echo $Master->update_order_status();
		break;
	case 'pay_order':
		echo $Master->pay_order();
		break;
	case 'update_account':
		echo $Master->update_account();
		break;
	case 'delete_order':
		echo $Master->delete_order();
		break;
	case 'reset_link';
		echo $Master->Reset_link();
		break;
		case 'password_reset';
		echo $Master->password_reset();
		break;
	case 'subscribe_email':
		echo  $Master->subscribe_email();
		break;
	case 'place_order':
		echo  $Master->place_order();
		break;
	default:
		// echo $sysset->index();
		break;
}
