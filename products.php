<?php
include_once('./includes/header.php');
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$limit = 10;
$offset = ($page - 1) * $limit;
if (isset($_GET['category'])) {
    $category_id = intval($_GET['category']);
    $query = "SELECT c.category_name
          FROM tbl_categories c
          WHERE c.category_id = ?  ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $category_name = '';
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_name = htmlspecialchars($row['category_name']);

        $query = "SELECT
              p.*
            FROM
              tbl_products p
            WHERE
              p.category_id = ? AND
              p.product_status = 1  LIMIT $offset,$limit ";
    }
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
} else {
    $category_name = 'Available Pets';
    $query = "SELECT * FROM tbl_products WHERE product_status = 1 ORDER BY product_id DESC LIMIT $offset,$limit ";
    $stmt = mysqli_prepare($conn, $query);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}


?>

<main>

    <div style="margin: 20px 0px;" class="container-fluid d-flex justify-content-center alighn-item-center   py-2 text-center text-white ">

        <!-- Category Title -->
        <div class="main_heading">
            <h2 class="mheading">

                <?php
                if (!empty($category_name)) {
                    echo $category_name;
                } else {
                    echo "No category found.";
                }
                ?>
            </h2>
        </div>
    </div>
    <div class="container grid-container">
        <div class="grid-items">

            <?php
            if (!empty($products)) {
                foreach ($products as $row) {
            ?>
                   

                   <!-- Your HTML code for the product card -->
<div class="product-card">
    <img class="product-img" src="<?php echo $row['product_image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
    <div class="product-details">
        <h5 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
        <p class="product-price">Rs. <?php echo number_format($row['product_price']) ; ?></p>
        <a href="product-detail.php?product=<?php echo $row['product_id']; ?>" class="view-details-btn">View Details</a>
    </div>
</div>


            <?php
                }
            } else {
                echo "<div class='container-fluid'><h1 style='text-align: center;'>No products found.</h1></div>";
            } ?>


        </div>
    </div>
    <?php

    $sql = "SELECT *FROM tbl_products";
    $result = mysqli_query($conn, $sql);
if (isset($_GET['category'])) {
      $cat_id=intval($_GET['category']);
    $sql = "SELECT *FROM tbl_products where category_id=$cat_id";
    $result = mysqli_query($conn, $sql);
            $category='&&category='.$cat_id; }else{$category=null;}
    if (mysqli_num_rows($result) > 0) {
        $total_record = mysqli_num_rows($result);
        
        $total_page = ceil($total_record / $limit);
        echo ' <div class="col-12 d-flex justify-content-center my-4">
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-lg m-0">';
        if ($page > 1) {
            echo '<li class="page-item "><a class="page-link rounded-0" href="products.php?page='.($page - 1),$category.'"aria-label="Previous"> <span aria-hidden="true"><i class="bi bi-arrow-left"></i></span></a></li>';
        }

        for ($i = 1; $i <= $total_page; $i++) {
            if ($page == $i) {
                $active = "style="."'pointer-events: none !important;
                color: #f2f2f2 !important;
                background-color: #01d28e !important;'";
               
            } else {
                $active = "";
            }
            echo "<li class='page-item'><a $active class='page-link ' href='products.php?page=$i$category'>$i</a></li>";

        }
        if ($total_page > $page) {
            echo '<li class="page-item"><a  class="page-link rounded-0" href="products.php?page='.($page + 1),$category. '"aria-label="Next">                            <span aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a></li>';
        }

        echo "</ul>";
    }
    ?>
</main>
<?php include_once('./includes/footer.php') ?>