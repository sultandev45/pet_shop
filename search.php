<?php
include_once('./includes/header.php');
if (!isset($_GET['query'])) {
    redirect('index.php');
} else {
    $term = $_GET['query']; ?>
    <main>

        <div style="margin: 20px 0px;" class="container-fluid d-flex justify-content-center alighn-item-center   py-2 text-center text-white ">

            <!-- Category Title -->
            <div class="main_heading">
                <h2 class="mheading">Search : <span style="color:black"><?php echo $term; ?></span>
                </h2>
            </div>
        </div>
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $limit = 3;
        $offset = ($page - 1) * $limit;
        if (isset($_GET['query'])) {
            $term = $_GET['query'];
            $sql = "SELECT * FROM tbl_products 
     LEFT JOIN tbl_categories ON tbl_products.category_id=tbl_categories.category_id
     WHERE tbl_products.product_name LIKE '%{$term}%' ORDER BY tbl_products.product_id DESC LIMIT $offset,$limit ";
       

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {  ?>
            <div class="container grid-container">
                <div class="grid-items">
                    <?php while ($row = mysqli_fetch_assoc($result)) {  ?>
                        <div class="product-card">
                            <img class="product-img" src="<?php echo $row['product_image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                            <div class="product-details">
                                <h5 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                                <p class="product-price">Rs. <?php echo number_format($row['product_price']); ?></p>
                                <a href="product-detail.php?product=<?php echo $row['product_id']; ?>" class="view-details-btn">View Details</a>
                            </div>
                        </div>
                <?php   }
                } else {
                    echo "<h1 style='text-align:center;'>NO RECORD FOUND</h2>";
                } ?>

                </div>
            </div>
        <?php
        if (isset($_GET['query'])) {
            $term = $_GET['query'];
        }?>
         <?php
    $sql ="SELECT *FROM tbl_products WHERE product_name LIKE '%{$term}%' ";
    $result = mysqli_query($conn, $sql);
    // echo'<script>alert('.$term.')</script>';
    if (mysqli_num_rows($result) > 0) {
        $total_record = mysqli_num_rows($result);
        $search_term="search=".$term."&&";
        $total_page = ceil($total_record / $limit);
        echo ' <div class="col-12 d-flex justify-content-center my-4">
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-lg m-0">';
        if ($page > 1) {
            echo '<li class="page-item "><a class="page-link rounded-0" href="search.php?'.$search_term.'page=' . ($page - 1) . '"aria-label="Previous"> <span aria-hidden="true"><i class="bi bi-arrow-left"></i></span></a></li>';
        }

        for ($i = 1; $i <= $total_page; $i++) {
            if ($page == $i) {
                $active = "active";
            } else {
                $active = "";
            }
            echo "<li class=page-item " . $active . "><a class='page-link' href='search.php?".$search_term." page=$i'>$i</a></li>";
        }
        if ($total_page > $page) {
            echo '<li class="page-item"><a  class="page-link rounded-0" href="search.php?'.$search_term.'page=' . ($page + 1) . 'aria-label="Next">                            <span aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a></li>';
        }

        echo "</ul>";
    } }}
    ?>
    

    </main>
    <?php include_once('./includes/footer.php')?>