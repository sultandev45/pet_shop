<div class="landing-page">
    <header class="hero-section">
        <div class="banner ">
            <div id="demo" class="carousel slide" data-ride="carousel">

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/banner_97085banner_74661banner_30870v1-pe-supplier-banner-1200x400-6.jpg" alt="V1 Pet Supplies">
                    </div>
                    <div class="carousel-item ">
                        <img src="images/banner_901banner_79215banner_73786v1-pe-supplier-banner-1200x400-5.jpg" alt="V1 Pet Supplies">
                    </div>
                    <div class="carousel-item ">
                        <img src="images/banner_97085banner_74661banner_30870v1-pe-supplier-banner-1200x400-6.jpg" height="400px" alt="V1 Pet Supplies">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
            <div class="banner_content">
                <h6>We Keep Pets For Pleasure</h6>
                <h1>Helping Your Pets Get Rid Of Annoying Pets.</h1>
                <h4>You can do anything here. So don't worry about it. In your world you can create.</h4>
                <div class="readmore_button">
                    <a href="./?p=products">SHOP NOW</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Herosection -->

    <main>

        <!-- Category section -->
        <div class="category_main">
            <div class="container">
                <div class="category_segment">
                    <ul class="nav catcastmnv" id="myTab" role="tablist">
                        <!-- category list -->
                        <?php
                        $categories = mysqli_query($conn, "SELECT * FROM tbl_categories");

                        while ($row = mysqli_fetch_assoc($categories)) {
                        ?>
                            <li class="nav-item active" role="presentation">
                                <a class="nav-link" id="YanPet-tab" href="products.php?category=<?php echo $row['category_id'] ?>" role="tab" aria-controls="YanPet" aria-selected="true">
                                    <div class="cat_card">
                                        <div class="cat_img">
                                            <img src="<?php echo $row['category_image']; ?>" alt="">
                                        </div>
                                        <div class="cat_details">
                                            <div class="cat_name  text-center"><?php echo $row['category_name'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Category End -->


        <!-- Availableproducts -->
        <section>
            <div class="container ">
                <div class="main_heading ">
                    <img src="images/150x150-pet-icon.png" alt="">
                    <h2 class="mheading">Available Pets</h2>
                </div>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="YanPet" role="tabpanel" aria-labelledby="YanPet-tab">
                        <div class="row">

                            <?php
                            $Available_products = mysqli_query($conn, "SELECT * FROM tbl_products WHERE product_status = 1 ORDER BY RAND() LIMIT 4");

                            while ($row = mysqli_fetch_assoc($Available_products)) {

                            ?>



                                <div class="product-card">
                                    <img class="product-img" src="<?php echo $row['product_image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                                    <div class="product-details">
                                        <h5 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                                        <p class="product-price">Rs. <?php echo number_format($row['product_price']); ?></p>
                                        <a href="product-detail.php?product=<?php echo $row['product_id']; ?>" class="view-details-btn">View Details</a>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>



                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Available Products End -->

        <!-- Read more start -->

        <div class="pet_paralax">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="para_text wow bounceInLeft" data-wow-duration=".6s" data-wow-delay=".6s">
                            <h2>Want a pet for your loved ones?</h2>
                            <p>Applaws Chicken &amp; Lamb Small &amp; Medium Breed Dry Adult Dog Food contains 75% meat, and
                                does not
                                contain cheaper additives like cereal no grains to bulk up the food.</p>
                            <div class="readmore_button">
                                <a href="./?p=blog">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Section Start -->
        <div class="pet_blog">
            <div class="container">
                <div class="main_heading ">
                    <img src="images/150x150-pet-icon.png" alt="">
                    <h2 class="mheading">Latest Blogs</h2>
                </div>
                <div class="row">
                    <?php
                    $featured_posts = mysqli_query($conn, "SELECT * FROM tbl_posts ORDER BY created_at DESC LIMIT 2;
                    ");

                    while ($row = mysqli_fetch_assoc($featured_posts)) {
                        $row['content'] = strip_tags(stripslashes(html_entity_decode($row['content']))); ?>
                    

                        <div class="col-md-6 py-sm-4 py-lg-2">
                            <div class="blogg_box">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="bbox_img">
                                            <img style="width: 130%;height: 100%; aspect-ratio: 3/3; object-fit: cover; " src="<?php echo $row['image'] ?>" title="Upon of seasons earth" alt="Upon of seasons earth">
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-center">
                                        <div class="bbox_text">
                                            <h4><span><i class="mx-2 far fa-calendar-alt"></i><?php echo date('D, d-M-Y', strtotime($row['created_at'])); ?></span></h4>
                                            <h5><?php echo $row['title'] ?></h5>
                                            <p></p>
                                            <p><?php echo substr($row['content'], 0, 80) . '...'; ?></p>
                                            <div class="readmore_buttonsm">
                                                <a href="./blog_detail.php?blog=<?php echo $row['post_id']  ?>">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                </div>
            </div>
        </div>
        <!-- Blog Section END -->
        <!-- Latest Products Section -->
        <section class="latest-products">
            <div class="container">
                <div class="main_heading ">
                    <img src="images/150x150-pet-icon.png" alt="">
                    <h2 class="mheading">Latest Pets</h2>
                </div>
                <div class="row">
                    <?php

                    $sql = "SELECT * FROM tbl_products 
            LEFT JOIN tbl_categories ON tbl_products.category_id=tbl_categories.category_id
            ORDER BY tbl_products.product_id DESC LIMIT 5 ";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {


                    ?>
                            <div class=" col-sm-6 mb-4 col-md-4  col-lg-3">
                                <a href="product-detail.php?product=<?php echo $row['product_id']; ?>">
                                    <!-- <div class="card">
                                        <img style="aspect-ratio: 4/4;" src="<?php echo $row['product_image']; ?>" class="card-img-top" alt="Product 1">
                                        <div class="card-body px-0 py-2 text-center">
                                            <h5 class="item-name"><?php echo $row['product_name']; ?></h5>
                                            <p class="card-text"><?php echo substr($row['product_description'], 0, 10) . '...'; ?></p>
                                            <div class="star-rating my-2">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <span id='price'>Price: <span class="item-price"> RS. <?php echo number_format($row["product_price"], 2) ?></span></span>
                                            <a href="product-detail.php?product=<?php echo $row['product_id']; ?>" class="btn m-0 add-tocart">Buy Now</a>
                                        </div>
                                    </div> -->
                                    <div class="product-card">
                                        <img class="product-img" src="<?php echo $row['product_image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                                        <div class="product-details">
                                            <h5 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                                            <p class="product-price">Rs. <?php echo number_format($row['product_price']); ?></p>
                                            <a href="product-detail.php?product=<?php echo $row['product_id']; ?>" class="view-details-btn">View Details</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </section>
        <!-- Latest Products Section END-->

        <!---------------FAQ Markups start------------->


        <section class="faq">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center ">
                        <div class="main_heading">
                            <img src="images/150x150-pet-icon.png" alt="">
                            <h2 class="mheading">GENERAL FAQs</h2>
                        </div>
                    </div>

                </div>
            </div><br><br><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-7 colg-10 mx-md-auto">
                        <div class="panel-group" id="accordian">
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingOne">
                                    <h4 class="panel-title">
                                        <a href="#collapseOne" data-toggle="collapse" data-parent="#accordian">Have you any questions ?</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" aria-labelledby="headingone">
                                    <div class="panel-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a href="#collapseTwo" class="collapsed" data-toggle="collapse" data-parent="#accordian">Are you getting it exactly ?</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingThree">
                                    <h4 class="panel-title">
                                        <a href="#collapseThree" class="collapsed" data-toggle="collapse" data-parent="#accordian">Is it clearly explained ?</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros.
                                        </p>
                                    </div>
                                </div>

                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingfour">
                                    <h4 class="panel-title">
                                        <a href="#collapsefour" class="collapsed" data-toggle="collapse" data-parent="#accordian"> Course is deserving anything ?</a>
                                    </h4>
                                </div>
                                <div id="collapsefour" class="panel-collapse collapse" aria-labelledby="headingfour">
                                    <div class="panel-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, landit posuere tortor aliquam vitae. Curabitur molestie eros.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="freeimage  d-none d-lg-block ">
                        <div class=" col-md-2 col-md-offset-1">
                            <img src="./images/faq (2).jpg">
                        </div>

                    </div>


                </div>
            </div>

        </section>


        <!------------ FAQ Markups End------------->
    </main>
</div>