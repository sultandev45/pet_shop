<?php
if ((!isset($_SESSION['userdata']))) {
    header('Location: http://localhost/furever-homes/');
}
if ($_SESSION['userdata']['role'] != 'admin') {
    header('Location: http://localhost/furever-homes/');
}

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `tbl_products` where product_id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($product_id) ? "Update " : "Create New " ?> Product</h3>
    </div>
    <div class="card-body">
        <form action="" id="product-form">
            <input type="hidden" name="product_id" value="<?php echo isset($product_id) ? $product_id : '' ?>">
            <div class="form-group">
                <label for="category_id" class="control-label">Category</label>
                <select name="category_id" id="category_id" class="custom-select select2" required>
                    <option value=""></option>
                    <?php
                    $qry = $conn->query("SELECT * FROM `tbl_categories` order by category_name asc");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <option value="<?php echo $row['category_id'] ?>" <?php echo isset($category_id) && $category_id == $row['category_id'] ? 'selected' : '' ?>><?php echo $row['category_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sex" class="control-label">Sex</label>
                <select name="sex" id="sex" class="custom-select" required>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS count FROM tbl_products");
                    $row = $result->fetch_assoc();
                    $count = $row['count'];
                    if ($count == 0) {
                    ?>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <?php
                    } else {

                        $qry = $conn->query("SELECT DISTINCT sex FROM tbl_products WHERE sex IN ('male', 'female')");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['sex'] ?>"><?php echo ucfirst($row['sex']) ?></option>
                    <?php endwhile;
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product_name" class="control-label">Product Name</label>
                <textarea name="product_name" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($product_name) ? $product_name : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_breed" class="control-label">Breed</label>
                <textarea name="breed" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($breed) ? $breed : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="color" class="control-label">Color</label>
                <textarea name="color" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($color) ? $color : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="age" class="control-label">Age</label>
                <textarea name="age" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($age) ? $age : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="weight" class="control-label">Weight</label>
                <textarea name="weight" id="" cols="30" rows="2" class="form-control form no-resize "><?php echo isset($weight) ? $weight : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_price" class="control-label">Price</label>
                <input type="text" name="product_price" id="" cols="30" rows="2" class="form-control form no-resize " value="<?php echo isset($product_price) ? number_format($product_price) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="product_description" class="control-label">Description</label>
                <textarea name="product_description" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($product_description) ? $product_description : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="product_status" id="status" class="custom-select selevt">
                    <option value="1" <?php echo isset($product_status) && $product_status == 1 ? 'selected' : '' ?>>Available</option>
                    <option value="0" <?php echo isset($product_status) && $product_status == 0 ? 'selected' : '' ?>>Un Avaiable</option>
                </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Images</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="product_image" multiple accept="image/*" onchange="displayImg(this,$(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <?php
            if (isset($product_id)) :
                $upload_path = "uploads/product_" . $product_id;
                if (is_dir(base_app . $upload_path)) :
            ?>
                    <?php

                    $file = scandir(base_app . $upload_path);
                    foreach ($file as $img) :
                        if (in_array($img, array('.', '..')))
                            continue;


                    ?>
                        <div class="d-flex w-100 align-items-center img-item">
                            <span><img src="<?php echo base_url . $upload_path . '/' . $img ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
                            <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app . $upload_path . '/' . $img ?>"><i class="fa fa-trash"></i></button></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="product-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=product">Cancel</a>
    </div>
</div>
<script>
    function displayImg(input, _this) {
        console.log(input.files)
        var fnames = []
        Object.keys(input.files).map(k => {
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(JSON.stringify(fnames))

    }

    function delete_img($path) {
        start_loader()

        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=delete_img',
            data: {
                path: $path
            },
            method: 'POST',
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured while deleting an Image", "error");
                end_loader()
            },
            success: function(resp) {
                $('.modal').modal('hide')
                if (typeof resp == 'object' && resp.status == 'success') {
                    $('[data-path="' + $path + '"]').closest('.img-item').hide('slow', function() {
                        $('[data-path="' + $path + '"]').closest('.img-item').remove()
                    })
                    alert_toast("Image Successfully Deleted", "success");
                } else {
                    console.log(resp)
                    alert_toast("An error occured while deleting an Image", "error");
                }
                end_loader()
            }
        })
    }
    // var sub_categories = $.parseJSON('<?php //echo json_encode($sub_categories) 
                                            ?>');
    $(document).ready(function() {
        $('.rem_img').click(function() {
            _conf("Are sure to delete this image permanently?", 'delete_img', ["'" + $(this).attr('data-path') + "'"])
        })


        $('#product-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_product",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An sending error occured", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=product";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({
                            scrollTop: _this.closest('.card').offset().top
                        }, "fast");
                        end_loader()
                    } else {
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        });

        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    })
</script>