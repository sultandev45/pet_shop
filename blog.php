<?php include_once('./includes/header.php') ?>
<!-- Blog Start -->
<div class="container py-5">
    <div class="main_heading wow zoomIn" data-wow-duration=".6s" data-wow-delay=".6s">
        <h2 class="mheading">Blogs</h2>
    </div>
    <div class="row g-5">
        <!-- Blog list Start -->
        <div class="col-lg-8">

            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $category_id = isset($_GET['catid']) ? 'WHERE c.category_id=' . $_GET['catid'] : null;

            $sql = "SELECT p.post_id, p.title, p.content, p.category_id, p.author_id, p.image, p.created_at,
                               c.category_id, c.category_name, c.category_image, c.category_status
                        FROM tbl_posts p
                        LEFT JOIN tbl_categories c ON p.category_id = c.category_id
                        $category_id LIMIT $offset, $limit ";

            //$pdo = $conn;
            $stmt = mysqli_prepare($conn, $sql);


            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            foreach ($results as $row) {     // Access data using $row['column_name'
                $row['content'] = strip_tags(stripslashes(html_entity_decode($row['content']))); ?>

                <div class="blog-item mb-5">
                    <div class="row g-0 bg-light overflow-hidden">
                        <div class="col-12 col-sm-5 h-100">
                            <img class="img-fluid h-100" src="<?php echo $row['image']; ?>" style="object-fit: cover;">
                        </div>
                        <div class="col-12 col-sm-7 h-100 d-flex flex-column justify-content-center">
                            <div class="p-4">
                                <div class="d-flex mb-3">
                                    <small class="me-3"><i class="bi bi-bookmarks me-2"></i><?php echo $row['category_name'] ?></small>
                                    <small><i class="bi bi-calendar-date me-2 mx-4"></i><?php echo date('M, d-M-Y', strtotime($row['created_at'])); ?></small>
                                </div>
                                <h5 class="text-uppercase mb-3"><?php echo $row['title']; ?></h5>
                                <p><?php echo substr($row['content'], 0, 150) . '...'; ?></p>
                                <a class="text-primary text-uppercase" href="./blog_detail.php?blog=<?php echo $row['post_id']  ?>">Read More<i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Blog list End -->

        <!-- Sidebar Start -->
        <?php include_once('sidebar_blog.php') ?>
        <!-- Sidebar End -->
    </div>
</div>
<!-- Blog End -->
<?php include_once('./includes/footer.php') ?>