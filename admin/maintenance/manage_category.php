<?php
if((!isset($_SESSION['userdata']))  ){
	header('Location: http://localhost/furever-homes/');}
if($_SESSION['userdata']['role'] !='admin'){
	header('Location: http://localhost/furever-homes/');}
 
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `tbl_categories` where category_id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($category_id) ? "Update " : "Create New " ?> Category</h3>
	</div>
	<div class="card-body">
		<form action="" id="category-form">
			<input type="hidden" name="category_id" value="<?php echo isset($category_id) ? $category_id : '' ?>">
			<div class="form-group">
				<label for="category" class="control-label">Category Name</label>
				<textarea name="category_name" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($category_name) ? $category_name : ''; ?></textarea>
			</div>

			<div class="form-group">
				<label for="status" class="control-label">Status</label>
				<select name="category_status" id="status" class="custom-select select">
					<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
					<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
				</select>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Images</label>
				<div class="custom-file">
				<?php
			if(isset($category_image) ){$image_url = "$category_image";
			// Use parse_url() function to parse the URL
			$parsed_url = parse_url($image_url);
			// Use pathinfo() function to get the file name from the path
			$file_name = pathinfo($parsed_url['path'], PATHINFO_BASENAME);
			}
			?>
				<input type="hidden" class="custom-file-input" name="old_image" value="<?php echo isset($category_image) ? $file_name: ''; ?>">
					<input type="file" class="custom-file-input" id="customFile" name="img" accept="image/*" onchange="displayImg(this,$(this))">
					<label class="custom-file-label" for="customFile">Choose file</label>
				</div>
			</div>

			
			<div class="d-flex w-100 align-items-center img-item">
				<span><img src=" <?php echo isset($category_image) ? $category_image : '' ?>" width="150px" height="100px" style="object-fit: cover;" class="img-thumbnail" alt=""></span>
				<span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app . $upload_path . '/' . $img ?>"><i class="fa fa-trash"></i></button></span>
			</div>


		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="category-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=maintenance/category">Cancel</a>
	</div>
</div>
<script>
	function displayImg(input, _this) {
		var fnames = [];
		Object.keys(input.files).map(k => {
			fnames.push(input.files[k].name);
		});
		_this.siblings('.custom-file-label').html(JSON.stringify(fnames));
	}

	$(document).ready(function() {
		$('#category-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this);
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_category",
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
						location.href = "./?page=maintenance/category";
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
	});
</script>