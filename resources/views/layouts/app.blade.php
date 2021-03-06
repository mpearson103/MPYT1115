<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>MPYT1115 Test Project</title>

	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<style>
		body {
			font-family: 'Raleway';
			margin-top: 25px;
		}
		.fa-btn {
			margin-right: 6px;
		}
		.table-text div {
			padding-top: 6px;
		}
	</style>
</head>

<body>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">Top 500 Ranked Domains Search</a>
				</div>

				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						&nbsp;
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::user()->group_id == 2)
							<li><a href="/admin"><i class="fa fa-btn fa-dashboard"></i>Admin Section</a></li>
						@endif
						<li class="navbar-text"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->username }}</li>
						<li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>

	@yield('content')
</body>
</html>