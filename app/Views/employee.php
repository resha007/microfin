<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lumino - Forms</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script> 

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Employee</h1>
			</div>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Employee Details</div>
						<div class="panel-body">
							<div class="col-md-12">
								<form method="post" role="form" id="dataForm">
									<input type="hidden" class="form-control" name="id" id="id">
									<div class="form-group col-md-6">
										<label>First Name</label>
										<input class="form-control" name="first_name" id="first_name" required>
									</div>
																	
									<div class="form-group col-md-6">
										<label>Last Name</label>
										<input class="form-control" name="last_name" id="last_name" required>
									</div>
									<div class="form-group col-md-6">
										<label>Address</label>
										<input class="form-control" name="address" id="address" required>
									</div>					
									<div class="form-group col-md-6">
										<label>City</label>
										<input class="form-control" name="city" id="city" required>
									</div>
									<div class="form-group col-md-4">
										<label>DoB</label>
										<input type="date" class="form-control" name="dob" id="dob" required>
									</div>
									<div class="form-group col-md-4">
										<label>NIC</label>
										<input class="form-control" name="nic" id="nic" required>
									</div>
									<div class="form-group col-md-4">
										<label>Gender</label>
										<select class="form-control" name="gender" id="gender" required>
											<option value="1">Male</option>
											<option value="2">Female</option>
										</select>
									</div>
									<div class="form-group col-md-4">
										<label>Contact Number</label>
										<input class="form-control" name="contact_no" id="contact_no" required>
									</div>
									<div class="form-group col-md-4">
										<label>Email</label>
										<input type="email" class="form-control" name="email" id="email">
									</div>
									<div class="form-group col-md-4">
										<label>Username</label>
										<input class="form-control" name="username" id="username" required>
									</div>
									<div class="form-group col-md-4">
										<label>Type</label>
										<select class="form-control" name="type" id="type" required>
											<option value="1">Employee</option>
											<option value="2">Rider</option>
										</select>
									</div>
									<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control" name="status" id="status" required>
											<option value="1">Active</option>
											<option value="2">Inactive</option>
										</select>
									</div>


									<div class="form-group col-md-12">
										<button type="button" class="btn btn-primary" id="add"><span class="">Add</button>
										<button type="button" class="btn btn-success" id="update">Update</button>
										<button type="button" class="btn btn-danger" id="delete">Delete</button>
										<button type="reset" class="btn btn-default" id="reset">Reset</button>
									</div>
									
							</div>
							
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Current Employees</div>
					<div class="panel-body">
						<table id="dataTable" data-click-to-select="true" data-show-export="true"  data-toggle="table" data-url="employee/get"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
								<thead>
								<tr>
									<th data-field="state" data-checkbox="true"></th>
									<th data-field="id" data-sortable="true">Emp ID</th>
									<th data-field="first_name"  data-sortable="true">Fisrt Name</th>
									<th data-field="last_name" data-sortable="true">Last Name</th>
									<th data-field="address"  data-sortable="true">Address</th>
									<th data-field="city" data-sortable="true">City</th>
									<th data-field="dob"  data-sortable="true">DoB</th>
									<th data-field="nic" data-sortable="true">NIC</th>
									<th data-field="gender"  data-sortable="true">Gender</th>
									<th data-field="contact_no" data-sortable="true">Contact No</th>
									<th data-field="email" data-sortable="true">Email</th>
									<th data-field="username"  data-sortable="true">Username</th>
									<th data-field="type" data-sortable="true">Type</th>
									<th data-field="status" data-sortable="true">Status</th>
								</tr>
								</thead>
								
								
								
							</table>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>

	<script src="js/custom/employee.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>


	<script>
		var $table = $('#dataTable');
		var $remove = $('#remove');
		
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})

		function getIdSelections() {
			return $.map($table.bootstrapTable('getSelections'), function (row) {
				return row.id
			})
		}

	</script>	
</body>

</html>
