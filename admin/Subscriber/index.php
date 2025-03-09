<?php 
if((!isset($_SESSION['userdata']))  ){
	header('Location: http://localhost/furever-homes/');}
if($_SESSION['userdata']['role'] !='admin'){
	header('Location: http://localhost/furever-homes/');} ?>

<div class="card card-outline card-primary">
<div class="card-header">
			<h5 class="card-title">Subscriber List</h5>
		</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="70%">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>Subscriber</th>
						
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query( "SELECT ROW_NUMBER() OVER (ORDER BY email) AS id, email
                        FROM (
                            SELECT email FROM tbl_users  WHERE role != 'admin' 
                            UNION ALL
                            SELECT subscriber AS email FROM tbl_subscriber
                        ) AS combined_emails
                        ORDER BY id DESC;" );
                    
						while($row = $qry->fetch_assoc()):
                            
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
						
							<td><?php echo $row['email'] ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	