<?php include('includes/header.php'); ?>


<?php
if (isset($_GET['product'])) {

    $product_id = intval($_GET['product']);


    $query = "SELECT * FROM tbl_products WHERE product_id=$product_id";
    $product = mysqli_query($conn, $query);
    if (!$product) {
        die("Query Error: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($product) == 0) {
        header("location:index.php");
        die();
    }
    $product = mysqli_fetch_assoc($product);
?>
    <main>
        <!-- Product Details -->


        <div class="container ">
            <div class="row">
                <di class="col my-4">
                    <div class="custom-display xJzRT my-4">
                        <div class="custom-box custom-relative custom-gKSsqg">
                            <div class="custom-vw-height custom-jRooGA">
                                <span style="box-sizing:border-box;display:block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:absolute;top:0;left:0;bottom:0;right:0">
                                    <img alt="Image one" src="<?php echo $product['product_image'] ?>" decoding="async" data-nimg="fill" class="sc-f25a9fab-2 caQPjX" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:cover">
                                </span>
                                <span style="box-sizing:border-box;display:block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:absolute;top:0;left:0;bottom:0;right:0">
                                    <img alt="Image one" src="<?php echo $product['product_image'] ?>" decoding="async" data-nimg="fill" class="sc-f25a9fab-3 bdziYZ" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain">
                                </span>
                            </div>
                        </div>
                        <div class="custom-side ERekq">
                            <div class="custom-box custom-HsagV">
                                <div style="display:flex;align-items:center;justify-content:space-between">
                                    <h1><?php echo $product['product_name'] ?></h1>
                                    <div class="custom-background kVKlbE"> <?php echo $product['product_status'] == 1 ? 'Available to adopt' : 'Un Available' ?></div>
                                </div>
                                <h2>About</h2>
                                <div class="custom-flex cGrmVj">
                                    <div>Breed</div>
                                    <div> <?php echo $product['breed'] ?></div>
                                </div>
                                <div class="custom-flex cGrmVj">
                                    <div>Colour</div>
                                    <div><?php echo $product['color'] ?></div>
                                </div>
                                <div class="custom-flex cGrmVj">
                                    <div>Age</div>
                                    <div><?php echo $product['age'] ?></div>
                                </div>
                                <div class="custom-flex cGrmVj">
                                    <div>Sex</div>
                                    <div><?php echo $product['sex'] ?></div>
                                </div>
                                <div class="custom-flex cGrmVj">
                                    <div>Arrived Date</div>
                                    <div><?php echo date('d/m/Y', strtotime($product['date_created'])); ?>
                                    </div>
                                </div>

                                <div class="custom-flex cGrmVj">
                                    <div>Size</div>
                                    <div><?php echo $product['weight'] ?> kg</div>
                                </div>

                                <div class="custom-flex cGrmVj">
                                    <div>Price</div>
                                    <div>RS: <?php echo number_format($product['product_price']) ?></div>
                                </div>
                                <button id="form-open-button" class="custom-button custom-egTZUT custom-iDKxSx" type="primary">Apply to Adopt</button>
                            </div>

                        </div>
                    </div>
                </di>
            </div>

            <div class=" butLzW fjleLy">
                <h2>Description</h2>
                <p style="white-space: pre-wrap;">
                <?php echo strip_tags(stripslashes(html_entity_decode($product['product_description'] )))?>
                </p>

            </div>
        </div>
    <?php } else {
    echo '<script type="text/javascript">
        window.location.href=" http://localhost/furever-homes/index.php"
        </script>';
}
    ?>
    <script>
        function openLoginForm() {
            // Code to open the login form
            var home = document.querySelector(".home");
            home.classList.add("show");
        }

        function openAdoptionForm() {
            // Code to open the adoption form
            var modal = document.getElementById("myModal");
            var overlay = document.getElementById("myOverlay");

            modal.style.display = "block";
            overlay.style.display = "block";

            // Close the modal when the close button or overlay is clicked
            var closeBtn = modal.querySelector(".close");
            closeBtn.onclick = function() {
                var formInputs = document.querySelectorAll('#frmsignup input');
                formInputs.forEach(function(input) {
                    if (!input.hasAttribute('readonly')) {
                        input.value = "";
                    }
                });
                modal.style.display = "none";
                overlay.style.display = "none";
            };
            overlay.onclick = function() {
                modal.style.display = "none";
                overlay.style.display = "none";
            };
        }
        $(function() {
            $("#form-open-button").click(function(e) {
                $.ajax({
                    url: './includes/check_login.php',
                    method: 'POST',
                    error: err => {
                        console.log(err);
                    },
                    success: function(resp) {
                        resp = JSON.parse(resp); // Parse the JSON response
                        if (resp.logged_in) {
                            console.log(resp);
                            openAdoptionForm();
                        } else {
                            // User is not logged in, open login form
                            openLoginForm();
                            console.log(resp);

                        }
                    }
                });
            });




        });
    </script>
    <div id="myModal" class="modal">
        <div style=" border: none ;" class="modal-content">
            <span class="close">&times;</span>
            <?php include('./adoption-form.php') ?>
        </div>
    </div>
    <div id="myOverlay" class="overlay"></div>
    </main>
    <?php include('includes/footer.php'); ?>




    </body>

    </html>