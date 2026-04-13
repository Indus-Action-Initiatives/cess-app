<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Task List</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>office/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item active">Task List</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header d-flex justify-content-between align-items-center">
		<strong>Task List</strong>
		<div>
			<button class="btn btn-outline-primary btn-sm">Search</button>
			<button class="btn btn-outline-success btn-sm">Export</button>
		</div>
	</div>
	<div class="card-body">
		<table id="view-list-table" class="table table-hover align-middle">
			<thead class="table-success">
				<tr>
					<th>#</th>
					<th>File No.</th>
					<th>Date</th>
					<th>Assessment Name</th>
					<th>Establishment Type</th>
					<th>Current Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function() {
		var url='<?php echo webURL.'office/getListData/'.$type; ?>';
		$('#view-list-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: url,
				type: "GET"
			}
		});
	});
</script>