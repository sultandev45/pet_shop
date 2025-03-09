
            <!-- Sidebar Start -->
            <div class="col-lg-4">
                

                <!-- Category Start -->
                <div class="mb-5">
                    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Categories</h3>
                    <div class="d-flex flex-column justify-content-start">
                    <?php
                    $category = mysqli_query($conn, "SELECT * FROM tbl_categories Order by category_id DESC ;
                    ");

                    while ($row = mysqli_fetch_assoc($category)) {
                        
                    ?>
                        <a class="h5 bg-light py-2 px-3 mb-2" href="blog.php?catid=<?php echo $row['category_id']?>"><i class="bi bi-arrow-right me-2"></i><?php echo $row['category_name']?></a>
                      <?php }?>  
                    </div>
                </div>
                <!-- Category End -->

                <!-- Recent Post Start -->
                <div class="mb-5">
                    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Recent Post</h3>
                    <?php
                    $featured_posts = mysqli_query($conn, "SELECT * FROM tbl_posts ORDER BY created_at DESC LIMIT 4;
                    ");

                    while ($row = mysqli_fetch_assoc($featured_posts)) {
                        $row['content'] = strip_tags(stripslashes(html_entity_decode($row['content'])));
                    ?>
                    <div class="d-flex overflow-hidden mb-3">
                        <img class="img-fluid" src="<?php echo $row['image']?>" style="width: 100px; height: 100px; border-radius:50%; object-fit: cover;" alt="">
                        <a href="blog_detail.php?blog=<?php echo $row['post_id']?>" class="h5 d-flex align-items-center bg-light px-3 mb-0"><?php echo substr($row['content'],0,15)?>
                        </a>
                    </div>
                   <?php } ?>
                </div>
                <!-- Recent Post End -->

              
            </div>