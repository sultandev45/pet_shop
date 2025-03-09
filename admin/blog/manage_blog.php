<?php

if((!isset($_SESSION['userdata']))  ){
	header('Location: http://localhost/furever-homes/');}
if($_SESSION['userdata']['role'] !='admin'){
	header('Location: http://localhost/furever-homes/');}
 

if (isset($_GET['id']) && $_GET['id'] > 0) {
    // Fetch the blog post data if editing an existing post
    $qry = $conn->query("SELECT * FROM `tbl_posts` WHERE post_id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($post_id) ? "Update Blog" : "Create New Blog" ?></h3>
    </div>
    <div class="card-body">
        <form action="" id="blog-form">
            <input type="hidden" name="post_id" value="<?php echo isset($post_id) ? $post_id : '' ?>">
            <div class="form-group">
                <label for="title" class="control-label">Title</label>
                <input type="text" class="form-control" required name="title" value="<?php echo isset($title) ? $title : '' ?>">
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Content</label>
                <textarea class="form-control summernote" name="content" required><?php echo isset($content) ? $content : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id" class="control-label">Category</label>
                <select name="category_id" id="category_id" class="custom-select" required>
                    <option value=""></option>
                    <?php
                    // Assuming `tbl_categories` table contains the list of categories
                    $qry = $conn->query("SELECT * FROM `tbl_categories` ORDER BY category_name ASC");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <!-- Populate select options with category names -->
                        <option value="<?php echo $row['category_id'] ?>" <?php echo isset($category_id) && $category_id == $row['category_id'] ? 'selected' : '' ?>><?php echo $row['category_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <?php
            if(isset($image) ){$image_url = "$image";
			// Use parse_url() function to parse the URL
			$parsed_url = parse_url($image_url);
			// Use pathinfo() function to get the file name from the path value='<?php echo $file_name?
			$file_name = pathinfo($parsed_url['path'], PATHINFO_BASENAME);
			}
			?>
                <label for="image" class="control-label">Image</label>
                <input type="file" class="form-control-file" name="image"  accept="image/*">
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="blog-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=index">Cancel</a>
    </div>
</div>
<script>
    $(document).ready(function() {


        $('#blog-form').submit(function(e) {


            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_blog", // Change the URL to the script that handles blog saving

                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=blog/index";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({
                            scrollTop: _this.closest('.card').offset().top
                        }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }


            });
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
    });
</script>