<?php 

if((!isset($_SESSION['userdata']))  ){
	header('Location: http://localhost/furever-homes/');}
if($_SESSION['userdata']['role'] !='admin'){
	header('Location: http://localhost/furever-homes/');}

if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of blog</h3>
		<div class="card-tools">
			<a href="?page=blog/manage_blog" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-stripped">
					<colgroup>
						<col width="5%">
						<col width="25%">
						<col width="10%">
						<col width="10%">
						<col width="20%">
						<col width="20%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Created At</th>
							<th>Post Title</th>
							<th>Post Content</th>
							<th>Post Image</th>
							<th>Category</th>
							<th>Auther

							

							</th>

						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT 
						p.post_id, 
						p.title, 
						p.content, 
						p.category_id, 
						p.author_id, 
						p.created_at, 
						p.image,
						u.username AS author_name,
						c.category_name
					FROM 
						tbl_posts p
					JOIN 
						tbl_users u ON p.author_id = u.user_id
					JOIN 
						tbl_categories c ON p.category_id = c.category_id
					ORDER BY 
						p.created_at DESC;
					 ");
						while ($row = $qry->fetch_assoc()) :
							
							
						?>
							<tr>
								<td class="text-center"><?php  echo $i++; ?></td>
								<td> <?php echo $row['created_at']  ?></td>
								<td><?php echo $row['title']  ?></td>
								<td><?php echo $row['content'] = strip_tags(stripslashes(html_entity_decode($row['content'])));  ?></td>
								<td><img style="width: 150px; height:150px;" src="<?php echo  $row['image'] ?>" alt=""> </td>
								<td><?php echo $row['category_name'] ?></td>
								<td><?php echo $row['author_name'] ; ?></td>


								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Action
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item" href="?page=blog/manage_blog&id=<?php echo $row['post_id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['post_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this inventory permanently?", "delete_blog", [$(this).attr('data-id')])
		})
		$('.table').DataTable();
	})

	function delete_blog($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_blog",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An sendig error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An sql error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>