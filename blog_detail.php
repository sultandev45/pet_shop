<?php include_once('./includes/header.php') ?>

<!-- Blog Start -->
<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <!-- Blog Detail Start -->
            <?php
            if (isset($_GET['blog'])) {
                $postID = $_GET['blog'];
                $query = "SELECT * FROM tbl_posts where post_id=$postID ;
                    ";
                $post_data = mysqli_query($conn, $query);
                if (!$post_data) {
                    die("Query Error: " . mysqli_error($conn));
                }
                if (mysqli_num_rows($post_data) == 0) {
                    redirect("index.php");
                    die();
                }
                $row = mysqli_fetch_assoc($post_data);
                $row['content'] = strip_tags(stripslashes(html_entity_decode($row['content'])));
            ?>
                <div class="mb-5">
                    <img class="img-fluid w-100 rounded mb-5" src="<?php echo $row['image'] ?>" alt="">
                    <h1 class="text-uppercase mb-4"><?php echo $row['title'] ?></h1>
                    <p>
                        <?php echo $row['content'] ?>
                    </p>
                </div><?php } else {
                        redirect('index.php');
                    } ?>
            <!-- Blog Detail End -->

        </div>
        <?php include_once('sidebar_blog.php') ?>
        <!-- Sidebar End -->
    </div>
</div>
<!-- Blog End -->



<?php include_once('./includes/footer.php') ?>