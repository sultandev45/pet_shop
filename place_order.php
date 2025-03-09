<?php
if (isset($_SESSION['adoption_form_data'])) {
    $product_id = $_SESSION['adoption_form_data']['product_id'];

    $qry = $conn->query("SELECT *FROM tbl_products WHERE product_id=$product_id");
    while ($row = $qry->fetch_assoc()) :
        $total = $row['product_price'];
        $adoption_data = $_SESSION['adoption_form_data'];
        $product_id = $adoption_data['product_id'];
    endwhile;
} else {
    redirect('index.php');
}
?>

<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body"></div>
            <h3 class="text-center"><b>Checkout</b></h3>
            <hr class="border-dark">
            <form action="" id="place_order">
                <input type="hidden" name="amount" value="<?php echo $total ?>">
                <input type="hidden" name="payment_method" value="cod">
                <input type="hidden" name="paid" value="0">
                <div class="row row-col-1 justify-content-center">
                    <div class="col-6">
                        <div class="form-group col">
                            <label for="" class="control-label">Delivery Address</label>
                            <textarea id="delivery_address" cols="30" rows="3" name="delivery_address" class="form-control" style="resize:none" required placeholder="Please enter your delivery address"></textarea>
                            <div class="message-error" id="inquiryError"></div>
                        </div>
                        <div class="col">
                            <span>
                                <h4><b>Total:</b> <?php echo number_format($total) ?></h4>
                            </span>
                        </div>
                        <hr>
                        <div class="col my-3">
                            <h4 class="text-muted">Payment Method</h4>
                            <div class="d-flex w-100 justify-content-between">
                                <button class="btn btn-flat btn-dark">Cash on Delivery</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
      
        $('#place_order').submit(function(e) {
            e.preventDefault();
            var deliveryAddress = $('textarea[name="delivery_address"]');
        var deliveryAddressValue = deliveryAddress.val();

        // Check if the delivery address is empty
        if (deliveryAddressValue.trim() === '') {
            // Show the error message
            deliveryAddress.addClass("is-invalid");
            deliveryAddress.next().html("Delivery address is required.");
            return; // Stop further execution
        } else {
            // Remove any existing error message and class
            deliveryAddress.removeClass("is-invalid");
            deliveryAddress.next().html("");
        }
            $.ajax({
                url: "http://localhost/furever-homes/classes/Master.php?f=place_order",
                method: 'POST',
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error  in send occurred", "error");

                },
                success: function(resp) {
                    if (!!resp.status && resp.status == 'success') {
                        alert_toast("Order Successfully placed.", "success");
                        setTimeout(function() {
                            // Display SweetAlert on success
                            Swal.fire({
                                title: 'Thank you!',
                                html: '<div style="color: #333; font-size: 16px; text-align: center;">Your order has been successfully placed and'+'<div style="color: #333; font-size: 16px; text-align: center;">' + resp.msg + '</div>'+' We will be in touch when your order is ready for pickup or delivery. Good luck!</div>',
                                icon: 'success',
                                confirmButtonText: 'OK',

                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'http://localhost/furever-homes/';
                                }
                            });
                        }, 2000);
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", "error");

                    }
                }
            });
        });
    });
</script>