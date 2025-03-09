<?php 
if((!isset($_SESSION['userdata']))  ){
	header('Location: http://localhost/furever-homes/');}
if($_SESSION['userdata']['role'] !='admin'){
	header('Location: http://localhost/furever-homes/');}
 ?>