<?php
include_once('includes/header.php');
?>

<?php $page = isset($_GET['p']) ? $_GET['p'] : 'home';  ?>
<?php 
    if(!file_exists($page.".php") && !is_dir($page)){
        include '404.html';
    }else{
    if(is_dir($page))
        include $page.'/index.php';
    else
        include $page.'.php';

    }
?>


  <?php
  include_once('includes/footer.php');
  ?>
